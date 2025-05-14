<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapTableNode extends AnzutapNode
{
    public const string CAPTION_ATTR = 'caption';
    public function __construct(?array $attrs = null)
    {
        parent::__construct(
            type: self::TABLE,
            attrs: $attrs
        );
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
}
