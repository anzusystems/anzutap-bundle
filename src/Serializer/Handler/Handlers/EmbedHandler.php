<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Provider\EditorProvider;
use AnzuSystems\SerializerBundle\Context\SerializationContext;
use AnzuSystems\SerializerBundle\Exception\SerializerException;
use AnzuSystems\SerializerBundle\Handler\Handlers\AbstractHandler;
use AnzuSystems\SerializerBundle\Metadata\Metadata;

final class EmbedHandler extends AbstractHandler
{
    public function __construct(
        private readonly EditorProvider $editorProvider,
    ) {
    }

    public static function supportsSerialize(mixed $value): bool
    {
        return $value instanceof AnzutapNodeInterface;
    }

    public function serialize(mixed $value, Metadata $metadata, SerializationContext $context): array
    {
        return [];
    }

//    public static function supportsDeserialize(mixed $value, string $type): bool
//    {
//    }

    /**
     * @param array $value
     *
     * @throws SerializerException
     */
    public function deserialize(mixed $value, Metadata $metadata): ?AnzutapNodeInterface
    {
//        dump($value);
        $editor = $this->editorProvider->getDefaultEditor();
//        $editor->getNodeTransformer()
//        dump($editor);

        return null;
    }
}
