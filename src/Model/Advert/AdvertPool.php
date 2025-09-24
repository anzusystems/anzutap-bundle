<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Advert;

class AdvertPool
{
    private int $currentAdvertIndex = 0;
    private int $currentAdvertUsedCount = 0;

    /**
     * @param array<int, AdvertPlacement> $adverts
     */
    public function __construct(
        private readonly array $adverts = [],
    ) {
    }

    public function getNextAdvertPlacement(): ?AdvertPlacement
    {
        if (empty($this->adverts) || $this->currentAdvertIndex >= count($this->adverts)) {
            return null;
        }

        $currentAdvert = $this->adverts[$this->currentAdvertIndex];
        $this->currentAdvertUsedCount++;

        if ($this->currentAdvertUsedCount >= $currentAdvert->getRepeatCount()) {
            $this->currentAdvertIndex++;
            $this->currentAdvertUsedCount = 0;
        }

        return $currentAdvert;
    }
}
