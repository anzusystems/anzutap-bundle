<?php

declare(strict_types=1);

namespace AnzuSystems\AnzutapBundle\DependencyInjection\CompilerPass;

use AnzuSystems\AnzutapBundle\AnzuSystemsAnzutapBundle;
use AnzuSystems\AnzutapBundle\Factory\NodeFactory;
use AnzuSystems\AnzutapBundle\Model\Node\NodeInterface;
use Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class NodeCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (false === $container->hasDefinition(NodeFactory::class)) {
            return;
        }

        $nodes = array_keys($container->findTaggedServiceIds(AnzuSystemsAnzutapBundle::TAG_MODEL_NODE));

        $nodeClasses = [];
        /** @var class-string<NodeInterface> $node */
        foreach ($nodes as $node) {
            $nodeClasses[$node::getNodeType()] = $node;
        }

        $container
            ->getDefinition(NodeFactory::class)
            ->setArgument('$nodesLocator', new ServiceLocatorArgument($nodeClasses))
        ;
    }
}
