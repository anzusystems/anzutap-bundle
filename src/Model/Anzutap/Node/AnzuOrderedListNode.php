<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzuOrderedListNode extends AnzutapNode
{
    public static function getNodeType(): string
    {
        return self::ORDERED_LIST;
    }
}
