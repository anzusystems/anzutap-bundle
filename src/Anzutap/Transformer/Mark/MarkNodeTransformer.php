<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Anzutap\Transformer\Mark;

use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\Bold;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\Code;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\Highlight;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\Italic;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\MarkInterface;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\Strike;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\Superscript;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\Underline;
use AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\Subscript;
use DOMElement;

class MarkNodeTransformer extends AbstractMarkNodeTransformer
{
    private const string NODE_BOLD = 'b';
    private const string NODE_STRONG = 'strong';
    private const string NODE_ITALIC = 'i';
    private const string NODE_UNDERLINE = 'u';
    private const string NODE_STRIKE = 's';
    private const string NODE_SUBSCRIPT = 'sub';
    private const string NODE_SUPERSCRIPT = 'sup';
    private const string NODE_ABBR = 'abbr';
    private const string NODE_EMPHASE = 'em';
    private const string NODE_CODE = 'code';
    private const string NODE_MARK = 'mark';

    public static function getSupportedNodeNames(): array
    {
        return [
            self::NODE_BOLD,
            self::NODE_STRONG,
            self::NODE_ITALIC,
            self::NODE_UNDERLINE,
            self::NODE_STRIKE,
            self::NODE_SUBSCRIPT,
            self::NODE_SUPERSCRIPT,
            self::NODE_ABBR,
            self::NODE_EMPHASE,
            self::NODE_CODE,
            self::NODE_MARK,
        ];
    }

    public function transform(DOMElement $element): MarkInterface|null
    {
        return match ($element->nodeName) {
            self::NODE_ABBR, self::NODE_BOLD, self::NODE_STRONG => new Bold(),
            self::NODE_EMPHASE, self::NODE_ITALIC => new Italic(),
            self::NODE_UNDERLINE => new Underline(),
            self::NODE_STRIKE => new Strike(),
            self::NODE_SUBSCRIPT => new Subscript(),
            self::NODE_SUPERSCRIPT => new Superscript(),
            self::NODE_CODE => new Code(),
            self::NODE_MARK => new Highlight(),
            default => null,
        };
    }
}
