<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node;

use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPool;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;

final class AdvertInserter
{
    public static function placeAdverts(NodeInterface $node, AdvertPool $advertPool): void
    {
        $content = $node->getContent();
        $charactersCount = 0;
        $advertPlacement = $advertPool->getNextAdvertPlacement();
        /** @var array<string, int> $placedAdverts */
        $placedAdverts = [];

        $lastNode = $content[array_key_last($content)] ?? null;
        foreach ($content as $childNode) {
            if (null === $advertPlacement) {
                break;
            }
            if ($childNode === $lastNode && false === $advertPlacement->isAllowPlaceAdEnding()) {
                break;
            }

            $charactersCount += mb_strlen($childNode->getNodeText() ?? '');
            if ($advertPlacement->getAfterChars() < $charactersCount) {
                $placedAdverts[$advertPlacement->getName()] = $advertPlacement->placeAdvert(
                    root: $node,
                    afterNode: $childNode,
                    lastAdvertPosition: $placedAdverts[$advertPlacement->getName()] ?? 0
                );

                $charactersCount = 0;
                $advertPlacement = $advertPool->getNextAdvertPlacement();
            }
        }

        if ($advertPlacement && $advertPlacement->isAllowPlaceAdEnding() && $advertPlacement->isForcePlacement()) {
            $advertPlacement->placeAdvert(
                root: $node,
                afterNode: $lastNode,
                lastAdvertPosition: $placedAdverts[$advertPlacement->getName()] ?? 0
            );
        }
    }
}
