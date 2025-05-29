<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\Node\ParagraphNode;
use DOMElement;

class ParagraphNodeTransformer extends AbstractNodeTransformer
{
    public static function getSupportedNodeNames(): array
    {
        return [
            'p',
            'caption',
            'quote',
            'pre',
            'address',
            'code',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzutapNodeInterface $parent): AnzutapNodeInterface
    {
        return new ParagraphNode();
    }
}
