<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Mark;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\MarkInterface;

final class Underline implements MarkInterface
{
    public static function getMarkType(): string
    {
        return 'underline';
    }

    public function tag(array $mark): array
    {
        return ['u'];
    }
}
