<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Interfaces;

/**
 * @template T of TransformableDocumentInterface
 */
interface TransformableDocumentWrapperInterface
{
    /**
     * @return T
     */
    public function getDocument(): TransformableDocumentInterface;

    public function isContentLockEnabled(): bool;

    public function isLocked(): bool;
}
