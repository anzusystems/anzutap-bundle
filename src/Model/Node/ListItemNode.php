<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class ListItemNode extends Node implements HtmlNodeInterface
{
    public static function getAllowedNodes(): array
    {
        return [self::PARAGRAPH];
    }

    public function addContent(NodeInterface $node): static
    {
        if (false === (self::PARAGRAPH === $node->getType())) {
            $paragraph = $this->upsertFirstContentParagraph();
            $paragraph->addContent($node);

            return $this;
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
