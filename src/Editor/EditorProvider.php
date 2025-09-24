<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Editor;

use AnzuSystems\AnzutapBundle\Exception\EditorException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

readonly class EditorProvider
{
    public function __construct(
        private string $defaultEditorName,
        private ContainerInterface $editorLocator,
    ) {
    }

    /**
     * @throws EditorException
     */
    public function getEditor(?string $editorName = null): AnzutapEditor
    {
        $editorName = $editorName ?? $this->defaultEditorName;

        try {
            return $this->editorLocator->get($editorName);
        } catch (ContainerExceptionInterface) {
            throw new EditorException("Editor {$editorName} not found");
        }
    }
}
