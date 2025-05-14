<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\TransformerProvider;

use DOMElement;
use DOMText;

interface NodeTransformerProviderInterface
{
    public function getNodeTransformerKey(DOMElement | DOMText $element): string;
}
