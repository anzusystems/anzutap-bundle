<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class HardBreakNode extends Node implements HtmlNodeInterface
{
    public function isSelfClosing(): bool
    {
        return true;
    }

    public static function getNodeType(): string
    {
        return self::HARD_BREAK;
    }

    public function tag(): array
    {
        return ['br'];
    }
}
