<?php

namespace AnzuSystems\AnzutapBundle\Model\TransformableDocument;

use AnzuSystems\AnzutapBundle\Model\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\EmbedsAwareInterface;
use Doctrine\Common\Collections\ArrayCollection;

final class HtmlEmbedsAwareTransformableDocument extends HtmlTransformableDocument implements EmbedsAwareInterface
{
    /**
     * @param array{type: string, content: array} $body
     * @param ArrayCollection<int, EmbedKindInterface> $embeds
     */
    public function __construct(
        protected array $body = [],
        private ArrayCollection $embeds,
    ) {
        parent::__construct($body);
    }

    /**
     * @return ArrayCollection<int, EmbedKindInterface>
     */
    public function getEmbeds(): ArrayCollection
    {
        return $this->embeds;
    }
}
