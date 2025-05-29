<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class TableRowNode extends Node implements HtmlNodeInterface
{
    public static function getNodeType(): string
    {
        return self::TABLE_ROW;
    }

    public function tag(): array
    {
        return ['tr'];
    }
    protected function getMarksAllowList(): array
    {
        return [];
    }
}
