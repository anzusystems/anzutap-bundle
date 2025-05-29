<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\TransformerProvider;

use DOMElement;
use DOMText;

final readonly class MarkNodeTransformerProvider implements MarktransformerProviderInterface
{
    public function getMarkTransformerKey(DOMText|DOMElement $element): string
    {
        return $element->nodeName;
    }
}
