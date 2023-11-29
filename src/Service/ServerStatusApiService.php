<?php

namespace App\Service;

use App\Entity\ActiveUserCount;
use DateTime;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ServerStatusApiService
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,

        #[Autowire('%env(API_URL)%')]
        private readonly string $apiUrl,
    )
    {
    }

    public function fetchLastActiveUserCount(): ActiveUserCount
    {
        $resources = $this->requestApiResource(
            method: 'GET',
            resource: 'active_user_counts',
            options: [
                'itemsPerPage' => 1,
            ]
        );

        $resource = $resources[0];

        return (new ActiveUserCount())
            ->setId($resource['id'])
            ->setCreatedAt(new DateTime($resource['createdAt']))
            ->setServerId($resource['serverId'])
            ->setCount($resource['count']);
    }

    private function requestApiResource(string $method, string $resource, array $options): array
    {
        $url = $this->apiUrl . $resource;

        if (!empty($options)) {
            $url .= '?' . http_build_query($options);
        }

        $response = $this->httpClient->request(
            $method,
            $url,
            [
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ]
        );

        return $response->toArray();
    }
}