<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model;

use AnzuSystems\Contracts\Entity\Interfaces\IdentifiableByUuidInterface;

interface EmbedKindInterface extends IdentifiableByUuidInterface
{
    public function getNodeType(): string;
}
