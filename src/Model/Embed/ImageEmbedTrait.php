<?php

namespace AnzuSystems\AnzutapBundle\Model\Embed;

use AnzuSystems\SerializerBundle\Attributes\Serialize;

trait ImageEmbedTrait
{
    #[Serialize]
    private string $src = '';

    #[Serialize]
    private string $alt = '';

    public function getSrc(): string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }
}
