<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use AnzuSystems\AnzutapBundle\Command\GenerateFixturesCommand;
use AnzuSystems\AnzutapBundle\Command\TestCommand;
use AnzuSystems\AnzutapBundle\DataFixtures\FixturesLoader;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();

    $services
        ->defaults()
        ->autowire(false)
        ->autoconfigure(false)
    ;

    $services->set(TestCommand::class)
        ->tag('console.command')
    ;
};
