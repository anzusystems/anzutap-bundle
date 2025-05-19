<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class Heading extends AbstractNode
{
    public function tag(array $node): array
    {
        $attrs = ['class' => "heading h-{$node['attrs']['level']}"];
        if (false === empty($node['attrs']['anchor'])) {
            $attrs['id'] = $node['attrs']['anchor'];
        }
        if (false === empty($node['attrs']['textAlign'])) {
            $attrs['class'] = "{$attrs['class']} align-{$node['attrs']['textAlign']}";
        }

        return [
            [
                'tag' => "h{$node['attrs']['level']}",
                'attrs' => $attrs,
            ],
        ];
    }

    public static function getNodeType(): string
    {
        return 'heading';
    }
}
