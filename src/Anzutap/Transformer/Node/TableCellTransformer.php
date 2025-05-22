<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Traits\AttributesTrait;
use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapParagraphNode;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapTableCellNode;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapTableHeaderNode;
use DOMElement;

final class TableCellTransformer extends AbstractNodeTransformer
{
    use AttributesTrait;

    private const string NODE_NAME_TH = 'th';
    private const string NODE_NAME_TD = 'td';

    public static function getSupportedNodeNames(): array
    {
        return [
            self::NODE_NAME_TD,
            self::NODE_NAME_TH,
        ];
    }

    public function fixEmpty(AnzutapNodeInterface $node): void
    {
        $node->addContent(new AnzutapParagraphNode());
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzutapNodeInterface $parent): AnzutapNodeInterface
    {
        $attrs = $this->getAttrs(['colspan', 'rowspan'], $element);
        $attrs = empty($attrs) ? null : $attrs;
        $nodeName = $element->nodeName;

        if ($nodeName === self::NODE_NAME_TH) {
            return AnzutapTableHeaderNode::getInstance($attrs);
        }

        return AnzutapTableCellNode::getInstance($attrs);
    }
}
