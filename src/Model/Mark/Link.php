<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

use AnzuSystems\SerializerBundle\Attributes\Serialize;

final class Link extends AbstractMark
{
    #[Serialize]
    protected array $attrs = [];

    public function getAttrs(): array
    {
        return $this->attrs;
    }

    public function setAttrs(array $attrs): self
    {
        $this->attrs = $attrs;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getMarkType(),
            'attrs' => $this->getAttrs(),
        ];
    }

    public static function getMarkType(): string
    {
        return 'link';
    }

    public function tag(): array
    {
        $markAttrs = $this->getAttrs();
        
        $attrs = [];
        if ($markAttrs['external'] ?? false) {
            $attrs['target'] = '_blank';
        }
        if ($markAttrs['nofollow'] ?? false) {
            $attrs['rel'] = 'nofollow';
        }
        if ($markAttrs['itext'] ?? false) {
            $attrs['data-itext'] = 1;
        }
        $attrs['class'] = 'link--underline';

        if (empty($markAttrs['href'])) {
            return [];
        }

        $attrs['href'] = match ($markAttrs['variant'] ?? null) {
            'email' => "mailto:{$markAttrs['href']}",
            'anchor' => "#{$markAttrs['href']}",
            default => $markAttrs['href'],
        };

        return [
            [
                'tag' => 'a',
                'attrs' => $attrs,
            ],
        ];
    }
}
