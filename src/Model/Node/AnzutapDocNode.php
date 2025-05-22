<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class AnzutapDocNode extends AnzutapNode
{
    public function addContent(AnzutapNodeInterface $node): AnzutapNodeInterface
    {
        if (self::HARD_BREAK === $node->getType()) {
            return $this;
        }

        if (self::TABLE_CELL === $node->getType()) {
            return $this;
        }

        if (self::TEXT === $node->getType()) {
            $paragraph = $this->upsertFirstContentParagraph();

            return $paragraph->addContent($node);
        }

        if (self::LIST_ITEM === $node->getType()) {
            $newNode = new AnzuBulletListNode();
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
