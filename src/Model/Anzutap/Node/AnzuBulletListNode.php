<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

class AnzuBulletListNode extends AnzutapNode
{
    public function __construct()
    {
        parent::__construct(
            type: self::BULLET_LIST,
        );
    }

    public function isValid(): bool
    {
        return false === empty($this->content);
    }
}
