<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class TableNode extends Node implements HtmlNodeInterface
{
    public const string CAPTION_ATTR = 'caption';

    public static function getAllowedNodes(): array
    {
        return [self::TABLE_ROW];
    }

    public static function getInstance(?array $attrs = null): self
    {
        return (new self())
            ->setAttrs($attrs);
    }

    public function addContent(NodeInterface $node): static
    {
        if ($node instanceof ParagraphNode) {
            if (isset($this->attrs[self::CAPTION_ATTR]) && false === empty($this->attrs[self::CAPTION_ATTR])) {
                return $this;
            }

            $this->attrs[self::CAPTION_ATTR] = (string) $node->getNodeText();

            return $this;
        }
        // only table row is supported
        if (false === ($node instanceof TableRowNode)) {
            return $this;
        }

        return parent::addContent($node);
    }

    public static function getNodeType(): string
    {
        return self::TABLE;
    }

    public function tag(): array
    {
        $tableAttrs = [];

        $variant = $this->getAttrs()['variant'] ?? null;
        if ($variant) {
            $tableAttrs['class'] = $variant;
        }

        return [
            [
                'tag' => 'div',
                'attrs' => ['class' => 'table-wrapper'],
            ],
            [
                'tag' => 'table',
                'attrs' => $tableAttrs,
            ],
            [
                'tag' => 'tbody',
                'attrs' => [],
            ],
        ];
    }
}
