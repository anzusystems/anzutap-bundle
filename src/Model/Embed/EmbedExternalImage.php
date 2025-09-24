<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Embed;

use AnzuSystems\Contracts\Entity\Traits\IdentityUuidTrait;
use Symfony\Component\Uid\Uuid;

class EmbedExternalImage implements EmbedKindInterface
{
    use IdentityUuidTrait;
    use ImageEmbedTrait;

    public function __construct()
    {
        $this->setId(Uuid::v4());
    }

    public function getNodeType(): string
    {
        return self::EMBED_EXTERNAL_IMAGE;
    }
}
