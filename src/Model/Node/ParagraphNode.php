<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class ParagraphNode extends Node implements HtmlNodeInterface
{
    public const string NODE_NAME = 'paragraph';

    public static function getNodeType(): string
    {
        return self::PARAGRAPH;
    }

    public function tag(): array
    {
        $attrs = [];
        $anchor = $this->getAttrs()['anchor'] ?? null;
        if (is_string($anchor)) {
            $attrs['id'] = $anchor;
        }

        $textAlign = $this->getAttrs()['textAlign'] ?? null;
        if ($textAlign) {
            $attrs['class'] = "align-{$textAlign}";
        }

        return [
            [
                'tag' => 'p',
                'attrs' => $attrs,
            ],
        ];
    }
}
