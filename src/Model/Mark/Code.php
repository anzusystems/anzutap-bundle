<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Code extends AbstractMark
{
    public static function getMarkType(): string
    {
        return self::CODE;
    }

    public function tag(): array
    {
        return ['code'];
    }
}
