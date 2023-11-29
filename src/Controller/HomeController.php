<?php

namespace App\Controller;

use App\Service\ServerStatusApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/', name: 'app_home')]
    public function index(
        ServerStatusApiService $apiService,
    ): Response
    {
        $lastActiveUserCount = $apiService->fetchLastActiveUserCount();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',

            'last_active_user_count' => $lastActiveUserCount,
        ]);
    }
}
