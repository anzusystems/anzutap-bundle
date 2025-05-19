<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

final class Button extends AbstractNode
{
    public static function getNodeType(): string
    {
        return 'button';
    }

    public function tag(array $node): array
    {
        $attrs = [];
        if (false === empty($node['attrs']['href'])) {
            $attrs['href'] = match ($node['attrs']['variant'] ?? null) {
                'email' => "mailto:{$node['attrs']['href']}",
                'anchor' => "#{$node['attrs']['href']}",
                default => $node['attrs']['href'],
            };
        }
        if ($node['attrs']['external'] ?? false) {
            $attrs['target'] = '_blank';
        }
        if ($node['attrs']['nofollow'] ?? false) {
            $attrs['rel'] = 'nofollow';
        }
        if (false === empty($node['attrs']['size'])) {
            $attrs['class'] = match ($node['attrs']['size']) {
                'small' => 'btn btn--txt-transform-none btn--fs-xxl btn--w-auto btn--padding-m btn--inverse btn--hover-opacity',
                default => 'btn btn--txt-transform-none btn--fs-xxxl btn--w-auto btn--padding-l btn--green btn--hover-opacity',
            };
        }

        return [
            [
                'tag' => 'a',
                'attrs' => $attrs,
            ],
        ];
    }
}
