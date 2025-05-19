<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\MarkInterface;
use Symfony\Contracts\Service\ServiceProviderInterface;

final readonly class MarkProvider
{
    public function __construct(
        private ServiceProviderInterface $markProvider,
    ) {
    }

    public function provide(string $markType): ?MarkInterface
    {
        if ($this->markProvider->has($markType)) {
            return $this->markProvider->get($markType);
        }

        return null;
    }
}
