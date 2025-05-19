<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class CodeBlock extends AbstractNode
{
    public static function getNodeType(): string
    {
        return 'codeBlock';
    }

    public function tag(array $node): array
    {
        return ['pre', 'code'];
    }
}
