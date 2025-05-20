<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Provider\EditorProvider;
use AnzuSystems\AnzutapBundle\Provider\NodeFactory;
use AnzuSystems\SerializerBundle\Context\SerializationContext;
use AnzuSystems\SerializerBundle\Exception\SerializerException;
use AnzuSystems\SerializerBundle\Handler\Handlers\AbstractHandler;
use AnzuSystems\SerializerBundle\Metadata\Metadata;

/**
 * todo rename NodeContentHandler
 */
final class EmbedHandler extends AbstractHandler
{
    public function __construct(
        private readonly EditorProvider $editorProvider,
        private readonly NodeFactory $nodeFactory,
    ) {
    }

    public static function supportsSerialize(mixed $value): bool
    {
        return $value instanceof AnzutapNodeInterface;
    }

    public function serialize(mixed $value, Metadata $metadata, SerializationContext $context): ?array
    {
        if ($value instanceof AnzutapNodeInterface) {
            return $value->toArray();
        }

        return null;
    }

    /**
     * @param array $value
     *
     * @throws SerializerException
     */
    public function deserialize(mixed $value, Metadata $metadata): array
    {
        // todo set parrent
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
