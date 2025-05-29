<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Editor;

use AnzuSystems\AnzutapBundle\Anzutap\TransformerProvider\MarktransformerProviderInterface;
use AnzuSystems\AnzutapBundle\Anzutap\TransformerProvider\NodeTransformerProviderInterface;
use AnzuSystems\AnzutapBundle\HtmlRenderer\HtmlRendererInterface;
use AnzuSystems\AnzutapBundle\Model\AnzutapBody;
use AnzuSystems\AnzutapBundle\Model\Embed\EmbedKindInterface;
use AnzuSystems\AnzutapBundle\Model\EmbedContainer;
use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\AnzutapBundle\Model\Node\DocumentNode;
use AnzuSystems\AnzutapBundle\Model\Node\EmbedNode;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Node\BodyPostprocessor;
use AnzuSystems\AnzutapBundle\Node\BodyPreprocessor;
use AnzuSystems\AnzutapBundle\Node\Transformer\Mark\AnzuMarkTransformerInterface;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\AnzuNodeTransformerInterface;
use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;
use Symfony\Component\DependencyInjection\ServiceLocator;

final class AnzutapEditor
{
    /** @var array<array-key, MarkInterface> */
    private array $storedMarks = [];
    private EmbedContainer $embedContainer;

    public function __construct(
        private readonly NodeTransformerProviderInterface $transformerProvider,
        private readonly MarktransformerProviderInterface $markTransformerProvider,
        private readonly ServiceLocator $resolvedMarkTransformers,
        private readonly ServiceLocator $resolvedNodeTransformers,
        private readonly ServiceLocator $resolvedHtmlRenderers,
        private readonly AnzuNodeTransformerInterface $defaultTransformer,
        private readonly BodyPreprocessor $preprocessor,
        private readonly BodyPostprocessor $postprocessor,
    ) {
    }

    public function transformNode(DOMNode $node): DocumentNode
    {
        $this->clear();

        $body = new DocumentNode();
        $this->processChildren($node, $body, $body);
        $this->postprocessor->postprocess($body);

        return $body;
    }

    public function transform(string $data): AnzutapBody
    {
        $data = $this->preprocessor->prepareBody($data);
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        $this->clear();

        $document = new DOMDocument();
        $document->loadHTML($data);
        $bodyNode = $document->getElementsByTagName('body')->item(0);

        $body = new DocumentNode();
        if (false === (null === $bodyNode)) {
            $this->processChildren($bodyNode, $body, $body);
            $this->postprocessor->postprocess($body);
        }

        return new AnzutapBody(
            $this->embedContainer,
            $body,
        );
    }

    public function getMarkTransformer(DOMElement | DOMText $element): ?AnzuMarkTransformerInterface
    {
        $key = $this->markTransformerProvider->getMarkTransformerKey($element);
        if ($this->resolvedMarkTransformers->has($key)) {
            return $this->resolvedMarkTransformers->get($key);
        }

        return null;
    }

    public function getNodeTransformer(DOMElement | DOMText $element): AnzuNodeTransformerInterface
    {
        $key = $this->transformerProvider->getNodeTransformerKey($element);

        if ($this->resolvedNodeTransformers->has($key)) {
            return $this->resolvedNodeTransformers->get($key);
        }

        return $this->defaultTransformer;
    }

    public function getHtmlRenderer(AnzutapNodeInterface $node): ?HtmlRendererInterface
    {
        if ($this->resolvedHtmlRenderers->has($node->getType())) {
            return $this->resolvedHtmlRenderers->get($node->getType());
        }

        return null;
    }

    private function clear(): void
    {
        $this->storedMarks = [];
        $this->embedContainer = new EmbedContainer();
    }

    private function processChildren(DOMNode $node, AnzutapNodeInterface $anzuTapParentNode, DocumentNode $root): array
    {
        $nodes = [];

        foreach ($node->childNodes as $childNode) {
            if (false === ($childNode instanceof DOMText || $childNode instanceof DOMElement)) {
                continue;
            }

            if ($childNode instanceof DOMElement) {
                $markTransformer = $this->getMarkTransformer($childNode);
                if ($markTransformer && $markTransformer->supports($childNode)) {
                    $mark = $markTransformer->transform($childNode);

                    if (null === $mark) {
                        continue;
                    }

                    $this->storedMarks[] = $mark;

                    if ($childNode->hasChildNodes()) {
                        $nodes = array_merge($nodes, $this->processChildren($childNode, $anzuTapParentNode, $root));
                    }

                    if ($mark) {
                        array_pop($this->storedMarks);
                    }

                    continue;
                }
            }

            $nodeTransformer = $this->getNodeTransformer($childNode);
            $anzuTapNode = $this->processNode($childNode, $nodeTransformer, $anzuTapParentNode);

            if (null === $anzuTapNode) {
                if ($childNode->hasChildNodes() && false === $nodeTransformer->skipChildren()) {
                    $nodes = array_merge($nodes, $this->processChildren($childNode, $anzuTapParentNode, $root));
                }

                continue;
            }

            if (false === empty($this->storedMarks)) {
                $anzuTapNode->setMarks($this->getUniqueMarks());
            }

            if ($childNode->hasChildNodes() && false === $nodeTransformer->skipChildren()) {
                $this->processChildren($childNode, $anzuTapNode, $root);
            }

            if (0 === count($anzuTapNode->getContent())) {
                if ($nodeTransformer->removeWhenEmpty()) {
                    continue;
                }

                $nodeTransformer->fixEmpty($anzuTapNode);
            }

            $anzuTapParentNode->addContent($anzuTapNode);
        }

        return $nodes;
    }

    private function getUniqueMarks(): array
    {
        $marks = [];
        foreach ($this->storedMarks as $mark) {
            $marks[$mark->getMarkType()] = $mark;
        }

        return array_values($marks);
    }

    private function processNode(
        DOMElement | DOMText $node,
        AnzuNodeTransformerInterface $nodeTransformer,
        AnzutapNodeInterface $anzuTapParentNode,
    ): ?AnzutapNodeInterface {
        /** @psalm-suppress PossiblyInvalidArgument */
        $transformedNode = $nodeTransformer->transform($node, $this->embedContainer, $anzuTapParentNode);

        if (null === $transformedNode) {
            return null;
        }

        if ($transformedNode instanceof EmbedKindInterface) {
            $this->embedContainer->addEmbed($transformedNode);

            return EmbedNode::getInstance($transformedNode->getNodeType(), $transformedNode->getId());
        }

        return $transformedNode;
    }
}
