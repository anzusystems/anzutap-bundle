<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\AnzutapBundle\Model\Node\ParagraphNode;
use AnzuSystems\AnzutapBundle\Model\Node\TextNode;
use AnzuSystems\AnzutapBundle\Node\Transformer\Traits\TextNodeTrait;
use DOMElement;
use DOMText;

class TextNodeTransformer extends AbstractNodeTransformer
{
    use TextNodeTrait;

    private const array ALLOW_EMPTY_TEXT_TYPES = [
        ParagraphNode::NODE_NAME,
    ];

    public static function getSupportedNodeNames(): array
    {
        return [
            '#text',
        ];
    }

    public function transform(DOMElement | DOMText $element, EmbedContainer $embedContainer, ?NodeInterface $parent = null): ?NodeInterface
    {
        $text = $this->getText(
            $element,
            in_array($parent?->getType(), self::ALLOW_EMPTY_TEXT_TYPES, true)
        );
        // empty text nodes are not allowed by tip-tap
        if (null === $text) {
            return null;
        }

        return TextNode::getInstance($text);
    }
}
