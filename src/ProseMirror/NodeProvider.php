<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\NodeInterface;
use Symfony\Contracts\Service\ServiceProviderInterface;

final readonly class NodeProvider
{
    public function __construct(
        private ServiceProviderInterface $nodeProvider,
    ) {
    }

    public function provide(string $nodeType): ?NodeInterface
    {
        if ($this->nodeProvider->has($nodeType)) {
            return $this->nodeProvider->get($nodeType);
        }

        return null;
    }
}
