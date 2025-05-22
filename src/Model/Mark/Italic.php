<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Italic extends AbstractMark
{
    public static function getMarkType(): string
    {
        return 'italic';
    }

    public function tag(): array
    {
        return ['em'];
    }
}
