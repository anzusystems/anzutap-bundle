<?php

namespace AnzuSystems\AnzutapBundle\Model\Node;

class QuoteContentNode extends Node
{
    public static function getNodeType(): string
    {
        return self::QUOTE_CONTENT;
    }
}
