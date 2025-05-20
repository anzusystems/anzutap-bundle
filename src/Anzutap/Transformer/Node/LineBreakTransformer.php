<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\Anzutap\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzuHardBreakNode;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNode;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
use DOMElement;

final class LineBreakTransformer extends AbstractNodeTransformer
{
    public static function getSupportedNodeNames(): array
    {
        return [
            'br',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzutapNodeInterface $parent): AnzutapNodeInterface
    {
        return new AnzuHardBreakNode();
    }
}
