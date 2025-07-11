<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model;

use AnzuSystems\AnzutapBundle\Model\Embed\EmbedKindInterface;

final class EmbedContainer
{
    /**
     * @var array<string, EmbedKindInterface>
     */
    private array $embeds = [];

    public function addEmbed(EmbedKindInterface $embedDto): self
    {
        $this->embeds[$embedDto->getId()->toRfc4122()] = $embedDto;

        return $this;
    }

    /**
     * @return array<string, EmbedKindInterface>
     */
    public function getEmbeds(): array
    {
        return $this->embeds;
    }
}
