<?php

namespace AnzuSystems\AnzutapBundle\Model\Node;

class QuoteAuthorNode extends Node
{
    public static function getNodeType(): string
    {
        return self::QUOTE_AUTHOR;
    }
}
