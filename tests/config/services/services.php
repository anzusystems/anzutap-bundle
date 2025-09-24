<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use AnzuSystems\AnzutapBundle\Factory\DocumentRenderableFactory;
use AnzuSystems\AnzutapBundle\Tests\Data\HtmlRenderer\AdHtmlRenderer;
use AnzuSystems\AnzutapBundle\Tests\Data\HtmlRenderer\ContentLockHtmlRenderer;
use AnzuSystems\SerializerBundle\Serializer;
use Redis;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public()
    ;

    $services->set('TestRedis', Redis::class)
        ->call('connect', [env('REDIS_HOST'), env('REDIS_PORT')->int()])
        ->call('select', [env('REDIS_DB')->int()])
        ->call('setOption', [Redis::OPT_PREFIX, 'anzutap_bundle_' . env('APP_ENV')])
    ;

    $services
        ->set(DocumentRenderableFactory::class)
        ->arg('$serializer', service(Serializer::class))
    ;

    $services->set(AdHtmlRenderer::class);
    $services->set(ContentLockHtmlRenderer::class);
};
