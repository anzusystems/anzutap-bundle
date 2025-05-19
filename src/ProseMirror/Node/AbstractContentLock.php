<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\CustomRenderNodeInterface;

abstract class AbstractContentLock extends AbstractNode implements CustomRenderNodeInterface
{
    public static function getNodeType(): string
    {
        return 'contentLock';
    }

    public function tag(array $node): array
    {
        return [];
    }
}
