<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\HorizontalRuleNode;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use DOMElement;

final class HorizontalRuleTransformer extends AbstractNodeTransformer
{
    public static function getSupportedNodeNames(): array
    {
        return [
            'hr',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, NodeInterface $parent): NodeInterface
    {
        return new HorizontalRuleNode();
    }
}
