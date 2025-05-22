<?php

namespace AnzuSystems\AnzutapBundle\Model\Mark;

abstract class AbstractMark implements MarkInterface
{
    public function toArray(): array
    {
        return [
            'type' => static::getMarkType(),
        ];
    }
}
