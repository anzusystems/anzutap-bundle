<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Advert;

use AnzuSystems\AnzutapBundle\Helper\AnzutapHelper;
use AnzuSystems\AnzutapBundle\Model\Node\AdvertNode;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;

class AdvertPlacement
{
    public function __construct(
        protected string $name,
        protected int $afterChars,
        protected int $repeatCount = 1,
        protected bool $allowPlaceAdEnding = false,
        protected bool $forcePlacement = false,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAfterChars(): int
    {
        return $this->afterChars;
    }

    public function getRepeatCount(): int
    {
        return $this->repeatCount;
    }

    public function isAllowPlaceAdEnding(): bool
    {
        return $this->allowPlaceAdEnding;
    }

    public function isForcePlacement(): bool
    {
        return $this->forcePlacement;
    }

    public function placeAdvert(NodeInterface $root, ?NodeInterface $afterNode, int $lastAdvertPosition): int
    {
        $index = null === $afterNode ? 0 : AnzutapHelper::getNodeIndex($root, $afterNode);
        if (null === $index) {
            return $lastAdvertPosition;
        }

        return $this->insertAdvertNodeToIndex($root, $index + 1, $lastAdvertPosition + 1);
    }

    protected function insertAdvertNodeToIndex(NodeInterface $root, int $index, int $advertPosition): int
    {
        $root->insertNodesToIndex(
            nodes: [(new AdvertNode())->setAttrs([
                'position' => $this->getName() . '_' . $advertPosition,
            ])],
            index: $index
        );

        return $advertPosition;
    }
}
