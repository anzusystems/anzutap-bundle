<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model;

interface HtmlTransformableDocumentInterface
{
    public function getBody(): array;
}
