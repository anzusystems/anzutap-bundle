<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class TableRowNode extends Node implements HtmlNodeInterface
{
    protected function getMarksAllowList(): array
    {
        return [];
    }

    public static function getNodeType(): string
    {
        return self::TABLE_ROW;
    }

    public function tag(): array
    {
        return ['tr'];
    }
}
