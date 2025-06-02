<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\BulletListNode;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use DOMElement;

final class BulletListTransformer extends AbstractNodeTransformer
{
    public static function getSupportedNodeNames(): array
    {
        return [
            'ul',
            'list',
        ];
    }

    public function removeWhenEmpty(): bool
    {
        return true;
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, NodeInterface $parent): NodeInterface
    {
        return new BulletListNode();
    }
}
