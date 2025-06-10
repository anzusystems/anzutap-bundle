<?php

namespace AnzuSystems\AnzutapBundle\Model\Mark;

abstract class AbstractMark implements MarkInterface
{
    public function isMarkType(string $type): bool
    {
        return $this::getMarkType() === $type;
    }

    public function toArray(): array
    {
        return [
            'type' => static::getMarkType(),
        ];
    }
}
