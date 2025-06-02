<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\Embed\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use DOMElement;

interface AnzuNodeTransformerInterface
{
    public static function getSupportedNodeNames(): array;

    public function transform(DOMElement $element, EmbedContainer $embedContainer, NodeInterface $parent): null|NodeInterface|EmbedKindInterface;

    public function skipChildren(): bool;

    public function removeWhenEmpty(): bool;

    public function fixEmpty(NodeInterface $node): void;
}
