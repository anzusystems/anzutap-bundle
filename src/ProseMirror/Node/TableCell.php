<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

class TableCell extends AbstractNode
{
    protected array $tagName = ['td'];

    public static function getNodeType(): string
    {
        return 'tableCell';
    }

    public function tag(array $node): array
    {
        $attrs = [];
        if (isset($node['attrs'])) {
            if (isset($node['attrs']['colspan'])) {
                $attrs['colspan'] = $node['attrs']['colspan'];
            }
            if (isset($node['attrs']['colwidth'])) {
                $widths = $node['attrs']['colwidth'];
                if (count($widths) === (int) ($attrs['colspan'] ?? 0)) {
                    $attrs['data-colwidth'] = implode(',', $widths);
                }
            }
            if (isset($node['attrs']['rowspan'])) {
                $attrs['rowspan'] = $node['attrs']['rowspan'];
            }
        }

        return [
            [
                'tag' => $this->tagName[0],
                'attrs' => $attrs,
            ],
        ];
    }
}
