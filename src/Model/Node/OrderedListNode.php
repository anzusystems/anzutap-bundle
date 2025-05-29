<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class OrderedListNode extends Node implements HtmlNodeInterface
{
    public static function getNodeType(): string
    {
        return self::ORDERED_LIST;
    }

    public function tag(): array
    {
        $attrs = [];

        $order = $this->getAttrs()['order'] ?? null;
        if ($order) {
            $attrs['start'] = $order;
        }

        return [
            [
                'tag' => 'ol',
                'attrs' => $attrs,
            ],
        ];
    }
}
