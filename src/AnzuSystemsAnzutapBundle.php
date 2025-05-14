<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle;

use AnzuSystems\AnzutapBundle\DependencyInjection\AnzuSystemsAnzutapExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AnzuSystemsAnzutapBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->registerExtension(new AnzuSystemsAnzutapExtension());
    }
}
