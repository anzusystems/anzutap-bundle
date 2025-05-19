<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Node;

use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\NodeInterface;

abstract class AbstractNode implements NodeInterface
{
    public function isSelfClosing(): bool
    {
        return false;
    }
}
