<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class ContentLockNode extends Node
{
    public static function getNodeType(): string
    {
        return self::CONTENT_LOCK;
    }
}
