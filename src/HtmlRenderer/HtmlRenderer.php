<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\HtmlRenderer;

use AnzuSystems\AnzutapBundle\Editor\AnzutapEditor;
use AnzuSystems\AnzutapBundle\Editor\EditorProvider;
use AnzuSystems\AnzutapBundle\Exception\EditorException;
use AnzuSystems\AnzutapBundle\Model\Advert\AdvertPool;
use AnzuSystems\AnzutapBundle\Model\DocumentRenderable\DocumentRenderableInterface;
use AnzuSystems\AnzutapBundle\Model\Node\HtmlNodeInterface;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\AnzutapBundle\Model\Node\TextNode;
use AnzuSystems\AnzutapBundle\Node\AdvertInserter;

final readonly class HtmlRenderer
{
    public function __construct(
        private EditorProvider $editorProvider,
    ) {
    }

    /**
     * @throws EditorException
     */
    public function render(
        DocumentRenderableInterface $renderable,
        ?AdvertPool $advertPool = null,
    ): string {
        $editor = $this->editorProvider->getEditor($renderable->getContext()->getEditorName());

        if ($advertPool && $renderable->getContext()->isEnabledAds()) {
            AdvertInserter::placeAdverts($renderable->getRootNode(), $advertPool);
        }

        $html = [];
        foreach ($renderable->getRootNode()->getContent() as $nestedNode) {
            $html[] = $this->renderTree($nestedNode, $editor, $renderable);

            if (NodeInterface::CONTENT_LOCK === $nestedNode->getType()
                && $renderable->getContext()->isContentLockEnabled()
                && false === $renderable->getContext()->isUnlocked()
            ) {
                break; // we stop transforming content if content is locked and the content is not unlocked
            }
        }

        return implode('', $html);
    }

    private function renderTree(
        NodeInterface $node,
        AnzutapEditor $editor,
        DocumentRenderableInterface $renderable
    ): string {
        $html = [];

        $htmlRenderer = $editor->getHtmlRenderer($node);
        if ($htmlRenderer) {
            return $htmlRenderer->render($node, $renderable);
        }

        $html = [...$html, ...$this->provideOpeningMarks($node)];
        if ($node instanceof HtmlNodeInterface) {
            $html[] = $this->renderOpeningTag($node->tag());
        }

        foreach ($node->getContent() as $nestedNode) {
            $html[] = $this->renderTree($nestedNode, $editor, $renderable);
        }

        if ($node instanceof TextNode) {
            $html[] = htmlentities((string) $node->getNodeText(), ENT_QUOTES);
        }

        if ($node instanceof HtmlNodeInterface && false === $node->isSelfClosing()) {
            $html[] = $this->renderClosingTag($node->tag());
        }
        $html = [...$html, ...$this->provideClosingMarks($node)];

        return implode('', $html);
    }

    private function provideOpeningMarks(NodeInterface $node): array
    {
        $marks = [];
        foreach ($node->getMarks() ?? [] as $mark) {
            $marks[] = $this->renderOpeningTag($mark->tag());
        }

        return $marks;
    }

    private function provideClosingMarks(NodeInterface $node): array
    {
        $marks = [];
        foreach (array_reverse($node->getMarks() ?? []) as $mark) {
            $marks[] = $this->renderClosingTag($mark->tag());
        }

        return $marks;
    }

    private function renderOpeningTag(array $tags): string
    {
        if (empty($tags)) {
            return '';
        }

        return implode('', array_map(static function ($item): string {
            if (is_string($item)) {
                return "<{$item}>";
            }

            $attrs = '';
            foreach ($item['attrs'] ?? [] as $attribute => $value) {
                $attrs .= " {$attribute}=\"{$value}\"";
            }

            return "<{$item['tag']}{$attrs}>";
        }, $tags));
    }

    private function renderClosingTag(array $tags): string
    {
        $tags = array_reverse($tags);

        if (empty($tags)) {
            return '';
        }

        return implode('', array_map(static function ($item) {
            if (is_string($item)) {
                return "</{$item}>";
            }

            return "</{$item['tag']}>";
        }, $tags));
    }
}
