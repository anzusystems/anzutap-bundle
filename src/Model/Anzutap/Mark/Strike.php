<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Mark;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\MarkInterface;

final class Strike extends AbstractMark
{
    public static function getMarkType(): string
    {
        return 'strike';
    }

    public function tag(): array
    {
        return ['strike'];
    }
}
