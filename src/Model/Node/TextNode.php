<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\SerializerBundle\Attributes\Serialize;

final class TextNode extends AbstractNode
{
    #[Serialize]
    private string $text;

    public function __clone()
    {
        $this->marks = array_map(
            static fn (MarkInterface $mark) => clone $mark,
            $this->marks ?? []
        );
        $this->parent = null;
        $this->content = [];
    }

    public static function getInstance(
        string $text,
        ?array $marks = null,
    ): self {
        return (new self())
            ->setText($text)
            ->setMarks(
                $marks
            );
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function addContent(NodeInterface $node): static
    {
        $this->parent?->addContent($node);

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'type' => $this->getType(),
            'text' => $this->getText(),
        ];
        if ($this->marks) {
            $data['marks'] = array_map(
                static fn (MarkInterface $mark) => $mark->toArray(),
                $this->marks
            );
        }

        return $data;
    }

    /**
     * @return array<int, MarkInterface>|null
     */
    public function getMarks(): ?array
    {
        return $this->marks;
    }

    public static function getNodeType(): string
    {
        return self::TEXT;
    }
}
