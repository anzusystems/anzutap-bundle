<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers;

use AnzuSystems\AnzutapBundle\Editor\EditorProvider;
use AnzuSystems\AnzutapBundle\Factory\NodeFactory;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\SerializerBundle\Context\SerializationContext;
use AnzuSystems\SerializerBundle\Exception\SerializerException;
use AnzuSystems\SerializerBundle\Handler\Handlers\AbstractHandler;
use AnzuSystems\SerializerBundle\Metadata\Metadata;

final class NodeHandler extends AbstractHandler
{
    public function __construct(
        private readonly NodeFactory $nodeFactory,
    ) {
    }

    public static function supportsSerialize(mixed $value): bool
    {
        return $value instanceof NodeInterface;
    }

    public function serialize(mixed $value, Metadata $metadata, SerializationContext $context): ?array
    {
        if ($value instanceof NodeInterface) {
            return $value->toArray();
        }

        return null;
    }

    public function deserialize(mixed $value, Metadata $metadata): array
    {
        if (is_array($value)) {
            $content = [];

            foreach ($value as $item) {
                if (is_array($item)) {
                    $content[] = $this->nodeFactory->createNode($item);
                }
            }

            return $content;
        }

        return [];
    }
}
