<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use AnzuSystems\AnzutapBundle\Helper\PromoLinkHelper;
use AnzuSystems\AnzutapBundle\ProseMirror\MarkProvider;
use AnzuSystems\AnzutapBundle\ProseMirror\NodeProvider;
use AnzuSystems\AnzutapBundle\ProseMirror\Transformer;
use AnzuSystems\AnzutapBundle\Command\TestCommand;
use AnzuSystems\AnzutapBundle\Provider\EditorProvider;
use AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers\EmbedHandler;
use AnzuSystems\CommonBundle\AnzuSystemsCommonBundle;
use AnzuSystems\SerializerBundle\AnzuSystemsSerializerBundle;
use AnzuSystems\SerializerBundle\Serializer;
use Twig\Environment;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->defaults()
        ->autowire(false)
        ->autoconfigure(false)
    ;

    $services
        ->set(Transformer::class)
        ->arg('$nodeProvider', service(NodeProvider::class))
        ->arg('$markProvider', service(MarkProvider::class))
    ;

    $services->set(TestCommand::class)
        ->arg('$testEditor', service('anzu_systems_common.editor.test'))
        ->arg('$transformer', service(Transformer::class))
        ->arg('$serializer', service(Serializer::class))
        ->tag('console.command')
    ;

    $services
        ->load(
            namespace: 'AnzuSystems\AnzutapBundle\ProseMirror\Mark\\',
            resource: __DIR__ . '/../../ProseMirror/Mark',
        )
        ->tag(AnzuSystemsAnzutapBundle::TAG_PROSEMIRROR_MARK)
    ;

    $services
        ->load(
            namespace: 'AnzuSystems\AnzutapBundle\ProseMirror\Node\\',
            resource: __DIR__ . '/../../ProseMirror/Node',
        )
        ->bind('$twig', service(Environment::class))
        ->tag(AnzuSystemsAnzutapBundle::TAG_PROSEMIRROR_NODE)
    ;

    $services
        ->set(MarkProvider::class)
        ->arg('$markProvider', tagged_locator(AnzuSystemsAnzutapBundle::TAG_PROSEMIRROR_MARK, defaultIndexMethod: 'getMarkType'))
    ;

    $services
        ->set(NodeProvider::class)
        ->arg('$nodeProvider', tagged_locator(AnzuSystemsAnzutapBundle::TAG_PROSEMIRROR_NODE, defaultIndexMethod: 'getNodeType'))
    ;

    $services
        ->set(EmbedHandler::class)
        ->arg('$editorProvider', service(EditorProvider::class))
        ->tag(AnzuSystemsSerializerBundle::TAG_SERIALIZER_HANDLER);
    ;
};
