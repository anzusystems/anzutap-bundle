<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class TableCellNode extends Node implements HtmlNodeInterface
{
    protected array $tagName = ['td'];

    public static function getAllowedNodes(): array
    {
        return [self::PARAGRAPH];
    }

    public static function getInstance(?array $attrs = null): self
    {
        return (new self())
            ->setAttrs($attrs);
    }

    public function addContent(NodeInterface $node): static
    {
        if (false === (ParagraphNode::NODE_NAME === $node->getType())) {
            $paragraph = $this->upsertFirstContentParagraph();
            $paragraph->addContent($node);

            return $this;
        }

        return parent::addContent($node);
    }

    public static function getNodeType(): string
    {
        return self::TABLE_CELL;
    }

    public function tag(): array
    {
        $attrs = [];

        $colspan = $this->getAttrs()['colspan'] ?? null;
        if ($colspan) {
            $attrs['colspan'] = $colspan;
        }

        $colWidth = $this->getAttrs()['colwidth'] ?? null;
        $colspan = $this->getAttrs()['colspan'] ?? 0;
        if ($colWidth) {
            $widths = $colWidth;

            if (count($widths) === (int) $colspan) {
                $attrs['data-colwidth'] = implode(',', $widths);
            }
        }

        $rowSpan = $this->getAttrs()['rowspan'] ?? null;
        if ($rowSpan) {
            $attrs['rowspan'] = $rowSpan;
        }

        return [
            [
                'tag' => $this->tagName[0],
                'attrs' => $attrs,
            ],
        ];
    }
}
