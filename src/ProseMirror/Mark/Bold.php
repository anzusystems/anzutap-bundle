<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Mark;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\MarkInterface;

final class Bold implements MarkInterface
{
    public static function getMarkType(): string
    {
        return 'bold';
    }

    public function tag(array $mark): array
    {
        return ['strong'];
    }
}
