<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\Anzutap\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzuHeadingNode;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNode;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
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

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzutapNodeInterface $parent): AnzutapNodeInterface
    {
        $level = (int) $element->nodeName[1];
        $level++;
        if ($level > 5) {
            $level = 5;
        }

        return AnzuHeadingNode::getInstance($level);
    }
}
