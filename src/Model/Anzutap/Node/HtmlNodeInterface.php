<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Anzutap\Node;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface HtmlNodeInterface
{
    public static function getNodeType(): string;

    public function isSelfClosing(): bool;

    public function tag(): array;
}
