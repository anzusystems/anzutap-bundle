<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapTableRowNode extends AnzutapNode
{
    public function __construct(?array $attrs = null)
    {
        parent::__construct(
            type: self::TABLE_ROW,
            attrs: $attrs
        );
    }
    protected function getMarksAllowList(): array
    {
        return [];
    }
}
