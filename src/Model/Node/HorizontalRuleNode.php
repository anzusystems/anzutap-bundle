<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class HorizontalRuleNode extends Node implements HtmlNodeInterface
{
    public function isSelfClosing(): bool
    {
        return true;
    }

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
