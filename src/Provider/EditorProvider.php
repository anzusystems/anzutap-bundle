<?php

namespace AnzuSystems\AnzutapBundle\Provider;

use AnzuSystems\AnzutapBundle\Anzutap\AnzutapEditor;
use Psr\Container\ContainerInterface;

readonly class EditorProvider
{
    public function __construct(
        private string $defaultEditorName,
        private ContainerInterface $editorLocator,
    ) {
    }

    public function getDefaultEditor(): AnzutapEditor
    {
        return $this->getEditor($this->defaultEditorName);
    }

    public function getEditor(?string $editorName = null): AnzutapEditor
    {
        $editorName = $editorName ?? $this->defaultEditorName;

        $editor = $this->editorLocator->get($editorName);
        if (false instanceof AnzutapEditor) {
            // todo exception
        }

        return $editor;
    }
}
