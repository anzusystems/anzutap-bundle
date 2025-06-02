<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\SerializerBundle\Attributes\Serialize;

final class ButtonNode extends Node implements HtmlNodeInterface
{
    public static function getNodeType(): string
    {
        return self::BUTTON;
    }

    public function tag(): array
    {
        $attrs = [];
        if (false === empty($this->getAttrs()['href'])) {
            $attrs['href'] = match ($this->getAttrs()['variant'] ?? null) {
                'email' => "mailto:{$this->getAttrs()['href']}",
                'anchor' => "#{$this->getAttrs()['href']}",
                default => $this->getAttrs()['href'],
            };
        }
        if ($this->getAttrs()['external'] ?? false) {
            $attrs['target'] = '_blank';
        }
        if ($this->getAttrs()['nofollow'] ?? false) {
            $attrs['rel'] = 'nofollow';
        }
        if (false === empty($this->getAttrs()['size'])) {
            $attrs['class'] = match ($this->getAttrs()['size']) {
                'small' => 'btn btn--txt-transform-none btn--fs-xxl btn--w-auto btn--padding-m btn--inverse btn--hover-opacity',
                default => 'btn btn--txt-transform-none btn--fs-xxxl btn--w-auto btn--padding-l btn--green btn--hover-opacity',
            };
        }

        return [
            [
                'tag' => 'a',
                'attrs' => $attrs,
            ],
        ];
    }
}
