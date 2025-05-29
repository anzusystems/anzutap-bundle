<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle;

use AnzuSystems\AnzutapBundle\DependencyInjection\AnzuSystemsAnzutapExtension;
use AnzuSystems\AnzutapBundle\DependencyInjection\CompilerPass\MarkCompilerPass;
use AnzuSystems\AnzutapBundle\DependencyInjection\CompilerPass\NodeCompilerPass;
use AnzuSystems\AnzutapBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AnzuSystemsAnzutapBundle extends Bundle
{
    public const string TAG_MODEL_NODE = Configuration::ANZU_SYSTEMS_ANZUTAP . '.model.node';
    public const string TAG_MODEL_MARK = Configuration::ANZU_SYSTEMS_ANZUTAP . '.model.mark';

    public function build(ContainerBuilder $container): void
    {
        $container->registerExtension(new AnzuSystemsAnzutapExtension());
        $container->addCompilerPass(new NodeCompilerPass());
        $container->addCompilerPass(new MarkCompilerPass());
    }
}
