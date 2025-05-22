<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model;

interface HtmlTransformableInterface
{
    public function getDocument(): array;

    public function isContentLockEnabled(): bool;

    public function isLocked(): bool;

    public function getEditorName(): ?string;
}
