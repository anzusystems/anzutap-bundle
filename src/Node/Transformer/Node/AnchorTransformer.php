<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\AnzutapBundle\Node\Transformer\Traits\UrlTrait;
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

    public function transform(DOMElement $element, EmbedContainer $embedContainer, NodeInterface $parent): ?NodeInterface
    {
        $name = trim($element->getAttribute('name'));
        if (false === ('' === $name)) {
            $parent->addAttr('anchor', self::getSanitizedAnchor($name));
        }

        return null;
    }
}
