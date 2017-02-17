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
                        ->arrayNode('dbal')
                            ->children()
                                ->scalarNode('connection')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
