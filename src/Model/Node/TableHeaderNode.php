<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class TableHeaderNode extends TableCellNode implements HtmlNodeInterface
{
    protected array $tagName = ['th'];

    public static function getInstance(?array $attrs = null): self
    {
        return (new self())
            ->setAttrs($attrs);
    }

    public static function getNodeType(): string
    {
        return self::TABLE_HEADER;
    }
}
