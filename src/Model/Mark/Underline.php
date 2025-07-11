<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Underline extends AbstractMark
{
    public static function getMarkType(): string
    {
        return self::UNDERLINE;
    }

    public function tag(): array
    {
        return ['u'];
    }
}
