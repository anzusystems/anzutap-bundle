<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Interfaces;

interface TransformableDocumentInterface
{
    /**
     * @return array{type: string, content: array}
     */
    public function getData(): array;
}
