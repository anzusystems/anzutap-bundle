<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\Node\TableNode;
use AnzuSystems\AnzutapBundle\Node\Transformer\Traits\AttributesTrait;
use DOMElement;

final class TableTransformer extends AbstractNodeTransformer
{
    use AttributesTrait;

    public function removeWhenEmpty(): bool
    {
        return true;
    }

    public static function getSupportedNodeNames(): array
    {
        return [
            'table',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzutapNodeInterface $parent): AnzutapNodeInterface
    {
        return TableNode::getInstance(
            [
                'variant' => 'default',
                'caption' => '',
            ]
        );
    }
}
