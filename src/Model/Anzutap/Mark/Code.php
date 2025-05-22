<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Mark;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\AbstractMark;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\MarkInterface;

final class Code extends AbstractMark
{
    public static function getMarkType(): string
    {
        return 'code';
    }

    public function tag(): array
    {
        return ['code'];
    }
}
