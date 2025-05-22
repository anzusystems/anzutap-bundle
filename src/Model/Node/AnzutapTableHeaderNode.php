<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class AnzutapTableHeaderNode extends AnzutapTableCellNode implements HtmlNodeInterface
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
