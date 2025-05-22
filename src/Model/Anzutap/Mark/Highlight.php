<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Mark;

final class Highlight extends AbstractMark
{
    public static function getMarkType(): string
    {
        return 'highlight';
    }

    public function tag(): array
    {
        return ['mark'];
    }
}
