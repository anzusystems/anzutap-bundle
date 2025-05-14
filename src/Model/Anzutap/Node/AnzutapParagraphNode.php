<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapParagraphNode extends AnzutapNode
{
    public const string NODE_NAME = 'paragraph';

    public function __construct(
        ?array $attrs = null,
    ) {
        parent::__construct(
            type: self::NODE_NAME,
            attrs: $attrs,
        );
    }

    protected function getMarksAllowList(): ?array
    {
        return [];
    }
}
