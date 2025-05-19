<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class ListItem extends AbstractNode
{
    public static function getNodeType(): string
    {
        return 'listItem';
    }

    public function tag(array $node): array
    {
        return ['li'];
    }
}
