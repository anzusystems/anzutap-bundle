<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Mark;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\MarkInterface;

final class Subscript implements MarkInterface
{
    public static function getMarkType(): string
    {
        return 'subscript';
    }

    public function tag(array $mark): array
    {
        return ['sub'];
    }
}
