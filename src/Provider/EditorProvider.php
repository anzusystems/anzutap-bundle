<?php

namespace AnzuSystems\AnzutapBundle\Provider;

use AnzuSystems\AnzutapBundle\Anzutap\AnzutapEditor;
use Psr\Container\ContainerInterface;

class EditorProvider
{
    public function __construct(
        private readonly string $defaultEditorName,
        private readonly ContainerInterface $editorLocator,
    ) {
    }

    public function getDefaultEditor(): AnzutapEditor
    {
        return $this->getEditor($this->defaultEditorName);
    }

    public function getEditor(string $editorName): AnzutapEditor
    {
        $editor = $this->editorLocator->get($editorName);
        if (false instanceof AnzutapEditor) {
            // todo exception
        }

        return $editor;
    }
}
