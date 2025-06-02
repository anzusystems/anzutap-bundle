<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

use Symfony\Component\Uid\Uuid;

class EmbedNode extends Node
{
    public static function getInstance(string $type, Uuid $id): self
    {
        return (new self())
            ->setAttrs([
                'id' => $id->toRfc4122(),
            ])
            ->setType($type)
        ;
    }
}
