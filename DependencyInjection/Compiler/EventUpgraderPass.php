<?php

namespace DDDominio\EventSourcingBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EventUpgraderPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('dddominio_event_sourcing.versioning.event_upgrader');

        $taggedServices = $container->findTaggedServiceIds('dddominio.event_upgrade');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('registerUpgrade', [new Reference($id)]);
        }
    }
}
