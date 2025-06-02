<?php

namespace AnzuSystems\AnzutapBundle\Model\Node;

class QuoteNode extends Node
{
    public static function getNodeType(): string
    {
        return self::QUOTE;
    }
}
