<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Factory;

use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\AnzutapBundle\Model\Mark\UnknownMark;
use AnzuSystems\SerializerBundle\Serializer;
use Psr\Container\ContainerInterface;

final readonly class MarkFactory
{
    public function __construct(
        private ContainerInterface $markLocator,
        private Serializer $serializer,
    ) {
    }

    public function createNode(array $data): MarkInterface
    {
        if (false === isset($data['type'])) {
            return $this->createUnknownMark($data);
        }

        return $this->getNodeInstance((string) $data['type'], $data);
    }

    private function getNodeInstance(string $type, array $data): MarkInterface
    {
        if ($this->markLocator->has($type)) {
            /** @var class-string<MarkInterface> $class */
            $class = $this->markLocator->get($type);
            /** @var MarkInterface $mark */
            $mark = $this->serializer->fromArray($data, $class);

            return $mark;
        }

        return $this->createUnknownMark($data);
    }

    private function createUnknownMark(array $data): MarkInterface
    {
        /** @var UnknownMark $mark */
        $mark = $this->serializer->fromArray($data, UnknownMark::class);
        if (isset($data['type'])) {
            $mark->setType($data['type']);
        }

        return $mark;
    }
}
