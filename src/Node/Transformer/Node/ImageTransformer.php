<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Node;

use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImage;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImageInline;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\AnzutapBundle\Node\Transformer\Traits\UrlTrait;
use DOMElement;
use Symfony\Component\String\ByteString;

class ImageTransformer extends AbstractNodeTransformer
{
    use UrlTrait;

    public static function getSupportedNodeNames(): array
    {
        return [
            'img',
        ];
    }

    public function transform(DOMElement $element, EmbedContainer $embedContainer, NodeInterface $parent): ?EmbedKindInterface
    {
        $src = $this->getSrc($element);

        if (null === $src) {
            return null;
        }

        $alt = $this->getAlt($element);

        if ($this->hasParentByName($element, ['td', 'th'])) {
            return (new EmbedExternalImageInline())->setSrc($src)->setAlt((string) $alt);
        }

        return (new EmbedExternalImage())->setSrc($src)->setAlt((string) $alt);
    }

    private function getAlt(DOMElement $element): ?string
    {
        $title = $element->getAttribute('alt');
        if (empty($title)) {
            return null;
        }

        return (new ByteString(urldecode($title)))->toUnicodeString()->toString();
    }

    private function getSrc(DOMElement $element): ?string
    {
        $href = $element->getAttribute('src');
        if (self::isUrlInvalid($href)) {
            return null;
        }

        return $href;
    }
}
