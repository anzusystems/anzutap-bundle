<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class BulletList extends AbstractNode
{
    public static function getNodeType(): string
    {
        return 'bulletList';
    }

    public function tag(array $node): array
    {
        return [
            [
                'tag' => 'ul',
                'attrs' => ['class' => 'list list--bullet'],
            ],
        ];
    }
}
