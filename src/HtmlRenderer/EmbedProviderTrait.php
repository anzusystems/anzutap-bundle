<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderableInterface;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\EmbedsAwareInterface;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;

trait EmbedProviderTrait
{
    public function getEmbed(DocumentRenderableInterface $transformable, NodeInterface $node): ?EmbedKindInterface
    {
        $document = $transformable->getBodyAware();
        if (false === ($document instanceof EmbedsAwareInterface)) {
            return null;
        }
        $embed = $document->getEmbeds()->get($node->getAttrs()['id'] ?? '');

        return $embed instanceof EmbedKindInterface ? $embed : null;
    }
}
