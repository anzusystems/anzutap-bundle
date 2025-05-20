<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzuBulletListNode extends AnzutapNode
{
    public function isValid(): bool
    {
        return false === empty($this->content);
    }

    public static function getNodeType(): string
    {
        return self::BULLET_LIST;
    }
}
