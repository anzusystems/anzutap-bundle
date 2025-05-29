<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use AnzuSystems\AnzutapBundle\Editor\EditorProvider;
use AnzuSystems\AnzutapBundle\Factory\MarkFactory;
use AnzuSystems\AnzutapBundle\Factory\NodeFactory;
use AnzuSystems\AnzutapBundle\HtmlRenderer\HtmlRenderer;
use AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers\MarkHandler;
use AnzuSystems\AnzutapBundle\Serializer\Handler\Handlers\NodeHandler;
use AnzuSystems\SerializerBundle\AnzuSystemsSerializerBundle;
use AnzuSystems\SerializerBundle\Serializer;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->defaults()
        ->autowire(false)
        ->autoconfigure(false)
    ;

    $services
        ->load(
            namespace: 'AnzuSystems\AnzutapBundle\Model\Node\\',
            resource: __DIR__ . '/../../Model/Node',
        )
        ->tag(AnzuSystemsAnzutapBundle::TAG_MODEL_NODE)
    ;

    $services
        ->load(
            namespace: 'AnzuSystems\AnzutapBundle\Model\Mark\\',
            resource: __DIR__ . '/../../Model/Mark',
        )
        ->tag(AnzuSystemsAnzutapBundle::TAG_MODEL_MARK)
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
        ->set(HtmlRenderer::class)
        ->arg('$editorProvider', service(EditorProvider::class))
    ;

    $services
        ->set(NodeHandler::class)
        ->arg('$nodeFactory', service(NodeFactory::class))
        ->tag(AnzuSystemsSerializerBundle::TAG_SERIALIZER_HANDLER)
    ;

    $services
        ->set(MarkHandler::class)
        ->arg('$markFactory', service(MarkFactory::class))
        ->tag(AnzuSystemsSerializerBundle::TAG_SERIALIZER_HANDLER)
    ;
};
