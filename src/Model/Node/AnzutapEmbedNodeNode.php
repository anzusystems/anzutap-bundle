<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

use Symfony\Component\Uid\Uuid;

class AnzutapEmbedNodeNode extends AnzutapNode
{
    public static function getInstance(string $type, Uuid $id): static
    {
        return (new static($type))
            ->setAttrs([
                'id' => $id->toRfc4122(),
            ])
        ;
    }

    protected function getMarksAllowList(): array
    {
        return [];
    }
}
