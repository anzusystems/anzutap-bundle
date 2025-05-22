<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzutapTableCellNode extends AnzutapNode implements HtmlNodeInterface
{
    protected array $tagName = ['td'];

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

    public function tag(): array
    {
        $attrs = [];

        $colspan = $this->getAttrs()['colspan'] ?? null;
        if ($colspan) {
            $attrs['colspan'] =$colspan;
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
