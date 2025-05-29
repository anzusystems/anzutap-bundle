<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Helper;

use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;

// TODO move this to NodeInterface/AbstractNode
final class AnzutapHelper
{
    /**
     * @param array<int, NodeInterface> $nodes
     */
    public static function insertNodesToIndex(NodeInterface $root, array $nodes, int $index): NodeInterface
    {
        $content = $root->getContent();
        $index = max(0, min($index, count($content)));

        return $root->setContent([
            ...array_slice($content, 0, $index),
            ...$nodes,
            ...array_slice($content, $index),
        ]);
    }

    public static function getNodeIndex(NodeInterface $root, NodeInterface $node): int|null
    {
        $index = array_search($node, $root->getContent(), true);

        return is_int($index) ? $index : null;
    }
}
