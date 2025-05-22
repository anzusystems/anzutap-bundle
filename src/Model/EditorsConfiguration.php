<?php

namespace AnzuSystems\AnzutapBundle\Model;

use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Mark\LinkNodeTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Mark\MarkNodeTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\AnchorTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\BulletListTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\HeadingTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\HorizontalRuleTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\LineBreakTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\ListItemTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\OrderedListTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\ParagraphNodeTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\TableCellTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\TableRowTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\TableTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\TextNodeTransformer;
use AnzuSystems\AnzutapBundle\AnzutapTransformer\ImageTransformer;
use AnzuSystems\AnzutapBundle\HtmlRenderer\EmbedExternalImageHtmlRenderer;

final class EditorsConfiguration
{
    public const array DEFAULT_ALLOWED_NODE_TRANSFORMERS = [
        TextNodeTransformer::class,
        TableTransformer::class,
        TableRowTransformer::class,
        ParagraphNodeTransformer::class,
        TableCellTransformer::class,
        OrderedListTransformer::class,
        BulletListTransformer::class,
        ListItemTransformer::class,
        LineBreakTransformer::class,
        HorizontalRuleTransformer::class,
        HeadingTransformer::class,
        AnchorTransformer::class,
        ImageTransformer::class,
    ];

    public const array DEFAULT_ALLOWED_MARK_TRANSFORMERS = [
        LinkNodeTransformer::class,
        MarkNodeTransformer::class,
    ];

    public const array DEFAULT_ALLOWED_EDITOR_HTML_RENDERERS = [
        EmbedExternalImageHtmlRenderer::class,
    ];

    public const array DEFAULT_SKIP_NODES = [
        'span',
        'style',
        'thead',
        'tbody',
        'blockquote',
    ];
}
