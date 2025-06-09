<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\SerializerBundle\Attributes\Serialize;

final class StyledBoxNode extends Node
{
    public static function getInstance(string $variant): self
    {
        return (new self())
            ->setAttrs([
                'variant' => $variant,
            ])
        ;
    }

    public static function getNodeType(): string
    {
        return self::STYLED_BOX;
    }
}
