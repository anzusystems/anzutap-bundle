<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle;

use AnzuSystems\AnzutapBundle\DependencyInjection\AnzuSystemsAnzutapExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AnzuSystemsAnzutapBundle extends Bundle
{
    public const TAG_HEALTH_CHECK_MODULE = 'anzu_common_web.health_check.module';
    public const TAG_PROSEMIRROR_NODE = 'anzu_common_web.prosemirror.node';
    public const TAG_PROSEMIRROR_MARK = 'anzu_common_web.prosemirror.mark';

    public function build(ContainerBuilder $container): void
    {
        $container->registerExtension(new AnzuSystemsAnzutapExtension());
    }
}
