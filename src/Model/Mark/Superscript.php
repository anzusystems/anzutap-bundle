<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Superscript extends AbstractMark
{
    public static function getMarkType(): string
    {
        return 'superscript';
    }

    public function tag(): array
    {
        return ['sup'];
    }
}
