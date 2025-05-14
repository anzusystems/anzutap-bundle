<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapTextNode extends AbstractAnzutapNode
{
    public function __construct(
        private readonly string $text,
        ?array $marks = null,
    ) {
        parent::__construct(
            type: self::TEXT,
            marks: $marks
        );
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function addContent(AnzutapNodeInterface $node): static
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
            $data['marks'] = $this->marks;
        }

        return $data;
    }

    public function getMarks(): ?array
    {
        return $this->marks;
    }
}
