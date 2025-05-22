<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Mark;

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
