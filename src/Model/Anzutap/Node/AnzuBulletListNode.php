<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzuBulletListNode extends AnzutapNode implements HtmlNodeInterface
{
    public function isValid(): bool
    {
        return false === empty($this->content);
    }

    public static function getNodeType(): string
    {
        return self::BULLET_LIST;
    }

    public function tag(): array
    {
        return [
            [
                'tag' => 'ul',
                'attrs' => ['class' => 'list list--bullet'],
            ],
        ];
    }
}
