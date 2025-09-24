<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class QuoteContentNode extends Node
{
    public static function getNodeType(): string
    {
        return self::QUOTE_CONTENT;
    }
}
