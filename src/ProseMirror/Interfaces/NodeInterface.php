<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\ProseMirror\Interfaces;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface NodeInterface
{
    public static function getNodeType(): string;

    public function isSelfClosing(): bool;

    public function tag(array $node): array;
}
