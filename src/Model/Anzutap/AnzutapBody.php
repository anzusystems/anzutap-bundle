<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNode;

final readonly class AnzutapBody
{
    public function __construct(
        private EmbedContainer $embedContainer,
        private AnzutapNode $anzuTapBody,
    ) {
    }

    public function getEmbedContainer(): EmbedContainer
    {
        return $this->embedContainer;
    }

    public function getAnzutapBody(): AnzutapNode
    {
        return $this->anzuTapBody;
    }
}
