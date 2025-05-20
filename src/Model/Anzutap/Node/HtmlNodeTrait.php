<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

trait HtmlNodeTrait
{
    public function isSelfClosing(): bool
    {
        return false;
    }
}
