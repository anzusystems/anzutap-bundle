<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Helper;

use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;

// TODO move this to NodeInterface/AbstractNode
final class AnzutapHelper
{
    public static function insertNodeToIndex(AnzutapNodeInterface $root, AnzutapNodeInterface $node, int $index): AnzutapNodeInterface
    {
        $content = $root->getContent();
        $index = max(0, min($index, count($content)));

        return $root->setContent([
            ...array_slice($content, 0, $index),
            $node,
            ...array_slice($content, $index),

        ]);
    }

    public static function getNodeIndex(AnzutapNodeInterface $root, AnzutapNodeInterface $node): int|null
    {
        $index = array_search($node, $root->getContent(), true);

        return is_int($index) ? $index : null;
    }
}
