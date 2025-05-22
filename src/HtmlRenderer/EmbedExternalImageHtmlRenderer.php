<?php

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Anzutap\HtmlRendererInterface;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImage;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImageInline;
use AnzuSystems\AnzutapBundle\Model\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;

class EmbedExternalImageHtmlRenderer implements HtmlRendererInterface
{
    use EmbedProviderTrait;

    public static function getSupportedNodeNames(): array
    {
        return [
            EmbedKindInterface::EMBED_EXTERNAL_IMAGE,
            EmbedKindInterface::EMBED_EXTERNAL_IMAGE_INLINE,
        ];
    }

    public function render(AnzutapNodeInterface $node, HtmlTransformableInterface $htmlTransformable): string
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
