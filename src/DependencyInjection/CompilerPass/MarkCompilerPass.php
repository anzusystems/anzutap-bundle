<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\DependencyInjection\CompilerPass;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use AnzuSystems\AnzutapBundle\Model\Mark\MarkInterface;
use AnzuSystems\AnzutapBundle\Provider\MarkFactory;
use Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class MarkCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (false === $container->hasDefinition(MarkFactory::class)) {
            return;
        }

        $marks = array_keys($container->findTaggedServiceIds(AnzuSystemsAnzutapBundle::TAG_MODEL_MARK));

        $markClasses = [];
        /** @var class-string<MarkInterface> $node */
        foreach ($marks as $node) {
            $markClasses[$node::getMarkType()] = $node;
        }

        $container
            ->getDefinition(MarkFactory::class)
            ->setArgument('$markLocator',  new ServiceLocatorArgument($markClasses))
        ;
    }
}
