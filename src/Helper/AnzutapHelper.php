<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Helper;

use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;

// TODO move this to NodeInterface/AbstractNode
final class AnzutapHelper
{
    public static function getNodeIndex(NodeInterface $root, NodeInterface $node): int|null
    {
        $index = array_search($node, $root->getContent(), true);

        return is_int($index) ? $index : null;
    }

    public static function getNodeTextCharCount(NodeInterface $node): int
    {
        return mb_strlen($node->getNodeText() ?? '');
    }
}
