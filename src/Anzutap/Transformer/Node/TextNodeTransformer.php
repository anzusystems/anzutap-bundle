<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Traits\TextNodeTrait;
use AnzuSystems\AnzutapBundle\Model\Anzutap\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapParagraphNode;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapTextNode;
use DOMElement;
use DOMText;

class TextNodeTransformer extends AbstractNodeTransformer
{
    use TextNodeTrait;

    private const array ALLOW_EMPTY_TEXT_TYPES = [
        AnzutapParagraphNode::NODE_NAME,
    ];

    public static function getSupportedNodeNames(): array
    {
        return [
            '#text',
        ];
    }

    public function transform(DOMElement | DOMText $element, EmbedContainer $embedContainer, ?AnzutapNodeInterface $parent = null): ?AnzutapNodeInterface
    {
        $text = $this->getText(
            $element,
            in_array($parent?->getType(), self::ALLOW_EMPTY_TEXT_TYPES, true)
        );
        // empty text nodes are not allowed by tip-tap
        if (null === $text) {
            return null;
        }

        return AnzutapTextNode::getInstance($text);
    }
}
