<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class Paragraph extends AbstractNode
{
    public static function getNodeType(): string
    {
        return 'paragraph';
    }

    public function tag(array $node): array
    {
        $attrs = [];
        if (false === empty($node['attrs']['anchor'])) {
            $attrs['id'] = $node['attrs']['anchor'];
        }
        if (false === empty($node['attrs']['textAlign'])) {
            $attrs['class'] = "align-{$node['attrs']['textAlign']}";
        }

        return [
            [
                'tag' => 'p',
                'attrs' => $attrs,
            ],
        ];
    }
}
