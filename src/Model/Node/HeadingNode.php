<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class HeadingNode extends Node implements HtmlNodeInterface
{
    public static function getInstance(int $level): self
    {
        return (new self())
            ->setAttrs([
                'level' => $level,
            ]);
    }

    public static function getNodeType(): string
    {
        return self::HEADING;
    }

    public static function getAllowedNodes(): array
    {
        return [self::TEXT];
    }

    public function tag(): array
    {
        $level = $this->getAttrs()['level'] ?? 2;
        $attrs = ['class' => "heading h-{$level}"];

        $anchor = $this->getAttrs()['anchor'] ?? null;
        if (is_string($anchor)) {
            $attrs['id'] = $anchor;
        }

        $textAlign = $this->getAttrs()['textAlign'] ?? null;
        if (is_string($textAlign)) {
            $attrs['class'] = "{$attrs['class']} align-{$textAlign}";
        }

        return [
            [
                'tag' => "h{$level}",
                'attrs' => $attrs,
            ],
        ];
    }
}
