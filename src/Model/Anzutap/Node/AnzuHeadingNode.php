<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzuHeadingNode extends AnzutapNode implements HtmlNodeInterface
{
    public static function getInstance(int $level): static
    {
        return (new static())
            ->setAttrs([
                'level' => $level,
            ]);
    }

    public static function getNodeType(): string
    {
        return self::HEADING;
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
