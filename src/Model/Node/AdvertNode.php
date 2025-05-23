<?php

namespace AnzuSystems\AnzutapBundle\Model\Node;

class AdvertNode extends AnzutapNode
{
    public static function getNodeType(): string
    {
        return self::ADVERT;
    }
}
