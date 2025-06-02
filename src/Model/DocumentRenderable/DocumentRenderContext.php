<?php

namespace AnzuSystems\AnzutapBundle\Model\DocumentRenderable;

use AnzuSystems\AnzutapBundle\Model\Enum\RenderContext;

readonly class DocumentRenderContext implements DocumentRenderContextInterface
{
    public function __construct(
        protected bool $contentLockEnabled = false,
        protected bool $unlocked = false,
        protected bool $enabledAds = true,
        protected bool $wideForm = false,
        protected ?string $editorName = null,
        protected RenderContext $renderContext = RenderContext::Default,
    ) {
    }

    public function isContentLockEnabled(): bool
    {
        return $this->contentLockEnabled;
    }

    public function isUnlocked(): bool
    {
        return $this->unlocked;
    }

    public function isEnabledAds(): bool
    {
        return $this->enabledAds;
    }

    public function isWideForm(): bool
    {
        return $this->wideForm;
    }

    public function getEditorName(): ?string
    {
        return $this->editorName;
    }

    public function getRenderContext(): RenderContext
    {
        return $this->renderContext;
    }
}
