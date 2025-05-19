<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class HorizontalRule extends AbstractNode
{
    public function isSelfClosing(): bool
    {
        return true;
    }

    public static function getNodeType(): string
    {
        return 'horizontalRule';
    }

    public function tag(array $node): array
    {
        return ['hr'];
    }
}
