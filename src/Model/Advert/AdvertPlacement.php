<?php

namespace AnzuSystems\AnzutapBundle\Model\Advert;

use AnzuSystems\AnzutapBundle\Helper\AnzutapHelper;
use AnzuSystems\AnzutapBundle\Model\Node\AdvertNode;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;

class AdvertPlacement
{
    public function __construct(
        protected string $name,
        protected int $afterChars,
        protected int $repeatCount = 1,
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

    public function placeAdvert(AnzutapNodeInterface $root, AnzutapNodeInterface $afterNode, int $lastAdvertPosition): int
    {
        $index = AnzutapHelper::getNodeIndex($root, $afterNode);
        if (null === $index) {
            return $lastAdvertPosition;
        }

        return $this->insertAdvertNodeToIndex($root, $index + 1, $lastAdvertPosition + 1);
    }

    protected function insertAdvertNodeToIndex(AnzutapNodeInterface $root, int $index, int $advertPosition): int
    {
        AnzutapHelper::insertNodesToIndex(
            root: $root,
            nodes: [(new AdvertNode())->setAttrs([
                'position' => $this->getName() . '_' . $advertPosition,
            ])],
            index: $index + 1
        );

        return $advertPosition;
    }
}
