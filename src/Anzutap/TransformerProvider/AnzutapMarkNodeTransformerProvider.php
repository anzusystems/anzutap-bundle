<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\TransformerProvider;

use DOMElement;
use DOMText;

final readonly class AnzutapMarkNodeTransformerProvider implements MarktransformerProviderInterface
{
    public function getMarkTransformerKey(DOMText|DOMElement $element): string
    {
        return $element->nodeName;
    }
}
