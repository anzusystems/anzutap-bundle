<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

// todo missing
final class Blockquote extends AbstractNode
{
    public static function getNodeType(): string
    {
        return 'blockquote';
    }

    public function tag(array $node): array
    {
        return [self::getNodeType()];
    }
}
