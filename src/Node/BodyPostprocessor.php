<?php

namespace AnzuSystems\AnzutapBundle\Node;

use AnzuSystems\AnzutapBundle\Model\Mark\Link;
use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\AnzutapBundle\Model\Node\DocumentNode;
use AnzuSystems\AnzutapBundle\Model\Node\HeadingNode;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use AnzuSystems\AnzutapBundle\Model\Node\ParagraphNode;
use AnzuSystems\AnzutapBundle\Model\Node\TextNode;

class BodyPostprocessor
{
    public const array PARAGRAPH_ALLOWED_CONTENT_TYPES = [
        NodeInterface::TEXT,
        NodeInterface::HARD_BREAK,
        'embedExternalImageInline',
        'embedImageInline',
    ];

    public const array ANCHOR_TARGET_NODES = [
        NodeInterface::PARAGRAPH,
        NodeInterface::HEADING,
        NodeInterface::LIST_ITEM,
    ];

    // todo: make this configurable in new article-bundle
    private const array NODES_TO_SHAKE = [
        'button',
        'contentLock',
        'horizontalRule',
        'embedImage',
        'embedExternalImage',
        'embedVideo',
        'embedAudio',
        'embedPoll',
        'embedQuiz',
        'embedRelated',
        'embedReview',
        'embedTimeline',
        'embedWeather',
        'embedExternal',
        'embedCrossBox',
    ];

    public function postprocess(DocumentNode $body): void
    {
        $this->shakeNodes($body, self::NODES_TO_SHAKE);
        $this->fixParagraphs($body);
        $this->fixHeadings($body);
        $this->removeInvalidContentNodes($body);
        $this->removeInvalidNodes($body);
        $this->clearTextNodes($body);
        $this->removeAnchorDuplicates($body);
    }

    protected function removeAnchorDuplicates(DocumentNode $body): void
    {
        /** @var array<string, NodeInterface> $usedTargetAnchors */
        $usedTargetAnchors = [];
        /** @var array<string, MarkInterface> $usedTargetAnchors */
        $usedMarks = [];

        foreach ($body as $node) {
            if ($node instanceof TextNode) {
                $usedMarks = $this->removeMarkAnchorDuplicates($node, $usedMarks);
            }

            if ($node->isInNodeTypes(self::ANCHOR_TARGET_NODES)) {
                $usedTargetAnchors = $this->removeNodeAnchorDuplicates($node, $usedTargetAnchors);
            }
        }
    }

    protected function clearTextNodes(DocumentNode $body): void
    {
        foreach ($body as $node) {
            if (false === $node->isNodeType(NodeInterface::TEXT)) {
                continue;
            }

            if ($node->getParent()?->isInNodeTypes([NodeInterface::BUTTON])) {
                $node->setMarks(null);
            }
        }
    }

    protected function removeInvalidNodes(DocumentNode $body): void
    {
        foreach ($body as $node) {
            $node->setContent(array_filter(
                $node->getContent(),
                static fn (NodeInterface $node): bool => $node->isValid()
            ));
        }
    }

    protected function removeInvalidContentNodes(DocumentNode $body): void
    {
        foreach ($body as $node) {
            $allowedNodes = $node::getAllowedNodes();
            if (null === $allowedNodes) {
                continue;
            }

            $node->setContent(array_filter(
                $node->getContent(),
                static fn (NodeInterface $child): bool => in_array($child->getType(), $allowedNodes, true)
            ));
        }
    }

    protected function fixHeadings(NodeInterface $body): void
    {
        if (empty(HeadingNode::getAllowedNodes())) {
            return;
        }

        foreach ($body as $node) {
            if (false === $node->isNodeType(NodeInterface::HEADING)) {
                continue;
            }

            $notAllowedNodes = array_find(
                $node->getContent(),
                static fn (NodeInterface $child): bool => false === in_array($child->getType(), $node::getAllowedNodes(), true)
            );

            if (empty($notAllowedNodes)) {
                continue;
            }

            $innerTextNodes = [];
            foreach ($node as $child) {
                if (false === $child->isNodeType(NodeInterface::TEXT)) {
                    continue;
                }

                $innerTextNodes[] = $child;
            }

            $node->setContent($innerTextNodes);
        }
    }

    protected function fixParagraphs(NodeInterface $body): void
    {
        foreach ($body->getContent() as $node) {
            if ($node->getType() === ParagraphNode::NODE_NAME) {
                $this->fixNode($node, self::PARAGRAPH_ALLOWED_CONTENT_TYPES);
            }

            $this->fixParagraphs($node);
        }
    }

