<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class AnzuHardBreakNode extends AnzutapNode implements HtmlNodeInterface
{
    public static function getNodeType(): string
    {
        return self::HARD_BREAK;
    }

    public function tag(): array
    {
        return ['br'];
    }
}
