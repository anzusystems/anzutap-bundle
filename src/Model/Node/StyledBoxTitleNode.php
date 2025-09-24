<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class StyledBoxTitleNode extends Node
{
    public static function getNodeType(): string
    {
        return self::STYLED_BOX_TITLE;
    }
}
