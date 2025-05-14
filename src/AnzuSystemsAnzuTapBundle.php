<?php

declare(strict_types=1);

namespace AnzuSystems\AnzuTapBundle;

use AnzuSystems\AnzuTapBundle\DependencyInjection\AnzuSystemsAnzuTapExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AnzuSystemsAnzuTapBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->registerExtension(new AnzuSystemsAnzuTapExtension());
    }
}
