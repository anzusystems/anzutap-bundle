<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

class QuoteNode extends Node
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
        return self::QUOTE;
    }
}
