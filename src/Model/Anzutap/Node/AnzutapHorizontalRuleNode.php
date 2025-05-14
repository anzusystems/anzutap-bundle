<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

final class AnzutapHorizontalRuleNode extends AnzutapNode
{
    public const string NODE_NAME = 'horizontalRule';

    public function __construct()
    {
        parent::__construct(
            type: self::NODE_NAME,
        );
    }

    protected function getMarksAllowList(): ?array
    {
        return [];
    }
}
