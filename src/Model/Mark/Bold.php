<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class Bold extends AbstractMark
{
    public static function getMarkType(): string
    {
        return 'bold';
    }

    public function tag(): array
    {
        return ['strong'];
    }
}
