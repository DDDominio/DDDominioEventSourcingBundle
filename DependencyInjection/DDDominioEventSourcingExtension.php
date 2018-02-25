<?php

namespace DDDominio\EventSourcingBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
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

        $this->loadEventStore($config, $container);
        $this->loadSnapshotStore($config, $container);

        $repositoryDefinition = $container->getDefinition('dddominio_event_sourcing.common.event_sourced_aggregate_repository');
        $repositoryDefinition->replaceArgument(0, new Reference('dddominio.event_store'));
        $repositoryDefinition->replaceArgument(1, new Reference('dddominio.snapshot_store'));
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadEventStore(array $config, ContainerBuilder $container)
    {
        $type = $config['event_store']['type'];
        $eventStoreDefinitionId = sprintf('dddominio_event_sourcing.event_store.%s_event_store', $type);
        $eventStoreDefinition = $container->getDefinition($eventStoreDefinitionId);
        
        $eventStoreSerializerType = $config['event_store']['serializer'];
        $eventStoreSerializerDefinitionId = sprintf('dddominio_event_sourcing.serialization.%s_serializer', $eventStoreSerializerType);
        $eventStoreSerializerDefinition = $container->getDefinition($eventStoreSerializerDefinitionId);
        $eventStoreDefinition->replaceArgument(1, $eventStoreSerializerDefinition);

        if ($type === 'doctrine_dbal') {
            $eventStoreDefinition->replaceArgument(0, new Reference(sprintf('doctrine.dbal.%s_connection', $config['event_store']['connection'])));
        } else if ($type === 'mysql_json') {
            $pdoDefinition = new Definition();
            $pdoDefinition->setClass(\PDO::class);
            $pdoDefinition->setArguments([
                sprintf('mysql:host=%s;dbname=%s', $config['event_store']['host'], $config['event_store']['dbname']),
                $config['event_store']['user'],
                $config['event_store']['password']
            ]);
            $container->setDefinition('dddominio_event_sourcing.event_store.mysql_json_pdo', $pdoDefinition);
            $eventStoreDefinition->replaceArgument(0, new Reference('dddominio_event_sourcing.event_store.mysql_json_pdo'));
        }

        $container->setAlias('dddominio.event_store', $eventStoreDefinitionId);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadSnapshotStore(array $config, ContainerBuilder $container)
    {
        $type = $config['snapshot_store']['type'];
        $snapshotStoreDefinitionId = sprintf('dddominio_event_sourcing.snapshotting.%s_snapshot_store', $type);
        $snapshotStoreDefinition = $container->getDefinition($snapshotStoreDefinitionId);
        
        $snapshotStoreSerializerType = $config['event_store']['serializer'];
        $snapshotStoreSerializerDefinitionId = sprintf('dddominio_event_sourcing.serialization.%s_serializer', $snapshotStoreSerializerType);
        $snapshotStoreSerializerDefinition = $container->getDefinition($snapshotStoreSerializerDefinitionId);
        $snapshotStoreDefinition->replaceArgument(1, $snapshotStoreSerializerDefinition);

        if ($type === 'doctrine_dbal') {
            $snapshotStoreDefinition->replaceArgument(0, new Reference(sprintf('doctrine.dbal.%s_connection', $config['snapshot_store']['connection'])));
        } else if ($type === 'mysql_json') {
            $pdoDefinition = new Definition();
            $pdoDefinition->setClass(\PDO::class);
            $pdoDefinition->setArguments([
                sprintf('mysql:host=%s;dbname=%s', $config['snapshot_store']['host'], $config['snapshot_store']['dbname']),
                $config['snapshot_store']['user'],
                $config['snapshot_store']['password']
            ]);
            $container->setDefinition('dddominio_event_sourcing.snapshotting.mysql_json_pdo', $pdoDefinition);
            $snapshotStoreDefinition->replaceArgument(0, new Reference('dddominio_event_sourcing.snapshotting.mysql_json_pdo'));
        }

        $container->setAlias('dddominio.snapshot_store', $snapshotStoreDefinitionId);
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'dddominio_event_sourcing';
    }
}
