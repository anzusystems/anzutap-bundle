<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\SerializerBundle\Attributes\Serialize;

final class ContentLockNode extends AnzutapNode
{
    public static function getNodeType(): string
    {
        return self::CONTENT_LOCK;
    }
}
