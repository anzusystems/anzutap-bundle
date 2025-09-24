<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\DocumentRenderable;

use AnzuSystems\AnzutapBundle\Model\Enum\RenderContext;

interface DocumentRenderContextInterface
{
    public function isContentLockEnabled(): bool;

    public function isUnlocked(): bool;

    public function isEnabledAds(): bool;

    public function isWideForm(): bool;

    public function getEditorName(): ?string;

    public function getRenderContext(): RenderContext;
}
