<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use DOMElement;

final class XRemoveTransformer extends AbstractNodeTransformer
{
    public function skipChildren(): bool
    {
        return true;
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, NodeInterface $parent): null
    {
        return null;
    }
}
