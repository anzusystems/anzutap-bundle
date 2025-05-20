<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapDocNode;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapTextNode;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\HtmlNodeInterface;
use AnzuSystems\AnzutapBundle\ProseMirror\Interfaces\TransformableDocumentWrapperInterface;
use AnzuSystems\SerializerBundle\Serializer;

final readonly class HtmlTransformer
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    public function transform(
        TransformableDocumentWrapperInterface $documentWrapper,
//        ?ArticleAdvertSettings $articleAdvertSettings = null,
    ): string {
        $node = $this->serializer->fromArray($documentWrapper->getDocument()->getData(), AnzutapDocNode::class);

        // todo adverts / promo links / paybreak

        return $this->renderNode($node, $documentWrapper);
    }

    private function renderNode(
        AnzutapNodeInterface $node,
        ?TransformableDocumentWrapperInterface $documentWrapper = null
    ): string {
        $html = [];


        if ($node instanceof HtmlNodeInterface) {
            $html[] = $this->renderOpeningTag($node->tag());
        }

        foreach ($node->getContent() as $nestedNode) {
            $html[] = $this->renderNode($nestedNode, $documentWrapper);
        }

        if ($node instanceof AnzutapTextNode) {
            $html[] = htmlentities($node->getNodeText(), ENT_QUOTES);
        }

        if ($node instanceof HtmlNodeInterface) {
            $html[] = $this->renderClosingTag($node->tag());
        }

        return implode('', $html);
    }

    private function renderHtmlNodeInterface(
        HtmlNodeInterface $node,
        ?TransformableDocumentWrapperInterface $documentWrapper = null
    ): string {
        $html = [];

        $html[] = $this->renderOpeningTag($node->tag());
        foreach ($node->getContent() as $nestedNode) {
            $html[] = $this->renderNode($nestedNode, $documentWrapper);
        }
        $html[] = $this->renderClosingTag($node->tag());

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
}
