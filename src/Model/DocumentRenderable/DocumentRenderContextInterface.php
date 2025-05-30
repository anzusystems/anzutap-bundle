<?php

namespace AnzuSystems\AnzutapBundle\Model\DocumentRenderable;

use AnzuSystems\AnzutapBundle\Model\Enum\RenderContext;

interface DocumentRenderContextInterface
{
    public function isContentLockEnabled(): bool;

    public function isLocked(): bool;

    public function isEnabledAds(): bool;

    public function isWideForm(): bool;

    public function getEditorName(): ?string;

    public function getRenderContext(): RenderContext;
}
