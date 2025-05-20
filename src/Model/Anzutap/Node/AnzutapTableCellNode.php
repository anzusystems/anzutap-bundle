<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzutapTableCellNode extends AnzutapNode
{
    public static function getInstance(?array $attrs = null): static
    {
        return (new static())
            ->setAttrs($attrs);
    }

    public function addContent(AnzutapNodeInterface $node): AnzutapNodeInterface
    {
        if (false === (AnzutapParagraphNode::NODE_NAME === $node->getType())) {
            $paragraph = $this->upsertFirstContentParagraph();

            return $paragraph->addContent($node);
        }

        return parent::addContent($node);
    }

    protected function getMarksAllowList(): array
    {
        return [];
    }

    public static function getNodeType(): string
    {
        return self::TABLE_CELL;
    }
}
