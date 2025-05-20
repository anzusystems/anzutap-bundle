<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

use AnzuSystems\SerializerBundle\Attributes\Serialize;

final class AnzutapTextNode extends AbstractAnzutapNode
{
    #[Serialize]
    private string $text;

    public static function getInstance(
        string $text,
        ?array $marks = null,
    ): self
    {
        return (new self())
            ->setText($text)
            ->setMarks($marks
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

    public static function getNodeType(): string
    {
        return self::TEXT;
    }
}
