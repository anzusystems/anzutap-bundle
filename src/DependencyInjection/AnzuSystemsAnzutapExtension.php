<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\DependencyInjection;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use AnzuSystems\AnzutapBundle\Anzutap\AnzutapBodyPostprocessor;
use AnzuSystems\AnzutapBundle\Anzutap\AnzutapBodyPreprocessor;
use AnzuSystems\AnzutapBundle\Anzutap\AnzutapEditor;
use AnzuSystems\AnzutapBundle\Anzutap\HtmlRendererInterface;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Mark\AnzuMarkTransformerInterface;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Mark\LinkNodeTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Mark\MarkNodeTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\AnchorTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\AnzuNodeTransformerInterface;
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
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\XRemoveTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\Transformer\Node\XSkipTransformer;
use AnzuSystems\AnzutapBundle\Anzutap\TransformerProvider\AnzutapMarkNodeTransformerProvider;
use AnzuSystems\AnzutapBundle\Anzutap\TransformerProvider\AnzutapNodeTransformerProvider;
use AnzuSystems\AnzutapBundle\Model\Node\AnzutapNodeInterface;
use AnzuSystems\AnzutapBundle\Provider\EditorProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;

final class AnzuSystemsAnzutapExtension extends Extension implements PrependExtensionInterface
{
    private array $processedConfig;

    public function prepend(ContainerBuilder $container): void
    {
        $this->processedConfig = $this->processConfiguration(
            new Configuration(),
            $container->getExtensionConfig($this->getAlias())
        );
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');

        $container
            ->registerForAutoconfiguration(AnzutapNodeInterface::class)
            ->addTag(AnzuSystemsAnzutapBundle::TAG_MODEL_NODE)
        ;

        $this->loadEditors($container);
    }

