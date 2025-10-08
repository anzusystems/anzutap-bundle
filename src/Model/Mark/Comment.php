<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Comment extends AbstractMark
{
    use MarkAttributesTrait;

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'attrs' => $this->getAttrs(),
        ];
    }

    public static function getMarkType(): string
    {
        return self::COMMENT;
    }

    public function tag(): array
    {
        return [];
    }
}
