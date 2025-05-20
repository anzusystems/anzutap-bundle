<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: AnzuSystemsAnzutapBundle::TAG_MODEL_NODE)]
interface AnzutapNodeInterface
{
    public const string PARAGRAPH = 'paragraph';
    public const string HEADING = 'heading';
    public const string HARD_BREAK = 'hardBreak';
    public const string DOC = 'doc';
    public const string LIST_ITEM = 'listItem';
    public const string BULLET_LIST = 'bulletList';
    public const string ORDERED_LIST = 'orderedList';
    public const string TABLE_CELL = 'tableCell';
    public const string TABLE_HEADER = 'tableHeader';
    public const string TABLE = 'table';
    public const string TABLE_ROW = 'tableRow';
    public const string TEXT = 'text';
    public const string HORIZONTAL_RULE = 'horizontalRule';

    public static function getNodeType(): string;

    public function getType(): string;

    public function setParent(?self $parent): static;

    public function getParent(): ?self;

    public function addContent(self $node): self;

    /**
     * @return array<int, AnzutapNodeInterface>
     */
    public function getContent(): array;

    public function getAttrs(): ?array;

    public function getAttr(string $key): mixed;

    public function setAttrs(?array $attrs = null): self;

    public function setContent(array $content): self;

    public function getNodeText(): ?string;

    public function setMarks(?array $marks = null): self;

    public function getMarks(): ?array;

    public function addAttr(string $name, string $value): self;

    // ? deprecated
    public function toArray(): array;

    // deprecated
    public function isValid(): bool;
}
