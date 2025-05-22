<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class AnzutapParagraphNode extends AnzutapNode implements HtmlNodeInterface
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
