<?php

namespace AnzuSystems\AnzutapBundle\Model\TransformableDocument;

use AnzuSystems\AnzutapBundle\Model\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\EmbedsAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;

final class HtmlEmbedsAwareTransformableDocument extends HtmlTransformableDocument implements EmbedsAwareInterface
{
    private ArrayCollection $embeds;

    /**
     * @param ArrayCollection<int, EmbedKindInterface> $embeds
     */
    public function setEmbeds(ArrayCollection $embeds): self
    {
        $this->embeds = $embeds;

        return $this;
    }

    /**
     * @return ArrayCollection<int, EmbedKindInterface>
     */
    public function getEmbeds(): ArrayCollection
    {
        return $this->embeds;
    }
}
