<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\AnzuOrderedListNode;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use DOMElement;

final class OrderedListTransformer extends AbstractNodeTransformer
{
    public static function getSupportedNodeNames(): array
    {
        return [
            'ol',
            'listordered',
        ];
    }

    public function removeWhenEmpty(): bool
    {
        return true;
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzutapNodeInterface $parent): AnzutapNodeInterface
    {
        return new AnzuOrderedListNode();
    }
}
