<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Embed;

use AnzuSystems\Contracts\Entity\Interfaces\IdentifiableByUuidInterface;

interface EmbedKindInterface extends IdentifiableByUuidInterface
{
    public const string EMBED_EXTERNAL_IMAGE = 'embedExternalImage';
    public const string EMBED_EXTERNAL_IMAGE_INLINE = 'embedExternalImageInline';

    public function getNodeType(): string;
}
