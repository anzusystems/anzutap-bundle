<?php

namespace AnzuSystems\AnzutapBundle\Model\DocumentRenderable;

use AnzuSystems\AnzutapBundle\Model\Enum\RenderContext;

readonly class DocumentRenderContext implements DocumentRenderContextInterface
{
    public function __construct(
        protected bool $contentLockEnabled = false,
        protected bool $locked = false,
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

    public function isLocked(): bool
    {
        return $this->locked;
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
