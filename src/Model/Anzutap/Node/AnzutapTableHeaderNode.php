<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapTableHeaderNode extends AnzutapTableCellNode
{
    protected function getMarksAllowList(): array
    {
        return [];
    }

    protected function getNodeName(): string
    {
        return self::TABLE_HEADER;
    }
}
