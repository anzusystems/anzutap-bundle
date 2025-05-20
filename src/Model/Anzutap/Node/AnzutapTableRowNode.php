<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapTableRowNode extends AnzutapNode
{
    protected function getMarksAllowList(): array
    {
        return [];
    }

    public static function getNodeType(): string
    {
        return self::TABLE_ROW;
    }
}
