<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class BlockquoteNode extends Node implements HtmlNodeInterface
{
    public static function getNodeType(): string
    {
        return self::BLOCKQUOTE;
    }

    public function tag(): array
    {
        return [self::getNodeType()];
    }
}
