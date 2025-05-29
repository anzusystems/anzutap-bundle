<?php

namespace AnzuSystems\AnzutapBundle\Model\TransformableDocument;

use AnzuSystems\AnzutapBundle\Model\Enum\RenderContext;

final class HtmlTransformable extends AbstractHtmlTransformable
{
    public function __construct(
        private HtmlTransformableDocumentInterface $document,
        protected bool $contentLockEnabled = false,
        protected bool $locked = false,
        protected bool $enabledAds = true,
        protected bool $wideForm = false,
        protected RenderContext $renderContext = RenderContext::Default,
        protected ?string $editorName = null,
    ) {
    }

    public function getEditorName(): ?string
    {
        return $this->editorName;
    }

    public function isContentLockEnabled(): bool
    {
        return $this->contentLockEnabled;
    }

    public function isEnabledAds(): bool
    {
        return $this->enabledAds;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function getDocument(): HtmlTransformableDocumentInterface
    {
        return $this->document;
    }

    public function getRenderContext(): RenderContext
    {
        return $this->renderContext;
    }

    public function isWideForm(): bool
    {
        return $this->wideForm;
    }
}
