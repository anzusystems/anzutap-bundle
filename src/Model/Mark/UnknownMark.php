<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class UnknownMark extends AbstractMark
{
    public static function getMarkType(): string
    {
        return 'unknown';
    }

    public function tag(): array
    {
        return [];
    }
}
