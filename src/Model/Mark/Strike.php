<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Strike extends AbstractMark
{
    public static function getMarkType(): string
    {
        return self::STRIKE;
    }

    public function tag(): array
    {
        return ['strike'];
    }
}
