<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\TransformableDocument;

interface HtmlTransformableDocumentInterface
{
    public function getBody(): array;
}
