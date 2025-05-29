<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class ListItemNode extends Node implements HtmlNodeInterface
{
    public function addContent(NodeInterface $node): NodeInterface
    {
        if (false === (self::PARAGRAPH === $node->getType())) {
            $paragraph = $this->upsertFirstContentParagraph();

            return $paragraph->addContent($node);
        }

        return parent::addContent($node);
    }

    public static function getNodeType(): string
    {
        return self::LIST_ITEM;
    }

    public function tag(): array
    {
        return ['li'];
    }
}
