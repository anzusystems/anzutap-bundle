<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class DocumentNode extends Node
{
    public function addContent(NodeInterface $node): static
    {
        if (self::HARD_BREAK === $node->getType()) {
            return $this;
        }

        if (self::TABLE_CELL === $node->getType()) {
            return $this;
        }

        if (self::TEXT === $node->getType()) {
            $paragraph = $this->upsertFirstContentParagraph();
            $paragraph->addContent($node);

            return $this;
        }

        if (self::LIST_ITEM === $node->getType()) {
            $newNode = new BulletListNode();
            $newNode->addContent($node);

            return parent::addContent($newNode);
        }

        return parent::addContent($node);
    }

    public static function getNodeType(): string
    {
        return self::DOC;
    }
}
