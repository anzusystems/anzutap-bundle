<?php

declare(strict_types=1);

namespace AnzuSystems\AnzuTapBundle\Tests;

use AnzuSystems\SerializerBundle\AnzuSystemsSerializerBundle;
use AnzuSystems\AnzuTapBundle\Kernel\AnzuTapKernel;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Anzusystems\AnzuTapBundle\AnzuSystemsAnzuTapBundle;

final class AnzuTestKernel extends AnzuTapKernel
{
    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
        yield new TwigBundle();
        yield new AnzuSystemsSerializerBundle();
        yield new AnzuSystemsAnzuTapBundle();
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
