<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use AnzuSystems\AnzutapBundle\HtmlRenderer\HtmlRenderer;
use AnzuSystems\AnzutapBundle\Twig\Extension\HtmlRendererExtension;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->defaults()
        ->autowire(false)
        ->autoconfigure(false)
    ;

    $services
        ->set(HtmlRendererExtension::class)
        ->arg('$renderer', service(HtmlRenderer::class))
        ->tag('twig.extension')
    ;
};
