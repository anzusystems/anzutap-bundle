<?php

namespace AnzuSystems\AnzutapBundle\Serializer\Factory;

use AnzuSystems\AnzutapBundle\Model\Node\EmbedNode;
use AnzuSystems\AnzutapBundle\Model\Node\Node;
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
            return $this->serializer->fromArray($data, EmbedNode::class);
        }

        return $this->serializer->fromArray($data, Node::class);
    }
}
