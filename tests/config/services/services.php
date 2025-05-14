<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

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
        ->call('setOption', [Redis::OPT_PREFIX, 'common_web_bundle_' . env('APP_ENV')])
    ;

//    $services
//        ->load(
//            namespace: 'Anzu\CommonWebBundle\Tests\Data\Prosemirror\Node\\',
//            resource: __DIR__ . '/../../data/Prosemirror/Node/',
//        )
//        ->tag(AnzuCommonWebBundle::TAG_PROSEMIRROR_NODE)
//    ;
};
