<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\HeadingNode;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use DOMElement;

final class HeadingTransformer extends AbstractNodeTransformer
{
    public static function getSupportedNodeNames(): array
    {
        return [
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, NodeInterface $parent): NodeInterface
    {
        $level = (int) $element->nodeName[1];
        $level++;
        if ($level > 5) {
            $level = 5;
        }

        return HeadingNode::getInstance($level);
    }
}
