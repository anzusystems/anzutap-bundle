<?php

namespace AnzuSystems\AnzutapBundle\Model\TransformableDocument;

use AnzuSystems\AnzutapBundle\Model\HtmlTransformableDocumentInterface;
use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;

class HtmlTransformableDocument implements HtmlTransformableDocumentInterface
{
    protected array $document = [];

    /**
     * @param array{type: string, content: array} $document
     */
    public function setDocument(array $document): self
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @return array{type: string, content: array}
     */
    public function getDocument(): array
    {
        return $this->document;
    }
}
