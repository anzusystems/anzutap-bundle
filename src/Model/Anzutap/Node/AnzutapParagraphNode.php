<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapParagraphNode extends AnzutapNode
{
    public const string NODE_NAME = 'paragraph';

    protected function getMarksAllowList(): ?array
    {
        return [];
    }

    public static function getNodeType(): string
    {
        return self::PARAGRAPH;
    }
}
