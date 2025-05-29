<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers\MarkHandler;
use AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers\NodeHandler;
use AnzuSystems\SerializerBundle\Attributes\Serialize;
use Closure;
use Generator;
use IteratorAggregate;
use Traversable;

/**
 * @template-implements IteratorAggregate<int, NodeInterface>
 */
abstract class AbstractNode implements NodeInterface, IteratorAggregate
{
    protected ?NodeInterface $parent = null;

    #[Serialize]
    protected string $type;

    #[Serialize]
    protected ?array $attrs = null;

    /**
     * @var array<int, MarkInterface>|null
     */
    #[Serialize(handler: MarkHandler::class)]
    protected ?array $marks = null;

    /**
     * @var array<int, NodeInterface>
     */
    #[Serialize(handler: NodeHandler::class)]
    protected array $content = [];

    public function __construct()
    {
        $this->type = static::getNodeType();
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setAttrs(?array $attrs = null): static
    {
        $this->attrs = $attrs;

        return $this;
    }

    public function getAttrs(): ?array
    {
        return $this->attrs;
    }

    public function getAttr(string $key): mixed
    {
        return $this->attrs[$key] ?? null;
    }

    public function getParent(): ?NodeInterface
    {
        return $this->parent;
    }

    public function setParent(?NodeInterface $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function isSelfClosing(): bool
    {
        return false;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setMarks(?array $marks = null): self
    {
        $this->marks = $marks;

        // todo mark allow list
        //        $marksAllowList = $this->getMarksAllowList();
        //        if (null === $marks || (is_array($marksAllowList) && AnzutapApp::ZERO === count($marksAllowList))) {
        //            $this->marks = null;
        //
        //            return $this;
        //        }
        //
        //        if (null === $marksAllowList) {
        //            $this->marks = $marks;
        //
        //            return $this;
        //        }
        //
        //        foreach ($marks as $mark) {
        //            if (in_array($mark['type'] ?? '', $marksAllowList, true)) {
        //                $this->marks[] = $mark;
        //            }
        //        }

        return $this;
    }

    public function isValid(): bool
    {
        return true;
    }

    public function addMark(MarkInterface $mark): self
    {
        if (null === $this->marks) {
            $this->marks = [];
        }

        $this->marks[] = $mark;

        return $this;
    }

    public function addAttr(string $name, string $value): self
    {
        if (null === $this->attrs) {
            $this->attrs = [];
        }

        $this->attrs[$name] = $value;

        return $this;
    }

    public function setContent(array $content): NodeInterface
    {
        $this->content = $content;
        foreach ($this->content as $node) {
            $node->setParent($this);
        }

        return $this;
    }

    public function addContent(NodeInterface $node): NodeInterface
    {
        $this->content[] = $node;
        $node->setParent($this);

        return $this;
    }

    /**
     * @param array<int, NodeInterface> $nodes
     */
    public function addContents(array $nodes): NodeInterface
    {
        foreach ($nodes as $node) {
            $this->addContent($node);
        }

        return $this;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getNodeText(): ?string
    {
        $text = [];
        if ($this instanceof TextNode) {
            $text[] = $this->getText();
        }
        foreach ($this->content as $node) {
            $childText = $node->getNodeText();
            if (is_string($childText)) {
                $text[] = $childText;
            }
        }

        if (empty($text)) {
            return null;
        }

        return implode(' ', $text);
    }

    public function removeNodeByKey(int $key): ?NodeInterface
    {
        if (array_key_exists($key, $this->content)) {
            $removed = $this->content[$key];
            unset($this->content[$key]);
            $this->content = array_values($this->content);

            return $removed;
        }

        return null;
    }

    /**
     * @param Closure(NodeInterface $removeFn, mixed $key): bool $removeFn
     */
    public function removeNode(Closure $removeFn): ?NodeInterface
    {
        $removeNodeKey = $this->findNode($removeFn);
        if (null === $removeNodeKey) {
            return null;
        }

        if (array_key_exists($removeNodeKey, $this->content) && $this->content[$removeNodeKey] instanceof NodeInterface) {
            $removed = $this->content[$removeNodeKey];
            unset($this->content[$removeNodeKey]);
            $this->content = array_values($this->content);

            return $removed;
        }

        return $this;
    }

    /**
     * @param Closure(NodeInterface $filterFn, mixed $key): bool $filterFn
     */
    public function findNode(Closure $filterFn): int|null
    {
        $key = null;
        foreach ($this->content as $currentKey => $value) {
            if ($filterFn($value, $currentKey)) {
                $key = $currentKey;
                break;
            }
        }
        if (is_int($key)) {
            return $key;
        }

        return null;
    }

    /**
     * @return Traversable<int, NodeInterface>
     */
    public function getIterator(): Traversable
    {
        return $this->iterateRecursive();
    }

    public function iterateRecursive(): Generator
    {
        yield $this;

        foreach ($this->content as $childNode) {
            yield from $childNode->iterateRecursive();
        }
    }

    protected function getMarksAllowList(): ?array
    {
        return null;
    }

    /**
     * Helper function for wrapping child nodes into paragraphs
     */
    protected function upsertFirstContentParagraph(): NodeInterface
    {
        foreach ($this->content as $item) {
            if (ParagraphNode::NODE_NAME === $item->getType()) {
                return $item;
            }
        }

        $paragraphNode = new ParagraphNode();
        $this->addContent($paragraphNode);

        return $paragraphNode;
    }
}
