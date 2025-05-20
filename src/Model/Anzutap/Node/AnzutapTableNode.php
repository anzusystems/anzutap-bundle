<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapTableNode extends AnzutapNode implements HtmlNodeInterface
{
    public const string CAPTION_ATTR = 'caption';

    public static function getInstance(?array $attrs = null): static
    {
        return (new static())
            ->setAttrs($attrs);
    }

    public function addContent(AnzutapNodeInterface $node): AnzutapNodeInterface
    {
        if ($node instanceof AnzutapParagraphNode) {
            if (isset($this->attrs[self::CAPTION_ATTR]) && false === empty($this->attrs[self::CAPTION_ATTR])) {
                return $this;
            }

            $this->attrs[self::CAPTION_ATTR] = (string) $node->getNodeText();

            return $this;
        }
        // only table row is supported
        if (false === ($node instanceof AnzutapTableRowNode)) {
            return $this;
        }

        return parent::addContent($node);
    }

    protected function getMarksAllowList(): array
    {
        return [];
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
