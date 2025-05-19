<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class TableHeader extends TableCell
{
    protected array $tagName = ['th'];

    public static function getNodeType(): string
    {
        return 'tableHeader';
    }
}
