<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

trait HtmlNodeTrait
{
    public function isSelfClosing(): bool
    {
        return false;
    }
}
