<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Model;

use AnzuSystems\AnzutapBundle\HtmlRenderer\EmbedExternalImageHtmlRenderer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Mark\LinkNodeTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Mark\MarkNodeTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\AnchorTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\BulletListTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\HeadingTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\HorizontalRuleTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\ImageTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\LineBreakTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\ListItemTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\OrderedListTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\ParagraphNodeTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\TableCellTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\TableRowTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\TableTransformer;
use AnzuSystems\AnzutapBundle\Node\Transformer\Node\TextNodeTransformer;

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
    ];
}
