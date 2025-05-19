<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class TableRow extends AbstractNode
{
    public static function getNodeType(): string
    {
        return 'tableRow';
    }

    public function tag(array $node): array
    {
        return ['tr'];
    }
}
