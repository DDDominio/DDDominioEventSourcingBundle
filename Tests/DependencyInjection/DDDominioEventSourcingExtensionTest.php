<?php

namespace DDDominio\EventSourcingBundle\Tests\DependencyInjection;

use DDDominio\EventSourcingBundle\DependencyInjection\DDDominioEventSourcingExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DDDominioEventSourcingExtensionTest extends TestCase
{
    /**
     * @test
     */
    public function loadBasicConfiguration()
    {
        $container = new ContainerBuilder();
        $extension = new DDDominioEventSourcingExtension();

        $configs[]['event_store'] = [
            'type' => 'doctrine_dbal',
            'connection' => 'pdo_mysql',
            'user' => 'user',
            'password' => 'password',
            'serializer' => 'symfony'
        ];

        $configs[]['snapshot_store'] = [
            'type' => 'doctrine_dbal',
            'connection' => 'pdo_mysql',
            'user' => 'user',
            'password' => 'password',
            'serializer' => 'symfony'
        ];

        $extension->load($configs, $container);

        $this->assertTrue($container->hasAlias('dddominio.event_store'));
        $this->assertTrue($container->hasAlias('dddominio.snapshot_store'));
    }
}
