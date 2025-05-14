<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Mark;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use DOMElement;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

interface AnzuMarkTransformerInterface
{
    public static function getSupportedNodeNames(): array;

    public function transform(DOMElement $element): array|null;

    public function supports(DOMElement $element): bool;
}
