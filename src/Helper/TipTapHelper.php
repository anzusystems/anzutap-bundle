<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Helper;

use AnzuSystems\AnzutapBundle\AnzutapApp;

final class TipTapHelper
{
    private const string TEXT_NODE = 'text';

    public static function getTopLevelNodePosition(array $body, string $nodeName): ?int
    {
        $topLevelContent = self::getTopLevelNodes($body);

        $i = AnzutapApp::ZERO;
        foreach ($topLevelContent as $value) {
            if (self::isNodeType($value, $nodeName)) {
                return $i;
            }
            $i++;
        }

        return null;
    }

    public static function isNodeType(array $node, string $type): bool
    {
        return isset($node['type']) && $node['type'] === $type;
    }

    public static function insertNodeToPosition(array $body, array $node, int $position): array
    {
        $topLevelNodes = self::getTopLevelNodes($body);
        $topLevelNodesCount = count($topLevelNodes);
        $position = $position > $topLevelNodesCount ? $topLevelNodesCount : $position;

        $body['content'] = [
            ...array_slice($topLevelNodes, 0, $position),
            $node,
            ...array_slice($topLevelNodes, $position),
        ];

        return $body;
    }

    public static function removeNodeFromPosition(array $body, int $position): array
    {
        $topLevelNodes = self::getTopLevelNodes($body);
        unset($topLevelNodes[$position]);
        $body['content'] = array_values($topLevelNodes);

        return $body;
    }

    public static function getTextCharCount(array $body, ?string $stopOnNodeType = null): int
    {
        $text = self::tipTapToText($body, $stopOnNodeType);

        return mb_strlen($text);
    }

    /**
     * TipTap json body is a tree where text nodes have 'text' key.
     *
     * @see https://tiptap.scrumpy.io/export
     */
    public static function tipTapToText(array $body, ?string $stopOnNodeType = null): string
    {
        $text = AnzutapApp::EMPTY_STRING;
        foreach ($body as $key => $value) {
            if (self::TEXT_NODE === $key) {
                $text .= $value;
            }
            if (is_string($stopOnNodeType) &&
                is_array($value) &&
                self::isNodeType($value, $stopOnNodeType)) {
                return $text;
            }
            if (is_array($value)) {
                $text .= self::tipTapToText($value, $stopOnNodeType);
            }
        }

        return $text;
    }

    public static function getTopLevelNodes(array $body): array
    {
        return $body['content'] ?? [];
    }
}
