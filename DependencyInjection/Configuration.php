<?php

namespace DDDominio\EventSourcingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dddominio_event_sourcing');

        $rootNode
            ->children()
                ->arrayNode('event_store')
                    ->children()
                        ->scalarNode('type')->end()
                        ->scalarNode('connection')->end()
                        ->scalarNode('host')->end()
                        ->scalarNode('port')->end()
                        ->scalarNode('dbname')->end()
                        ->scalarNode('user')->end()
                        ->scalarNode('password')->end()
                    ->end()
                ->end()
                ->arrayNode('snapshot_store')
                    ->children()
                        ->scalarNode('type')->end()
                        ->scalarNode('connection')->end()
                        ->scalarNode('host')->end()
                        ->scalarNode('port')->end()
                        ->scalarNode('dbname')->end()
                        ->scalarNode('user')->end()
                        ->scalarNode('password')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
