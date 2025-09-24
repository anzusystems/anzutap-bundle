<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use Closure;
use Generator;
use IteratorAggregate;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * @template-extends IteratorAggregate<int, NodeInterface>
 */
#[AutoconfigureTag(name: AnzuSystemsAnzutapBundle::TAG_MODEL_NODE)]
interface NodeInterface extends IteratorAggregate
{
    public const string PARAGRAPH = 'paragraph';
    public const string BLOCKQUOTE = 'blockquote';
    public const string HEADING = 'heading';
    public const string HARD_BREAK = 'hardBreak';
    public const string DOC = 'doc';
    public const string LIST_ITEM = 'listItem';
    public const string BULLET_LIST = 'bulletList';
    public const string ADVERT = 'ad';
    public const string QUOTE = 'quote';
    public const string QUOTE_AUTHOR = 'quoteAuthor';
    public const string QUOTE_CONTENT = 'quoteContent';
    public const string ORDERED_LIST = 'orderedList';
    public const string TABLE_CELL = 'tableCell';
    public const string TABLE_HEADER = 'tableHeader';
    public const string TABLE = 'table';
    public const string TABLE_ROW = 'tableRow';
    public const string TEXT = 'text';
    public const string HORIZONTAL_RULE = 'horizontalRule';
    public const string STYLED_BOX = 'styledBox';
    public const string STYLED_BOX_TITLE = 'styledBoxTitle';
    public const string STYLED_BOX_CONTENT = 'styledBoxContent';
    public const string CONTENT_LOCK = 'contentLock';
    public const string BUTTON = 'button';

    public function isNodeType(string $type): bool;

    /**
     * @param string[] $types
     */
    public function isInNodeTypes(array $types): bool;

    public static function getNodeType(): string;

    public function getType(): string;

    public function setParent(?self $parent): static;

    public function getParent(): ?self;

    public function addContent(self $node): self;

    /**
     * @return array<int, NodeInterface>
     */
    public function getContent(): array;

    public function getAttrs(): ?array;

    public function getAttr(string $key): mixed;

    public function hasAttr(string $key): bool;

    public function removeAttr(string $key): void;

    public function setAttrs(?array $attrs = null): self;

    public function setContent(array $content): self;

    public function getNodeText(): ?string;

    /**
     * @param Closure(NodeInterface $removeFn, mixed $key): bool $removeFn
     */
    public function removeNode(Closure $removeFn): ?self;

    /**
     * @param Closure(NodeInterface $filterFn, mixed $key): bool $filterFn
     */
    public function findNodeIndex(Closure $filterFn): int|null;

    public function removeNodeByIndex(int $key): ?self;

    public function removeMark(MarkInterface $mark): static;

    public function setMarks(?array $marks = null): self;

    /**
     * @param array<int, NodeInterface> $nodes
     */
    public function insertNodesToIndex(array $nodes, int $index): self;

    /**
     * @return array<int, MarkInterface>|null
     */
    public function getMarks(): ?array;

    public function getMarkKey(string $mark): ?int;

    public function addAttr(string $name, string $value): self;

    public function addMark(MarkInterface $mark): self;

    public function iterateRecursive(): Generator;

    public function toArray(): array;

    public function isValid(): bool;

    public static function getAllowedNodes(): ?array;
}
