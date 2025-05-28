<?php

namespace AnzuSystems\AnzutapBundle\Model\TransformableDocument;

use AnzuSystems\AnzutapBundle\Model\Enum\RenderContext;
use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;

abstract class AbstractHtmlTransformable implements HtmlTransformableInterface
{
    protected bool $contentLockEnabled = false;
    protected bool $locked = false;
    protected bool $enabledAds = true;
    protected bool $wideForm = false;
    protected ?string $editorName = null;
    protected RenderContext $renderContext = RenderContext::Default;

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

    public function getRenderContext(): RenderContext
    {
        return $this->renderContext;
    }

    public function isWideForm(): bool
    {
        return $this->wideForm;
    }
}
