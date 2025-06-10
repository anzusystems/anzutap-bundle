<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Highlight extends AbstractMark
{
    public static function getMarkType(): string
    {
        return self::HIGHLIGHT;
    }

    public function tag(): array
    {
        return ['mark'];
    }
}
