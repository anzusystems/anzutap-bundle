<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzuHardBreakNode extends AnzutapNode
{
    public static function getNodeType(): string
    {
        return self::HARD_BREAK;
    }
}
