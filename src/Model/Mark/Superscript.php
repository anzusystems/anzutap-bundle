<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Superscript extends AbstractMark
{
    public static function getMarkType(): string
    {
        return self::SUPERSCRIPT;
    }

    public function tag(): array
    {
        return ['sup'];
    }
}
