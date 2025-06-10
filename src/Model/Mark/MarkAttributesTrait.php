<?php

namespace AnzuSystems\AnzutapBundle\Model\Mark;

use AnzuSystems\SerializerBundle\Attributes\Serialize;

trait MarkAttributesTrait
{
    #[Serialize]
    protected array $attrs = [];

    public function getAttrs(): array
    {
        return $this->attrs;
    }

    public function setAttrs(array $attrs): self
    {
        $this->attrs = $attrs;

        return $this;
    }

    public function hasAttr(string $name): bool
    {
        return array_key_exists($name, $this->attrs);
    }

    public function setAttr(string $name, mixed $value): self
    {
        $this->attrs[$name] = $value;

        return $this;
    }

    public function getAttr(string $key): mixed
    {
        return $this->attrs[$key] ?? null;
    }
}
