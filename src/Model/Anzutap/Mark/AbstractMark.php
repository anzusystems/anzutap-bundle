<?php

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Mark;

abstract class AbstractMark implements MarkInterface
{
    public function toArray(): array
    {
        return [
            'type' => static::getMarkType(),
        ];
    }
}
