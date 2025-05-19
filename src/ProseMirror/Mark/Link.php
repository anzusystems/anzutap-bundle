<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Mark;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\MarkInterface;

final class Link implements MarkInterface
{
    public static function getMarkType(): string
    {
        return 'link';
    }

    public function tag(array $mark): array
    {
        $attrs = [];
        if ($mark['attrs']['external'] ?? false) {
            $attrs['target'] = '_blank';
        }
        if ($mark['attrs']['nofollow'] ?? false) {
            $attrs['rel'] = 'nofollow';
        }
        if ($mark['attrs']['itext'] ?? false) {
            $attrs['data-itext'] = 1;
        }
        $attrs['class'] = 'link--underline';

        if (empty($mark['attrs']['href'])) {
            return [];
        }

        $attrs['href'] = match ($mark['attrs']['variant'] ?? null) {
            'email' => "mailto:{$mark['attrs']['href']}",
            'anchor' => "#{$mark['attrs']['href']}",
            default => $mark['attrs']['href'],
        };

        return [
            [
                'tag' => 'a',
                'attrs' => $attrs,
            ],
        ];
    }
}
