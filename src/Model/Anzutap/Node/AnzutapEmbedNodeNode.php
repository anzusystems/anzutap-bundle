<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

use Symfony\Component\Uid\Uuid;

class AnzutapEmbedNodeNode extends AnzutapNode
{
    public function __construct(string $type, Uuid $id)
    {
        parent::__construct(
            type: $type,
            attrs: [
                'id' => $id->toRfc4122(),
            ],
        );
    }

    protected function getMarksAllowList(): array
    {
        return [];
    }
}
