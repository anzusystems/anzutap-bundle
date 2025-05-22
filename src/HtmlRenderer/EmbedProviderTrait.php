<?php

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Anzutap\HtmlRendererInterface;
use AnzuSystems\AnzutapBundle\Model\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\EmbedsAwareInterface;
use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;

trait EmbedProviderTrait
{
    public function getEmbed(HtmlTransformableInterface $transformable, AnzutapNodeInterface $node): ?EmbedKindInterface
    {
        $document = $transformable->getDocument();
        if (false === ($document instanceof EmbedsAwareInterface)) {
            return null;
        }

        dump($document->getEmbeds());
        dump($node);

        $embed = $document->getEmbeds()->get($node->getAttrs()['id'] ?? '');

        return $embed instanceof EmbedKindInterface ? $embed : null;
    }
}
