<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use AnzuSystems\AnzutapBundle\HtmlTransformer;
use AnzuSystems\AnzutapBundle\ProseMirror\MarkProvider;
use AnzuSystems\AnzutapBundle\ProseMirror\NodeProvider;
use AnzuSystems\AnzutapBundle\ProseMirror\Transformer;
use AnzuSystems\AnzutapBundle\Provider\EditorProvider;
use AnzuSystems\AnzutapBundle\Provider\MarkFactory;
use AnzuSystems\AnzutapBundle\Provider\NodeFactory;
use AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers\EmbedHandler;
use AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers\MarkHandler;
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

    $services
        ->load(
            namespace: 'AnzuSystems\AnzutapBundle\Model\Anzutap\Node\\',
            resource: __DIR__ . '/../../Model/Anzutap/Node',
        )
        ->tag(AnzuSystemsAnzutapBundle::TAG_MODEL_NODE)
    ;

    $services
        ->load(
            namespace: 'AnzuSystems\AnzutapBundle\Model\Anzutap\Mark\\',
            resource: __DIR__ . '/../../Model/Anzutap/Mark',
        )
        ->tag(AnzuSystemsAnzutapBundle::TAG_MODEL_MARK)
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
        ->set(NodeFactory::class)
        ->arg('$serializer', service(Serializer::class))
    ;

    $services
        ->set(MarkFactory::class)
        ->arg('$serializer', service(Serializer::class))
    ;

    $services
        ->set(HtmlTransformer::class)
        ->arg('$serializer', service(Serializer::class))
        ->arg('$editorProvider', service(EditorProvider::class))
    ;

    $services
        ->set(EmbedHandler::class)
        ->arg('$editorProvider', service(EditorProvider::class))
        ->arg('$nodeFactory', service(NodeFactory::class))
        ->tag(AnzuSystemsSerializerBundle::TAG_SERIALIZER_HANDLER)
    ;

    $services
        ->set(MarkHandler::class)
        ->arg('$markFactory', service(MarkFactory::class))
        ->tag(AnzuSystemsSerializerBundle::TAG_SERIALIZER_HANDLER)
    ;
};
