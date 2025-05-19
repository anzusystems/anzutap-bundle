<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Mark;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\MarkInterface;

final class Code implements MarkInterface
{
    public static function getMarkType(): string
    {
        return 'code';
    }

    public function tag(array $mark): array
    {
        return ['code'];
    }
}
