<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model;

use AnzuSystems\AnzutapBundle\Model\Enum\RenderContext;

interface HtmlTransformableInterface
{
    public function isContentLockEnabled(): bool;

    public function isLocked(): bool;

    public function isWideForm(): bool;

    public function getEditorName(): ?string;

    public function getRenderContext(): RenderContext;

    public function getDocument(): HtmlTransformableDocumentInterface;
}