    protected function fixNode(NodeInterface $node, array $allowedNodes): void
    {
        $children = [];
        foreach ($node->getContent() as $child) {
            if (false === in_array($child->getType(), $allowedNodes, true)) {
                $text = $node->getNodeText();
                if (is_string($text)) {
                    $textNode = TextNode::getInstance($text);
                    $textNode->setParent($node);
                    $children[] = $textNode;
                }

                continue;
            }

            $children[] = $child;
        }

        $node->setContent($children);
    }

    /**
     * @param array<int, string> $nodeTypesToShake
     */
    protected function shakeNodes(DocumentNode $body, array $nodeTypesToShake): void
    {
        $topLevelNodes = [];

        foreach ($body->getContent() as $node) {
            $contentCount = count($node->getContent());
            $shakenNodes = $this->shakeAndSplitChildNodes($node, $nodeTypesToShake);

            // Check if root node was paragraph and after shaking, it lost content.
            foreach ($shakenNodes as $shakenNode) {
                if ($shakenNode === $node &&
                    $shakenNode->getType() === ParagraphNode::NODE_NAME &&
                    0 === count($shakenNode->getContent()) &&
                    0 < $contentCount
                ) {
                    continue;
                }

                $topLevelNodes[] = $shakenNode;
                $shakenNode->setParent($body);
            }
        }

        $body->setContent($topLevelNodes);
    }

    /**
     * @param array<int, string> $nodeTypesToShake
     *
     * @return array<int, NodeInterface>
     */
    protected function shakeAndSplitChildNodes(NodeInterface $rootNode, array $nodeTypesToShake): array
    {
        $nodesToKeep = [];
        $resNodes = [];

        $moveShakingNodesBefore = true;
        foreach ($rootNode->getContent() as $node) {
            $isShakingNode = in_array($node->getType(), $nodeTypesToShake, true);

            if ($isShakingNode) {
                $resNodes[] = $node;
            }

            if (false === empty($node->getContent())) {
                $resNodes = [...$resNodes, ...$this->deepShake($node, $nodeTypesToShake)];
            }

            if (false === $isShakingNode) {
                $nodesToKeep[] = $node;
            }

            // Add origin node to right position
            if ($moveShakingNodesBefore && false === $isShakingNode) {
                $resNodes[] = $rootNode;
                $moveShakingNodesBefore = false;
            }
        }

        // origin node was not added to res nodes
        if ($moveShakingNodesBefore) {
            $resNodes[] = $rootNode;
        }

        // remove shaking nodes from content
        $rootNode->setContent($nodesToKeep);

        return $resNodes;
    }

    /**
     * @param array<int, string> $nodeTypesToShake
     *
     * @return array<int, NodeInterface>
     */
    protected function deepShake(NodeInterface $rootNode, array $nodeTypesToShake): array
    {
        $nodesToShake = [];
        $nodesToKeep = [];

        foreach ($rootNode->getContent() as $node) {
            $isShakingNode = in_array($node->getType(), $nodeTypesToShake, true);

            if ($isShakingNode) {
                $nodesToShake[] = $node;
            }

            if (false === empty($node->getContent())) {
                $nodesToShake = array_merge($nodesToShake, $this->deepShake($node, $nodeTypesToShake));
            }

            if (false === $isShakingNode) {
                $nodesToKeep[] = $node;
            }
        }
        $rootNode->setContent($nodesToKeep);

        return $nodesToShake;
    }

    /**
     * @param array<string, MarkInterface> $usedMarks
     *
     * @return array<string, MarkInterface>
     */
    private function removeMarkAnchorDuplicates(TextNode $textNode, array $usedMarks): array
    {
        $linkMarkKey = $textNode->getMarkKey(MarkInterface::LINK);
        $anchorMark = $linkMarkKey ? ($textNode->getMarks() ?? [])[$linkMarkKey] : null;
        if ($anchorMark instanceof Link && $anchorMark->isVariant(Link::VARIANT_ANCHOR)) {
            $anchorHref = $anchorMark->getHref();

            if (isset($usedMarks[$anchorHref])) {
                $textNode->removeMark($anchorMark);

                return $usedMarks;
            }

            $usedMarks[$anchorHref] = $textNode;
        }

        return $usedMarks;
    }

    /**
     * @param array<string, NodeInterface> $usedTargetAnchors
     *
     * @return array<string, NodeInterface>
     */
    private function removeNodeAnchorDuplicates(NodeInterface $node, array $usedTargetAnchors): array
    {
        if (false === $node->hasAttr(Link::VARIANT_ANCHOR)) {
            return $usedTargetAnchors;
        }

        $anchor = (string) $node->getAttr('anchor');
        if (isset($usedTargetAnchors[$anchor])) {
            $node->removeAttr(Link::VARIANT_ANCHOR);

            return $usedTargetAnchors;
        }

        $usedTargetAnchors[$anchor] = $node;

        return $usedTargetAnchors;
    }
}
