<?php

namespace AnzuSystems\AnzutapBundle\Provider;

use AnzuSystems\AnzutapBundle\Model\Node\AnzutapEmbedNodeNode;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNode;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use AnzuSystems\SerializerBundle\Serializer;
use Psr\Container\ContainerInterface;

readonly class NodeFactory
{
    private const string EMBED_PREFIX = 'embed';

    public function __construct(
        private ContainerInterface $nodesLocator,
        private Serializer $serializer,
    ) {
    }

    public function createNode(array $data): ?AnzutapNodeInterface
    {
        if (false === isset($data['type'])) {
            return null;
        }

        return $this->getNodeInstance((string) $data['type'], $data);
    }

    private function getNodeInstance(string $type, array $data): ?AnzutapNodeInterface
    {

        if ($this->nodesLocator->has($type)) {
            /** @var class-string<AnzutapNodeInterface> $class */
            $class = $this->nodesLocator->get($type);

            return $this->serializer->fromArray($data, $class);
        }

        if (str_starts_with($type, self::EMBED_PREFIX)) {
            return $this->serializer->fromArray($data, AnzutapEmbedNodeNode::class);
        }

        return $this->serializer->fromArray($data, AnzutapNode::class);
    }
}
