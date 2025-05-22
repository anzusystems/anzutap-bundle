<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

namespace AnzuSystems\AnzutapBundle\Model\Node;

final class AnzutapHorizontalRuleNode extends AnzutapNode implements HtmlNodeInterface
{

    protected function getMarksAllowList(): ?array
    {
        return [];
    }

    public static function getNodeType(): string
    {
        return self::HORIZONTAL_RULE;
    }

    public function tag(): array
    {
        return ['hr'];
    }
}
