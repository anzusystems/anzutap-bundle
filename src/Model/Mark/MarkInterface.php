<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface MarkInterface
{
    public static function getMarkType(): string;

    public function tag(): array;

    public function toArray(): array;
}
