<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Helper;

use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;

// TODO move this to NodeInterface/AbstractNode
final class AnzutapHelper
{
    public static function insertNodeToPosition(AnzutapNodeInterface $root, AnzutapNodeInterface $node, int $position): AnzutapNodeInterface
    {
        $content = $root->getContent();
        $position = max(0, min($position, count($content)));

        return $root->setContent([
            ...array_slice($content, 0, $position),
            $node,
            ...array_slice($content, $position),

        ]);
    }

    public static function getNodeIndex(AnzutapNodeInterface $root, AnzutapNodeInterface $node): int|null
    {
        $index = array_search($node, $root->getContent(), true);

        return is_int($index) ? $index : null;
    }
}
