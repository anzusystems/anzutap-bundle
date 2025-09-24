<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderableInterface;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImage;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImageInline;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;

final class EmbedExternalImageHtmlRenderer implements HtmlRendererInterface
{
    use EmbedProviderTrait;

    public static function getSupportedNodeNames(): array
    {
        return [
            EmbedKindInterface::EMBED_EXTERNAL_IMAGE,
            EmbedKindInterface::EMBED_EXTERNAL_IMAGE_INLINE,
        ];
    }

    public function render(NodeInterface $node, DocumentRenderableInterface $documentRenderable): string
    {
        $embed = $this->getEmbed($documentRenderable, $node);

        if (null === $embed) {
            return '';
        }

        if (false === ($embed instanceof EmbedExternalImage) && false === ($embed instanceof EmbedExternalImageInline)) {
            return '';
        }

        return sprintf('<img src="%s" alt="%s"/>', $embed->getSrc(), $embed->getAlt());
    }
}
