<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\Tests;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use AnzuSystems\AnzutapBundle\Kernel\AnzutapKernel;
use AnzuSystems\SerializerBundle\AnzuSystemsSerializerBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class AnzuTestKernel extends AnzutapKernel
{
    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new TwigBundle();
        yield new AnzuSystemsSerializerBundle();
        yield new AnzuSystemsAnzutapBundle();
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import(__DIR__ . '/config/{packages}/*.yaml');
        $container->import(__DIR__ . '/config/{services}/*.php');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
    }

    protected function getAppClassFactory(): callable
    {
        return AppTest::init(...);
    }
}
