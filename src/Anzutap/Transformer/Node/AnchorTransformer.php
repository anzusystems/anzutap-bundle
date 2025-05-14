<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Traits\UrlTrait;
use AnzuSystems\AnzutapBundle\Model\Anzutap\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
use DOMElement;

final class AnchorTransformer extends AbstractNodeTransformer
{
    use UrlTrait;

    public static function getSupportedNodeNames(): array
    {
        return [
            'anchor',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzutapNodeInterface $parent): ?AnzutapNodeInterface
    {
        $name = trim($element->getAttribute('name'));
        if (false === ('' === $name)) {
            $parent->addAttr('anchor', self::getSanitizedAnchor($name));
        }

        return null;
    }
}
