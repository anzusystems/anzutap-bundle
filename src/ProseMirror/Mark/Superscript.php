<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Mark;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\MarkInterface;

final class Superscript implements MarkInterface
{
    public static function getMarkType(): string
    {
        return 'superscript';
    }

    public function tag(array $mark): array
    {
        return ['sup'];
    }
}
