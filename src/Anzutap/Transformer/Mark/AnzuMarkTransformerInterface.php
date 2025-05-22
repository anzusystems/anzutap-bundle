<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Mark;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\MarkInterface;
use DOMElement;

interface AnzuMarkTransformerInterface
{
    public static function getSupportedNodeNames(): array;

    public function transform(DOMElement $element): MarkInterface|null;

    public function supports(DOMElement $element): bool;
}
