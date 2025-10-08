<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;

class Node extends AbstractNode
{
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<int, MarkInterface>|null
     */
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
            $data['marks'] = array_map(
                static fn (MarkInterface $mark) => $mark->toArray(),
                $this->marks
            );
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

    // todo create factorable interface
    public static function getNodeType(): string
    {
        return 'unknown-node';
    }
}
