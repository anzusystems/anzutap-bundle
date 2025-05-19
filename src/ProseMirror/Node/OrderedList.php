<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class OrderedList extends AbstractNode
{
    public static function getNodeType(): string
    {
        return 'orderedList';
    }

    public function tag(array $node): array
    {
        $attrs = [];

        if (isset($node['attrs']['order'])) {
            $attrs['start'] = $node['attrs']['order'];
        }

        return [
            [
                'tag' => 'ol',
                'attrs' => $attrs,
            ],
        ];
    }
}
