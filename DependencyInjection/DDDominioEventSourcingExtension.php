<?php

namespace DDDominio\EventSourcingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class DDDominioEventSourcingExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('common.yml');
        $loader->load('event_store.yml');
        $loader->load('serialization.yml');
        $loader->load('snapshotting.yml');
        $loader->load('versioning.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $def = $container->getDefinition('dddominio_event_sourcing.event_store.doctrine_dbal_event_store');
        $def->replaceArgument(0, new Reference(sprintf('doctrine.dbal.%s_connection', $config['event_store']['dbal']['connection'])));
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'dddominio_event_sourcing';
    }
}
