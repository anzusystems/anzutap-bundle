<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model;

use AnzuSystems\AnzutapBundle\Model\Node\AnzutapDocNode;

final readonly class AnzutapBody
{
    public function __construct(
        private EmbedContainer $embedContainer,
        private AnzutapDocNode $anzuTapBody,
    ) {
    }

    public function getEmbedContainer(): EmbedContainer
    {
        return $this->embedContainer;
    }

    public function getAnzutapBody(): AnzutapDocNode
    {
        return $this->anzuTapBody;
    }
}
