<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

use AnzuSystems\AnzutapBundle\AnzutapApp;

final class Link extends AbstractMark
{
    use MarkAttributesTrait;

    public const string VARIANT_LINK = 'link';
    public const string VARIANT_EMAIL = 'email';
    public const string VARIANT_ANCHOR = 'anchor';

    public const string ATTRIBUTE_EXTERNAL = 'external';
    public const string ATTRIBUTE_NOFOLLOW = 'nofollow';
    public const string ATTRIBUTE_VARIANT = 'variant';
    public const string ATTRIBUTE_HREF = 'href';

    public function getHref(): string
    {
        return $this->attrs[self::ATTRIBUTE_HREF] ?? AnzutapApp::EMPTY_STRING;
    }

    public function getVariant(): string
    {
        return $this->attrs[self::ATTRIBUTE_VARIANT] ?? AnzutapApp::EMPTY_STRING;
    }

    public function isVariant(string $variant): bool
    {
        return $this->getVariant() === $variant;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getMarkType(),
            'attrs' => $this->getAttrs(),
        ];
    }

    public static function getMarkType(): string
    {
        return self::LINK;
    }

    public function tag(): array
    {
        $markAttrs = $this->getAttrs();

        $attrs = [];
        if ($markAttrs[self::ATTRIBUTE_EXTERNAL] ?? false) {
            $attrs['target'] = '_blank';
        }
        $rel = array_filter([
            ($markAttrs['sponsored'] ?? false) ? 'sponsored' : null,
            ($markAttrs['nofollow'] ?? false) ? 'nofollow' : null,
        ]);
        if ($rel) {
            $attrs['rel'] = implode(',', $rel);
        }
        if ($markAttrs['itext'] ?? false) {
            $attrs['data-itext'] = 1;
        }
        $attrs['class'] = 'link--underline';

        if (empty($markAttrs[self::ATTRIBUTE_HREF])) {
            return [];
        }

        $attrs[self::ATTRIBUTE_HREF] = match ($markAttrs[self::ATTRIBUTE_VARIANT] ?? null) {
            self::VARIANT_EMAIL => "mailto:{$markAttrs[self::ATTRIBUTE_HREF]}",
            self::VARIANT_ANCHOR => "#{$markAttrs[self::ATTRIBUTE_HREF]}",
            default => $markAttrs[self::ATTRIBUTE_HREF],
        };

        return [
            [
                'tag' => 'a',
                'attrs' => $attrs,
            ],
        ];
    }
}
