<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzutapListItemNode extends AnzutapNode
{
    public function __construct(?array $attrs = null)
    {
        parent::__construct(
            type: self::LIST_ITEM,
            attrs: $attrs
        );
    }

    public function addContent(AnzutapNodeInterface $node): AnzutapNodeInterface
    {
        if (false === (self::PARAGRAPH === $node->getType())) {
            $paragraph = $this->upsertFirstContentParagraph();

            return $paragraph->addContent($node);
        }

        return parent::addContent($node);
    }
}
