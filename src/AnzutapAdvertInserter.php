<?php

namespace AnzuSystems\AnzutapBundle;

use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPool;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;

final class AnzutapAdvertInserter
{
    public static function insert(AnzutapNodeInterface $node, AdvertPool $advertPool): void
    {
        $content = $node->getContent();
        if (empty($content)) {
            return;
        }

        $charactersCount = 0;
        $lastAdvertPosition = 0;
        $advertPlacement = $advertPool->getNextAdvertPlacement();

        foreach ($content as $childNode) {
            if (null === $advertPlacement) {
                break;
            }

            $charactersCount += mb_strlen($childNode->getNodeText() ?? '');

            if ($advertPlacement->getAfterChars() < $charactersCount) {
                $lastAdvertPosition = $advertPlacement->placeAdvert($node, $childNode, $lastAdvertPosition);
                $charactersCount = 0;
                $advertPlacement = $advertPool->getNextAdvertPlacement();
            }
        }
    }
}
