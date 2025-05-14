<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\TransformerProvider;

use DOMElement;
use DOMText;

final readonly class AnzutapNodeTransformerProvider implements NodeTransformerProviderInterface
{
    public function getNodeTransformerKey(DOMElement | DOMText $element): string
    {
        return $element->nodeName;
    }
}
