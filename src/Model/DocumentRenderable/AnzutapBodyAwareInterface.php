<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\DocumentRenderable;

interface AnzutapBodyAwareInterface
{
    /**
     * @return array{type: string, content: array}
     */
    public function getBody(): array;
}
