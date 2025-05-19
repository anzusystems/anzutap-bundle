<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror;

use AnzuSystems\AnzutapBundle\Helper\AnzuTapHelper;
use AnzuSystems\AnzutapBundle\Helper\PromoLinkHelper;
use AnzuSystems\AnzutapBundle\Helper\TipTapHelper;
use AnzuSystems\AnzutapBundle\Model\Domain\ArticleAdvertSettings\Model\ArticleAdvertSettings;
use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\CustomRenderNodeInterface;
use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\MarkInterface;
use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\NodeInterface;
use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\TransformableDocumentWrapperInterface;
use AnzuSystems\AnzutapBundle\ProseMirror\Node\AbstractContentLock;

final readonly class Transformer
{
    public function __construct(
        private NodeProvider $nodeProvider,
        private MarkProvider $markProvider,
//        private PromoLinkHelper $promoLinkHelper,
    ) {
    }

    public function transform(
        TransformableDocumentWrapperInterface $documentWrapper,
//        ?ArticleAdvertSettings $articleAdvertSettings = null,
    ): string {
        $content = $documentWrapper->getDocument()->getData();
//        if ($articleAdvertSettings) {
//            $content = $this->placeAdvertPositions($content, $documentWrapper, $articleAdvertSettings);
//        }
//        if (false === $documentWrapper->getDocument()->getPromoLinks()->isEmpty()) {
//            $content['content'] = $this->promoLinkHelper->resolvePromoLinks($content['content'], $documentWrapper);
//        }
        $nodes = TipTapHelper::getTopLevelNodes($content);

        $html = [];
        foreach ($nodes as $node) {
            $html[] = $this->renderNode($node, $documentWrapper);

            if (AbstractContentLock::getNodeType() === $node['type']
                && $documentWrapper->isContentLockEnabled()
//                && $documentWrapper->getContentLockStatus()->isContentLocked()
            ) {
                break; // we stop transforming content if content is locked and the content is not unlocked
            }
        }

        return implode('', $html);
    }

    /**
     * In this case all nodes with custom renderer are ignored.
     */
    public function transformBasicJsonData(array $jsonData): string
    {
        $content = $jsonData['content'] ?? [];
        $html = [];
        foreach ($content as $node) {
            $html[] = $this->renderNode($node);
        }

        return implode('', $html);
    }

    private function renderNode(array $node, ?TransformableDocumentWrapperInterface $documentWrapper = null): string
    {
        $html = [];

        foreach ($node['marks'] ?? [] as $mark) {
            $markInstance = $this->markProvider->provide($mark['type']);
            if ($markInstance instanceof MarkInterface) {
                $html[] = $this->renderOpeningTag($markInstance->tag($mark));
            }
        }

        $nodeInstance = $this->nodeProvider->provide($node['type']);
        if ($nodeInstance instanceof NodeInterface) {
            if ($nodeInstance instanceof CustomRenderNodeInterface
                && $documentWrapper instanceof TransformableDocumentWrapperInterface
            ) {
                return $nodeInstance->render($node, $documentWrapper);
            }
            $html[] = $this->renderOpeningTag($nodeInstance->tag($node));
        }

        foreach ($node['content'] ?? [] as $nestedNode) {
            $html[] = $this->renderNode($nestedNode, $documentWrapper);
        }

        $text = $node['text'] ?? '';
        if ($text) {
            $html[] = htmlentities($text, ENT_QUOTES);
        }

        if ($nodeInstance instanceof NodeInterface && false === $nodeInstance->isSelfClosing()) {
            $html[] = $this->renderClosingTag($nodeInstance->tag($node));
        }

        foreach (array_reverse($node['marks'] ?? []) as $mark) {
            $markInstance = $this->markProvider->provide($mark['type']);
            if ($markInstance instanceof MarkInterface) {
                $html[] = $this->renderClosingTag($markInstance->tag($mark));
            }
        }

        return implode('', $html);
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

//    private function placeAdvertPositions(
//        array $nodes,
//        TransformableDocumentWrapperInterface $documentWrapper,
//        ArticleAdvertSettings $articleAdvertSettings,
//    ): array {
//        if (false === $documentWrapper->hasEnabledAds() || false === $articleAdvertSettings->isEnabled()) {
//            return $nodes;
//        }
//
//        return AnzuTapHelper::insertAdNodes($nodes, $articleAdvertSettings);
//    }
}
