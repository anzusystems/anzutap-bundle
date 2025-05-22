<?php

namespace AnzuSystems\AnzutapBundle\Provider;

use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\AnzutapBundle\Model\Mark\UnknownMark;
use AnzuSystems\SerializerBundle\Serializer;
use Psr\Container\ContainerInterface;

readonly class MarkFactory
{
    public function __construct(
        private ContainerInterface $markLocator,
        private Serializer $serializer,
    ) {
    }

    public function createNode(array $data): ?MarkInterface
    {
        if (false === isset($data['type'])) {
            return null;
        }

        return $this->getNodeInstance((string) $data['type'], $data);
    }

    private function getNodeInstance(string $type, array $data): ?MarkInterface
    {
        if ($this->markLocator->has($type)) {
            /** @var class-string<MarkInterface> $class */
            $class = $this->markLocator->get($type);

            return $this->serializer->fromArray($data, $class);
        }

        return new UnknownMark();
    }
}
