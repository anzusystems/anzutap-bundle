<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use DOMElement;

abstract class AbstractNodeTransformer implements AnzuNodeTransformerInterface
{
    public static function getSupportedNodeNames(): array
    {
        return [];
    }

    public function skipChildren(): bool
    {
        return false;
    }

    public function removeWhenEmpty(): bool
    {
        return false;
    }

    public function fixEmpty(AnzutapNodeInterface $node): void
    {
    }

    protected function hasParentByName(DOMElement $element, array $nodeNames): bool
    {
        if ($element->parentNode instanceof DOMElement) {
            if (in_array($element->nodeName, $nodeNames, true)) {
                return true;
            }

            if ($this->hasParentByName($element->parentNode, $nodeNames)) {
                return true;
            }
        }

        return false;
    }
}
