<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Node\Transformer\Mark;

use AnzuSystems\AnzutapBundle\Model\Mark\Link;
use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\AnzutapBundle\Node\Transformer\Traits\AttributesTrait;
use AnzuSystems\AnzutapBundle\Node\Transformer\Traits\UrlTrait;
use DOMElement;

class LinkNodeTransformer extends AbstractMarkNodeTransformer
{
    use AttributesTrait;
    use UrlTrait;

    private const string NODE_URL = 'url';
    private const string NODE_EMAIL = 'email';
    private const string NODE_A = 'a';

    public static function getSupportedNodeNames(): array
    {
        return [
            self::NODE_URL,
            self::NODE_EMAIL,
            self::NODE_A,
        ];
    }

    public function supports(DOMElement $element): bool
    {
        return false === $this->isButton($element);
    }

    public function transform(DOMElement $element): MarkInterface|null
    {
        if (in_array($element->nodeName, [self::NODE_A, self::NODE_URL], true)) {
            $attrs = $this->getAnchorAttrs($element);
            if (is_array($attrs)) {
                return (new Link())->setAttrs($attrs);
            }

            return null;
        }

        if (self::NODE_EMAIL === $element->nodeName) {
            $href = $element->getAttribute('href');
            if (str_starts_with($href, 'mailto:')) {
                $href = substr($href, 7);
            }

            return (new Link())->setAttrs([
                'href' => $href,
                'variant' => 'email',
            ]);
        }

        return null;
    }

    public function getAnchorAttrs(DOMElement $element): ?array
    {
        $attrs = $this->getAttrs(
            ['href', 'clickthrough', 'size', 'target', 'rel'],
            $element,
            [
                'size' => ['large', 'small'],
                'target' => ['_blank'],
                'rel' => ['nofollow'],
            ]
        );

        if (self::isUrlInvalid($attrs['href'] ?? '')) {
            return null;
        }

        $attrs['variant'] = str_starts_with($attrs['href'], 'http') ? 'link' : 'anchor';
        if ($attrs['variant'] === 'anchor') {
            $attrs['href'] = self::getSanitizedAnchor($attrs['href']);
        }

        $attrs['nofollow'] = isset($attrs['rel']);
        $attrs['external'] = isset($attrs['target']);
        if (isset($attrs['clickthrough'])) {
            $attrs['external'] = true;
            unset($attrs['clickthrough']);
        }

        unset($attrs['rel'], $attrs['target']);

        return $attrs;
    }

    public function isButton(DOMElement $element): bool
    {
        return '1' === $element->getAttribute('btn');
    }
}
