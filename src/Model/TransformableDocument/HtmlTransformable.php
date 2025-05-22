<?php

namespace AnzuSystems\AnzutapBundle\Model\TransformableDocument;

use AnzuSystems\AnzutapBundle\Model\HtmlTransformableDocumentInterface;
use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;

final class HtmlTransformable implements HtmlTransformableInterface
{
    private bool $contentLockEnabled = false;
    private bool $locked = false;
    private ?string $editorName = null;
    private HtmlTransformableDocumentInterface $document;

    public function getEditorName(): ?string
    {
        return $this->editorName;
    }

    public function setEditorName(?string $editorName): HtmlTransformable
    {
        $this->editorName = $editorName;
        return $this;
    }

    public function isContentLockEnabled(): bool
    {
        return $this->contentLockEnabled;
    }

    public function setContentLockEnabled(bool $contentLockEnabled): HtmlTransformable
    {
        $this->contentLockEnabled = $contentLockEnabled;
        return $this;
    }

    public function isLocked(): bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): HtmlTransformable
    {
        $this->locked = $locked;
        return $this;
    }

    public function getDocument(): HtmlTransformableDocumentInterface
    {
        return $this->document;
    }

    public function setDocument(HtmlTransformableDocumentInterface $document): HtmlTransformable
    {
        $this->document = $document;
        return $this;
    }
}
