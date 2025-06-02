<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\DocumentRenderable;

use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;

interface DocumentRenderableInterface
{
    public function getBodyAware(): AnzutapBodyAwareInterface;

    public function getContext(): DocumentRenderContextInterface;

    public function getRootNode(): NodeInterface;
}
