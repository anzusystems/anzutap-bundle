<?php

namespace AnzuSystems\AnzutapBundle\Model\DocumentRenderable;

use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;

readonly class DocumentRenderable implements DocumentRenderableInterface
{
    public function __construct(
        private AnzutapBodyAwareInterface $bodyAware,
        private DocumentRenderContextInterface $context,
        private NodeInterface $nodeRoot
    ) {
    }

    public function getBodyAware(): AnzutapBodyAwareInterface
    {
        return $this->bodyAware;
    }

    public function getContext(): DocumentRenderContextInterface
    {
        return $this->context;
    }

    public function getRootNode(): NodeInterface
    {
        return $this->nodeRoot;
    }
}
