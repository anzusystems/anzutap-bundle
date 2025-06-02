<?php

namespace AnzuSystems\AnzutapBundle\Factory;

use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\AnzutapBodyAwareInterface;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderable;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderableInterface;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderContextInterface;
use AnzuSystems\AnzutapBundle\Model\Node\DocumentNode;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\SerializerBundle\Serializer;

final readonly class DocumentRenderableFactory
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    public function createRenderable(
        AnzutapBodyAwareInterface $bodyAware,
        DocumentRenderContextInterface $documentRenderContext,
    ): DocumentRenderableInterface {
        /** @var NodeInterface $nodeRoot */
        $nodeRoot = $this->serializer->fromArray($bodyAware->getBody(), DocumentNode::class);

        return new DocumentRenderable($bodyAware, $documentRenderContext, $nodeRoot);
    }

    public static function createBodyAware(array $data): AnzutapBodyAwareInterface
    {
        return new readonly class($data) implements AnzutapBodyAwareInterface {
            public function __construct(
                private array $data,
            ) {
            }

            public function getBody(): array
            {
                return $this->data;
            }
        };
    }
}
