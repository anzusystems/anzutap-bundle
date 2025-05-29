<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers;

use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Serializer\Factory\MarkFactory;
use AnzuSystems\SerializerBundle\Context\SerializationContext;
use AnzuSystems\SerializerBundle\Exception\SerializerException;
use AnzuSystems\SerializerBundle\Handler\Handlers\AbstractHandler;
use AnzuSystems\SerializerBundle\Metadata\Metadata;

final class MarkHandler extends AbstractHandler
{
    public function __construct(
        private readonly MarkFactory $markFactory,
    ) {
    }

    public static function supportsSerialize(mixed $value): bool
    {
        return $value instanceof MarkInterface;
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
        if (is_array($value)) {
            $content = [];

            foreach ($value as $item) {
                if (is_array($item)) {
                    $content[] = $this->markFactory->createNode($item);
                }
            }

            return $content;
        }

        return [];
    }
}
