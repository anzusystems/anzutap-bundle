<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model\Mark;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag]
interface MarkInterface
{
    public const string BOLD = 'bold';
    public const string CODE = 'code';
    public const string HIGHLIGHT = 'highlight';
    public const string ITALIC = 'italic';
    public const string LINK = 'link';
    public const string STRIKE = 'strike';
    public const string SUBSCRIPT = 'subscript';
    public const string SUPERSCRIPT = 'superscript';
    public const string UNDERLINE = 'underline';

    public static function getMarkType(): string;

    public function getType(): string;

    public function isMarkType(string $type): bool;

    public function tag(): array;

    public function toArray(): array;
}
