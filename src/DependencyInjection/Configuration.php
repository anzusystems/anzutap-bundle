<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\DependencyInjection;

use AnzuSystems\AnzutapBundle\Anzutap\AnzutapBodyPostprocessor;
use AnzuSystems\AnzutapBundle\Anzutap\AnzutapBodyPreprocessor;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\XRemoveTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\XSkipTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\TransformerProvider\AnzutapMarkNodeTransformerProvider;
use AnzuSystems\AnzutapBundle\Anzutap\TransformerProvider\AnzutapNodeTransformerProvider;
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
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public const string EDITOR_NODE_TRANSFORMER_PROVIDER_CLASS = 'node_transformer_provider_class';
    public const string EDITOR_NODE_DEFAULT_TRANSFORMER_CLASS = 'node_default_transformer';
    public const string EDITOR_MARK_TRANSFORMER_PROVIDER_CLASS = 'mark_transformer_provider_class';
    public const string EDITOR_BODY_PREPROCESSOR = 'body_preprocessor';
    public const string EDITOR_BODY_POSTPROCESSOR = 'body_postprocessor';

    public const string EDITOR_ALLOWED_NODE_TRANSFORMERS = 'allowed_node_transformers';
    public const string EDITOR_ALLOWED_MARK_TRANSFORMERS = 'allowed_mark_transformers';
    public const string EDITOR_ALLOWED_HTML_RENDERERS = 'allowed_html_renderers';
    public const string EDITOR_SKIP_NODES = 'skip_nodes';
    public const string EDITOR_REMOVE_NODES = 'remove_nodes';

    public const string EDITORS = 'editors';
    public const string DEFAULT_EDITOR_NAME = 'default_editor_name';
    public const string ANZU_SYSTEMS_ANZUTAP = 'anzu_systems_anzutap';

    private const array DEFAULT_ALLOWED_NODE_TRANSFORMERS = [
        TextNodeTransformer::class,
        TableTransformer::class,
        TableRowTransformer::class,
        ParagraphNodeTransformer::class,
        TableCellTransformer::class,
        OrderedListTransformer::class,
        BulletListTransformer::class,
        ListItemTransformer::class,
        LineBreakTransformer::class,
        // ImageTransformer::class,
        HorizontalRuleTransformer::class,
        HeadingTransformer::class,
        AnchorTransformer::class,
    ];

    private const array DEFAULT_ALLOWED_MARK_TRANSFORMERS = [
        LinkNodeTransformer::class,
        MarkNodeTransformer::class,
    ];

    private const array DEFAULT_SKIP_NODES = [
        'span',
        'style',
    ];

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::ANZU_SYSTEMS_ANZUTAP);

        $treeBuilder->getRootNode()
            ->children()
                ->append($this->addEditorSection())
                ->scalarNode('default_editor_name')
                    ->isRequired()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    private function addEditorSection(): NodeDefinition
    {
        return (new TreeBuilder(self::EDITORS))->getRootNode()
            ->useAttributeAsKey('name')
            ->arrayPrototype()
                ->performNoDeepMerging()
                ->children()
                    ->scalarNode(self::EDITOR_NODE_TRANSFORMER_PROVIDER_CLASS)
                        // todo instance of validator
                        ->defaultValue(AnzutapNodeTransformerProvider::class)
                    ->end()
                    ->scalarNode(self::EDITOR_BODY_PREPROCESSOR)
                        ->defaultValue(AnzutapBodyPreprocessor::class)
                        ->end()
                    ->scalarNode(self::EDITOR_BODY_POSTPROCESSOR)
                        ->defaultValue(AnzutapBodyPostprocessor::class)
                        ->end()
                    ->scalarNode(self::EDITOR_NODE_DEFAULT_TRANSFORMER_CLASS)
                        // todo instance of validator
                        ->defaultValue(XSkipTransformer::class)
                    ->end()
                    ->scalarNode(self::EDITOR_MARK_TRANSFORMER_PROVIDER_CLASS)
                        // todo instance of validator
                        ->defaultValue(AnzutapMarkNodeTransformerProvider::class)
                    ->end()
                    ->arrayNode(self::EDITOR_ALLOWED_NODE_TRANSFORMERS)
                        ->defaultValue(self::DEFAULT_ALLOWED_NODE_TRANSFORMERS)
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode(self::EDITOR_ALLOWED_MARK_TRANSFORMERS)
                        ->defaultValue(self::DEFAULT_ALLOWED_MARK_TRANSFORMERS)
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode(self::EDITOR_ALLOWED_HTML_RENDERERS)
                        ->defaultValue([])
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode(self::EDITOR_REMOVE_NODES)
                        ->defaultValue([])
                        ->prototype('scalar')->end()
                    ->end()
                        ->arrayNode(self::EDITOR_SKIP_NODES)
                        ->defaultValue(self::DEFAULT_SKIP_NODES)
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
            ->end();
    }
}
