<?php

namespace AnzuSystems\AnzutapBundle\Node;

use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPool;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;

final class AdvertInserter
{
    public static function placeAdverts(AnzutapNodeInterface $node, AdvertPool $advertPool): void
    {
        $content = $node->getContent();
        if (empty($content)) {
            return;
        }

        $charactersCount = 0;
        $advertPlacement = $advertPool->getNextAdvertPlacement();
        /** @var array<class-string, int> $placedAdverts */
        $placedAdverts = [];

        foreach ($content as $childNode) {
            if (null === $advertPlacement) {
                break;
            }

            $charactersCount += mb_strlen($childNode->getNodeText() ?? '');
            if ($advertPlacement->getAfterChars() < $charactersCount) {
                $placedAdverts[$advertPlacement::class] = $advertPlacement->placeAdvert(
                    root: $node,
                    afterNode: $childNode,
                    lastAdvertPosition: $placedAdverts[$advertPlacement::class] ?? 0
                );

                $charactersCount = 0;
                $advertPlacement = $advertPool->getNextAdvertPlacement();
            }
        }
    }
}
