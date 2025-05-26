<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use AnzuSystems\AnzutapBundle\HtmlTransformer;
use AnzuSystems\AnzutapBundle\Twig\Extension\HtmlTransformerExtension;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->defaults()
        ->autowire(false)
        ->autoconfigure(false)
    ;

    $services
        ->set(HtmlTransformerExtension::class)
        ->arg('$transformer', service(HtmlTransformer::class))
        ->tag('twig.extension')
    ;
};
