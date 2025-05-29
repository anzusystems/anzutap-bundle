<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class HorizontalRuleNode extends Node implements HtmlNodeInterface
{
    public static function getNodeType(): string
    {
        return self::HORIZONTAL_RULE;
    }

    public function tag(): array
    {
        return ['hr'];
    }

    protected function getMarksAllowList(): ?array
    {
        return [];
    }
}
