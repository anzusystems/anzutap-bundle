<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class Table extends AbstractNode
{
    public static function getNodeType(): string
    {
        return 'table';
    }

    public function tag(array $node): array
    {
        $tableAttrs = [];
        if (false === empty($node['attrs']['variant'])) {
            $tableAttrs['class'] = $node['attrs']['variant'];
        }

        return [
            [
                'tag' => 'div',
                'attrs' => ['class' => 'table-wrapper'],
            ],
            [
                'tag' => 'table',
                'attrs' => $tableAttrs,
            ],
            [
                'tag' => 'tbody',
                'attrs' => [],
            ],
        ];
    }
}
