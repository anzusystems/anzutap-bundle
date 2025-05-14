<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node;

use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Traits\AttributesTrait;
use AnzuSystems\AnzutapBundle\Model\Anzutap\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapTableNode;
use DOMElement;

final class TableTransformer extends AbstractNodeTransformer
{
    use AttributesTrait;

    public function removeWhenEmpty(): bool
    {
        return true;
    }

    public static function getSupportedNodeNames(): array
    {
        return [
            'table',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzutapNodeInterface $parent): AnzutapNodeInterface
    {
        return new AnzutapTableNode(
            attrs: [
                'variant' => 'default',
                'caption' => '',
            ],
        );
    }
}
