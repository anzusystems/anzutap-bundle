<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\TransformerProvider;

use DOMElement;
use DOMText;

final readonly class NodeTransformerProvider implements NodeTransformerProviderInterface
{
    public function getNodeTransformerKey(DOMElement | DOMText $element): string
    {
        return $element->nodeName;
    }
}
