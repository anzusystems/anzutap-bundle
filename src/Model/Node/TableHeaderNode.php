<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class TableHeaderNode extends TableCellNode implements HtmlNodeInterface
{
    protected array $tagName = ['th'];

    protected function getMarksAllowList(): array
    {
        return [];
    }

    public static function getNodeType(): string
    {
        return self::TABLE_HEADER;
    }
}
