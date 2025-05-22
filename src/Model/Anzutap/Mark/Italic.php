<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Mark;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\MarkInterface;

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
