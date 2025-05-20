<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapHorizontalRuleNode extends AnzutapNode
{

    protected function getMarksAllowList(): ?array
    {
        return [];
    }

    public static function getNodeType(): string
    {
        return self::HORIZONTAL_RULE;
    }
}
