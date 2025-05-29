<?php

namespace AnzuSystems\AnzutapBundle\Model\TransformableDocument;

class HtmlTransformableDocument implements HtmlTransformableDocumentInterface
{
    /**
     * @param array{type: string, content: array} $body
     */
    public function __construct(
        protected array $body = []
    ) {
    }

    /**
     * @return array{type: string, content: array}
     */
    public function getBody(): array
    {
        return $this->body;
    }
}
