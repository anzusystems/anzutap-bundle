<?php

namespace AnzuSystems\AnzutapBundle\AnzutapTransformer;

use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\AbstractNodeTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Traits\UrlTrait;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImage;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedExternalImageInline;
use AnzuSystems\AnzutapBundle\Model\EmbedKindInterface;
use DOMElement;
use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
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

    public function transform(DOMElement $element, EmbedContainer $embedContainer, AnzuTapNodeInterface $parent): ?EmbedKindInterface
    {
        $src = $this->getSrc($element);

        if (null === $src) {
            return null;
        }

        $alt = $this->getAlt($element);

        if ($this->hasParentByName($element, ['td', 'th'])) {
            return (new EmbedExternalImageInline())->setSrc($src)->setAlt($alt);
        }

        return (new EmbedExternalImage())->setSrc($src)->setAlt($alt);
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
