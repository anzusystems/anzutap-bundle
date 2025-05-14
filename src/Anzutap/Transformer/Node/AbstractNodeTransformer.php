<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;

abstract class AbstractNodeTransformer implements AnzuNodeTransformerInterface
{
    public static function getSupportedNodeNames(): array
    {
        return [];
    }

    public function skipChildren(): bool
    {
        return false;
    }

    public function removeWhenEmpty(): bool
    {
        return false;
    }

    public function fixEmpty(AnzutapNodeInterface $node): void
    {
    }
}
