<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle;

use AnzuSystems\AnzutapBundle\Anzutap\AnzutapEditor;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapDocNode;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\AnzutapTextNode;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Node\HtmlNodeInterface;
use AnzuSystems\AnzutapBundle\Model\HtmlTransformableInterface;
use AnzuSystems\AnzutapBundle\Provider\EditorProvider;
use AnzuSystems\SerializerBundle\Serializer;

final readonly class HtmlTransformer
{
    public function __construct(
        private Serializer $serializer,
        private EditorProvider $editorProvider,
    ) {
    }

    public function transform(
        HtmlTransformableInterface $documentWrapper,
//        ?ArticleAdvertSettings $articleAdvertSettings = null,
    ): string {
        $editor = $this->editorProvider->getEditor($documentWrapper->getEditorName());

        $node = $this->serializer->fromArray($documentWrapper->getDocument(), AnzutapDocNode::class);

        // todo adverts / promo links / paybreak

        return $this->renderTree($node, $editor, $documentWrapper);
    }

    private function renderTree(
        AnzutapNodeInterface $node,
        AnzutapEditor $editor,
        ?HtmlTransformableInterface $documentWrapper = null
    ): string {
        $html = [];

        $htmlRenderer = $editor->getHtmlRenderer($node);
        if ($htmlRenderer) {
            return $htmlRenderer->render($node, $documentWrapper);
        }

        $html = [...$html, ...$this->provideOpeningMarks($node)];
        if ($node instanceof HtmlNodeInterface) {
            $html[] = $this->renderOpeningTag($node->tag());
        }

        foreach ($node->getContent() as $nestedNode) {
            $html[] = $this->renderTree($nestedNode, $editor, $documentWrapper);
        }

        if ($node instanceof AnzutapTextNode) {
            $html[] = htmlentities($node->getNodeText(), ENT_QUOTES);
        }

        if ($node instanceof HtmlNodeInterface) {
            $html[] = $this->renderClosingTag($node->tag());
        }
        $html = [...$html, ...$this->provideClosingMarks($node)];

        return implode('', $html);
    }

    private function provideOpeningMarks(AnzutapNodeInterface $node): array
    {
        $marks = [];
        foreach ($node->getMarks() ?? [] as $mark) {
            $marks[] = $this->renderOpeningTag($mark->tag());
        }

        return $marks;
    }

    private function provideClosingMarks(AnzutapNodeInterface $node): array
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

    public static function getTransformableWrapper(
        array $data,
        bool $lockEnabled = false,
        bool $isLocked = false,
        ?string $editorName = null,
    ): HtmlTransformableInterface {
        return new readonly class(
            $data,
            $lockEnabled,
            $isLocked,
            $editorName,
        ) implements HtmlTransformableInterface {
            public function __construct(
                private array $data,
                private bool $lockEnabled,
                private bool $isLocked,
                private ?string $editorName = null,
            ) {
            }

            public function getDocument(): array
            {
                return $this->data;
            }

            public function isContentLockEnabled(): bool
            {
                return $this->lockEnabled;
            }

            public function isLocked(): bool
            {
                return $this->isLocked;
            }

            public function getEditorName(): ?string
            {
                return $this->editorName;
            }
        };
    }
}
