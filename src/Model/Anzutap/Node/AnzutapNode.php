<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzutapNode extends AbstractAnzutapNode
{
    public function getType(): string
    {
        return $this->type;
    }

    public function getMarks(): ?array
    {
        return $this->marks;
    }

    public function toArray(): array
    {
        $data = [
            'type' => $this->getType(),
        ];
        if (null !== $this->attrs) {
            $data['attrs'] = $this->getAttrs();
        }
        if (null !== $this->marks) {
            $data['marks'] = $this->getMarks();
        }
        $content = [];
        foreach ($this->content as $item) {
            $content[] = $item->toArray();
        }
        if (false === empty($content)) {
            $data['content'] = $content;
        }

        return $data;
    }
}
