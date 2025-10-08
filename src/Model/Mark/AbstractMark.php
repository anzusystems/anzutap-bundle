<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

abstract class AbstractMark implements MarkInterface
{
    public function getType(): string
    {
        return static::getMarkType();
    }

    public function isMarkType(string $type): bool
    {
        return $this->getType() === $type;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
