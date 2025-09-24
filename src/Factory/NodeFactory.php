<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Factory;

use AnzuSystems\AnzutapBundle\Model\Node\EmbedNode;
use AnzuSystems\AnzutapBundle\Model\Node\Node;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\SerializerBundle\Serializer;
use Psr\Container\ContainerInterface;

final readonly class NodeFactory
{
    private const string EMBED_PREFIX = 'embed';

    public function __construct(
        private ContainerInterface $nodesLocator,
        private Serializer $serializer,
    ) {
    }

    public function createNode(array $data): NodeInterface
    {
        if (false === isset($data['type'])) {
            return $this->createUnknownNode($data);
        }

        return $this->getNodeInstance((string) $data['type'], $data);
    }

    private function getNodeInstance(string $type, array $data): NodeInterface
    {
        if ($this->nodesLocator->has($type)) {
            /** @var class-string<NodeInterface> $class */
            $class = $this->nodesLocator->get($type);
            /** @var NodeInterface $node */
            $node = $this->serializer->fromArray($data, $class);

            return $node;
        }

        if (str_starts_with($type, self::EMBED_PREFIX)) {
            /** @var EmbedNode $node */
            $node = $this->serializer->fromArray($data, EmbedNode::class);

            return $node;
        }

        return $this->createUnknownNode($data);
    }

    private function createUnknownNode(array $data): NodeInterface
    {
        /** @var Node $node */
        $node = $this->serializer->fromArray($data, Node::class);

        return $node;
    }
}
