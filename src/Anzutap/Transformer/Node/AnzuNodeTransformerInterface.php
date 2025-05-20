<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\Anzutap\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\EmbedKindInterface;
use DOMElement;

interface AnzuNodeTransformerInterface
{
    public static function getSupportedNodeNames(): array;

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzutapNodeInterface $parent): null|AnzutapNodeInterface|EmbedKindInterface;

    public function skipChildren(): bool;

    public function removeWhenEmpty(): bool;

    public function fixEmpty(AnzutapNodeInterface $node): void;
}
