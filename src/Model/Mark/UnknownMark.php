<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

final class UnknownMark extends AbstractMark
{
    use MarkAttributesTrait;

    private string $setMarkType = 'unknown';

    public function setSetMarkType(string $setMarkType): void
    {
        $this->setMarkType = $setMarkType;
    }

    public static function getMarkType(): string
    {
        return 'unknown-mark';
    }

    public function toArray(): array
    {
        $data = [
            'type' => $this->getType(),
        ];
        if (false === empty($this->attrs)) {
            $data['attrs'] = $this->getAttrs();
        }

        return $data;
    }

    public function tag(): array
    {
        return [];
    }
}
