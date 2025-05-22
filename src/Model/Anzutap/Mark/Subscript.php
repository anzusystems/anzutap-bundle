<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Mark;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\MarkInterface;

final class Subscript extends AbstractMark
{
    public static function getMarkType(): string
    {
        return 'subscript';
    }

    public function tag(): array
    {
        return ['sub'];
    }
}
