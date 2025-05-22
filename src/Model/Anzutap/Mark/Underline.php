<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Mark;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\MarkInterface;

final class Underline extends AbstractMark
{
    public static function getMarkType(): string
    {
        return 'underline';
    }

    public function tag(): array
    {
        return ['u'];
    }
}
