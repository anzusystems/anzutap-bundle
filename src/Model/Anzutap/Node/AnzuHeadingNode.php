<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzuHeadingNode extends AnzutapNode
{
    public static function getInstance(int $level): static
    {
        return (new static())
            ->setAttrs([
                'level' => $level,
            ]);
    }

    public static function getNodeType(): string
    {
        return self::HEADING;
    }
}
