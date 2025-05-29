<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model;

use AnzuSystems\AnzutapBundle\Model\Node\DocumentNode;

final readonly class AnzutapBody
{
    public function __construct(
        private EmbedContainer $embedContainer,
        private DocumentNode $anzuTapBody,
    ) {
    }

    public function getEmbedContainer(): EmbedContainer
    {
        return $this->embedContainer;
    }

    public function getAnzutapBody(): DocumentNode
    {
        return $this->anzuTapBody;
    }
}
