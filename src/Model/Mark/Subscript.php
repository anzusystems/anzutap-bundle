<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Subscript extends AbstractMark
{
    public static function getMarkType(): string
    {
        return self::SUBSCRIPT;
    }

    public function tag(): array
    {
        return ['sub'];
    }
}
