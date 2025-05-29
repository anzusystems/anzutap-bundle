<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\HardBreakNode;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use DOMElement;

final class LineBreakTransformer extends AbstractNodeTransformer
{
    public static function getSupportedNodeNames(): array
    {
        return [
            'br',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, NodeInterface $parent): NodeInterface
    {
        return new HardBreakNode();
    }
}
