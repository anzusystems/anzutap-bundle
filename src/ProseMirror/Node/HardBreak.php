<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class HardBreak extends AbstractNode
{
    public function isSelfClosing(): bool
    {
        return true;
    }

    public static function getNodeType(): string
    {
        return 'hardBreak';
    }

    public function tag(array $node): array
    {
        return ['br'];
    }
}
