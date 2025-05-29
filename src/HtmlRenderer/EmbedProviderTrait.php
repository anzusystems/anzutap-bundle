<?php

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Model\Embed\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\EmbedsAwareInterface;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlTransformableInterface;

trait EmbedProviderTrait
{
    public function getEmbed(HtmlTransformableInterface $transformable, AnzutapNodeInterface $node): ?EmbedKindInterface
    {
        $document = $transformable->getDocument();
        if (false === ($document instanceof EmbedsAwareInterface)) {
            return null;
        }
        $embed = $document->getEmbeds()->get($node->getAttrs()['id'] ?? '');

        return $embed instanceof EmbedKindInterface ? $embed : null;
    }
}
