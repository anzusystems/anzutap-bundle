<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\TransformableDocument;

use AnzuSystems\AnzutapBundle\Model\Embed\EmbedKindInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface EmbedsAwareInterface
{
    /**
     * @return ArrayCollection<string, EmbedKindInterface>
     */
    public function getEmbeds(): ArrayCollection;
}
