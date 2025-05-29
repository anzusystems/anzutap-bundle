<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\AnzutapBundle\Model\Node\TableRowNode;
use DOMElement;

final class TableRowTransformer extends AbstractNodeTransformer
{
    public function removeWhenEmpty(): bool
    {
        return true;
    }

    public static function getSupportedNodeNames(): array
    {
        return [
            'tr',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, NodeInterface $parent): NodeInterface
    {
        return new TableRowNode();
    }
}
