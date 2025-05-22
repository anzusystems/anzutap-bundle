<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Mark;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\MarkInterface;

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
