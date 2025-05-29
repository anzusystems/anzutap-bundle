<?php

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImage;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImageInline;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\AnzutapBundle\Model\TransformableDocument\HtmlTransformableInterface;

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

    public function render(NodeInterface $node, HtmlTransformableInterface $htmlTransformable): string
    {
        $embed = $this->getEmbed($htmlTransformable, $node);

        if (null === $embed) {
            return '';
        }

        if (false === ($embed instanceof EmbedExternalImage) && false === ($embed instanceof EmbedExternalImageInline)) {
            return '';
        }

        return sprintf('<img src="%s" alt="%s"/>', $embed->getSrc(), $embed->getAlt());
    }
}