    private function loadEditors(ContainerBuilder $container): void
    {
        $editors = $this->processedConfig[Configuration::EDITORS] ?? [];

        if (empty($editors)) {
            return;
        }

        $defaultEditorName = $this->processedConfig[Configuration::DEFAULT_EDITOR_NAME] ?? (string) array_key_first($editors);

        if (false === isset($editors[$defaultEditorName])) {
            throw new InvalidArgumentException(
                sprintf(
                    'Default editor not found in %s.%s configuration. Available editors are: (%s).',
                    Configuration::ANZU_SYSTEMS_ANZUTAP,
                    Configuration::EDITORS,
                    implode(', ', array_keys($editors))
                )
            );
        }

        $definition = new Definition(AnzutapBodyPreprocessor::class);
        $container->setDefinition(AnzutapBodyPreprocessor::class, $definition);

        $definition = new Definition(AnzutapBodyPostprocessor::class);
        $container->setDefinition(AnzutapBodyPostprocessor::class, $definition);

        // MarkTransformerProviderInterface
        $definition = new Definition(AnzutapMarkNodeTransformerProvider::class);
        $container->setDefinition(AnzutapMarkNodeTransformerProvider::class, $definition);

        // MarkTransformerProviderInterface
        $definition = new Definition(AnzutapNodeTransformerProvider::class);
        $container->setDefinition(AnzutapNodeTransformerProvider::class, $definition);

        // AnzuMarkTransformerInterface
        $definition = new Definition(LinkNodeTransformer::class);
        $container->setDefinition(LinkNodeTransformer::class, $definition);

        $definition = new Definition(MarkNodeTransformer::class);
        $container->setDefinition(MarkNodeTransformer::class, $definition);

        // AnzuNodeTransformerInterface
        $definition = new Definition(XSkipTransformer::class);
        $container->setDefinition(XSkipTransformer::class, $definition);

        $definition = new Definition(XRemoveTransformer::class);
        $container->setDefinition(XRemoveTransformer::class, $definition);

        $definition = new Definition(AnchorTransformer::class);
        $container->setDefinition(AnchorTransformer::class, $definition);

        $definition = new Definition(BulletListTransformer::class);
        $container->setDefinition(BulletListTransformer::class, $definition);

        $definition = new Definition(HeadingTransformer::class);
        $container->setDefinition(HeadingTransformer::class, $definition);

        $definition = new Definition(HorizontalRuleTransformer::class);
        $container->setDefinition(HorizontalRuleTransformer::class, $definition);

        $definition = new Definition(LineBreakTransformer::class);
        $container->setDefinition(LineBreakTransformer::class, $definition);

        $definition = new Definition(ListItemTransformer::class);
        $container->setDefinition(ListItemTransformer::class, $definition);

        $definition = new Definition(OrderedListTransformer::class);
        $container->setDefinition(OrderedListTransformer::class, $definition);

        $definition = new Definition(ParagraphNodeTransformer::class);
        $container->setDefinition(ParagraphNodeTransformer::class, $definition);

        $definition = new Definition(TableCellTransformer::class);
        $container->setDefinition(TableCellTransformer::class, $definition);

        $definition = new Definition(TableRowTransformer::class);
        $container->setDefinition(TableRowTransformer::class, $definition);

        $definition = new Definition(TableTransformer::class);
        $container->setDefinition(TableTransformer::class, $definition);

        $definition = new Definition(TextNodeTransformer::class);
        $container->setDefinition(TextNodeTransformer::class, $definition);

        $editorReferences = [];
        foreach ($editors as $editorName => $editorConfig) {
            $definition = new Definition(AnzutapEditor::class);
            $definition->setArgument('$transformerProvider', new Reference($editorConfig[Configuration::EDITOR_NODE_TRANSFORMER_PROVIDER_CLASS]));
            $definition->setArgument('$markTransformerProvider', new Reference($editorConfig[Configuration::EDITOR_MARK_TRANSFORMER_PROVIDER_CLASS]));
            $definition->setArgument('$defaultTransformer', new Reference($editorConfig[Configuration::EDITOR_NODE_DEFAULT_TRANSFORMER_CLASS]));
            $definition->setArgument('$preprocessor', new Reference($editorConfig[Configuration::EDITOR_BODY_PREPROCESSOR]));
            $definition->setArgument('$postprocessor', new Reference($editorConfig[Configuration::EDITOR_BODY_POSTPROCESSOR]));

            $allowedNodeTransformers = [];
            /** @var class-string<AnzuNodeTransformerInterface> $serviceName */
            foreach ($editorConfig[Configuration::EDITOR_ALLOWED_NODE_TRANSFORMERS] ?? [] as $serviceName) {
                foreach ($serviceName::getSupportedNodeNames() as $supportedNodeName) {
                    $allowedNodeTransformers[$supportedNodeName] = new Reference($serviceName);
                }
            }

            foreach ($editorConfig[Configuration::EDITOR_REMOVE_NODES] ?? [] as $nodeName) {
                $allowedNodeTransformers[$nodeName] = new Reference(XRemoveTransformer::class);
            }

            foreach ($editorConfig[Configuration::EDITOR_SKIP_NODES] ?? [] as $nodeName) {
                $allowedNodeTransformers[$nodeName] = new Reference(XSkipTransformer::class);
            }

            $allowedMarkTransformers = [];
            /** @var class-string<AnzuMarkTransformerInterface> $serviceName */
            foreach ($editorConfig[Configuration::EDITOR_ALLOWED_MARK_TRANSFORMERS] ?? [] as $serviceName) {
                foreach ($serviceName::getSupportedNodeNames() as $supportedNodeName) {
                    $allowedMarkTransformers[$supportedNodeName] = new Reference($serviceName);
                }
            }

            $allowedHtmlRenderers = [];
            /** @var class-string<HtmlRendererInterface> $serviceName */
            foreach ($editorConfig[Configuration::EDITOR_ALLOWED_HTML_RENDERERS] ?? [] as $serviceName) {
                foreach ($serviceName::getSupportedNodeNames() as $supportedNodeName) {
                    $allowedHtmlRenderers[$supportedNodeName] = new Reference($serviceName);
                }
            }

            $definition
                ->setArgument('$resolvedNodeTransformers', new ServiceLocatorArgument($allowedNodeTransformers))
                ->setArgument('$resolvedMarkTransformers', new ServiceLocatorArgument($allowedMarkTransformers))
                ->setArgument('$resolvedHtmlRenderers', new ServiceLocatorArgument($allowedHtmlRenderers))
            ;

            $container->setDefinition(sprintf('%s $%sEditor', AnzutapEditor::class, $editorName), $definition);
            $editorNameDefinition = sprintf('%s.editor.%s', Configuration::ANZU_SYSTEMS_ANZUTAP, $editorName);
            $container->setDefinition($editorNameDefinition, $definition);

            $editorReferences[$editorName] = new Reference($editorNameDefinition);
        }

        $container->setDefinition(
            EditorProvider::class,
            (new Definition(EditorProvider::class))
                ->setArgument('$editorLocator', new ServiceLocatorArgument($editorReferences))
                ->setArgument('$defaultEditorName', $defaultEditorName)
        );
    }
}
