<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Helper;

use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use function Symfony\Component\String\b;

// TODO move this to NodeInterface/AbstractNode
final class AnzutapHelper
{
    private const array ALLOWED_HREF_SCHEMES = ['http', 'https', 'mailto', 'tel'];

    public static function isAllowedHref(string $href): bool
    {
        // Browsers drop control characters and whitespace from a URL, so "java\tscript:" still runs as javascript.
        $scheme = b($href)
            ->replaceMatches('/[\x00-\x20\x7F]/', '')
            ->lower()
            ->match('/^([a-z][a-z\d+.\-]*):/')[1] ?? null;

        return null === $scheme || in_array($scheme, self::ALLOWED_HREF_SCHEMES, true);
    }

    public static function getNodeIndex(NodeInterface $root, NodeInterface $node): int|null
    {
        $index = array_search($node, $root->getContent(), true);

        return is_int($index) ? $index : null;
    }

    public static function getNodeTextCharCount(NodeInterface $node): int
    {
        return mb_strlen($node->getNodeText() ?? '');
    }
}
