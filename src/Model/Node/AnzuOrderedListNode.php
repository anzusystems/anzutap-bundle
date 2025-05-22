<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class AnzuOrderedListNode extends AnzutapNode implements HtmlNodeInterface
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
