<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Interfaces;

interface CustomRenderNodeInterface extends NodeInterface
{
    public function render(array $node, TransformableDocumentWrapperInterface $transformableDocument): string;
}
