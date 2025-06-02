<?php

namespace AnzuSystems\AnzutapBundle\Model\Node;

class AdvertNode extends Node
{
    public static function getNodeType(): string
    {
        return self::ADVERT;
    }
}
