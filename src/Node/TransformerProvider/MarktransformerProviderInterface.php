<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\TransformerProvider;

use DOMElement;
use DOMText;

interface MarktransformerProviderInterface
{
    public function getMarkTransformerKey(DOMElement | DOMText $element): string;
}
