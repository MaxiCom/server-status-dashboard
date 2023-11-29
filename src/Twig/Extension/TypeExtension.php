<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use http\Exception\InvalidArgumentException;
use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

final class TypeExtension extends AbstractExtension
{
    public function getTests(): array
    {
        return ['of_type' => new TwigTest('of_type', [$this, 'ofType'])];
    }

    public function ofType(mixed $var, string $test, string $class = null): bool
    {
        return match ($test) {
            'array' => is_array($var),
            default => throw new InvalidArgumentException(sprintf(`Invalid "%s" type test.`, $test))
        };
    }
}