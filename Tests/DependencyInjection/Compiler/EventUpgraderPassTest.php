<?php

namespace DDDominio\EventSourcingBundle\Tests\DependencyInjection\Compiler;

use DDDominio\EventSourcingBundle\DependencyInjection\Compiler\EventUpgraderPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class EventUpgraderPassTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    protected function setUp(): void
    {
        $container = new ContainerBuilder();
        $eventUpgraderDefinition = new Definition(SpyEventUpgrader::class);
        $eventUpgraderDefinition->setPublic(true);
        $container->setDefinition('dddominio_event_sourcing.versioning.event_upgrader', $eventUpgraderDefinition);
        $this->container = $container;
    }

    /**
     * @test
     * @throws \Exception
     */
    public function addUpgradesToEventUpgrader()
    {
        $this->addUpgradeToContainer(DummyUpgrade::class);

        $eventUpgraderPass = new EventUpgraderPass();
        $eventUpgraderPass->process($this->container);

        $this->container->compile();
        $upgrader = $this->container->get('dddominio_event_sourcing.versioning.event_upgrader');
        $this->assertSame(1, $upgrader->upgradesCount());
        $this->assertTrue($upgrader->isRegistered(DummyUpgrade::class));
    }

    /**
     * @test
     * @throws \Exception
     */
    public function notTaggedUpgradesAreNotRegistered()
    {
        $this->addNotTaggedUpgradeToContainer(DummyUpgrade::class);

        $eventUpgraderPass = new EventUpgraderPass();
        $eventUpgraderPass->process($this->container);

        $this->container->compile();
        $upgrader = $this->container->get('dddominio_event_sourcing.versioning.event_upgrader');
        $this->assertSame(0, $upgrader->upgradesCount());
        $this->assertFalse($upgrader->isRegistered(DummyUpgrade::class));
    }

    /**
     * @param string $upgradeClass
     */
    private function addUpgradeToContainer($upgradeClass)
    {
        $upgradeDefinition = new Definition($upgradeClass);
        $upgradeDefinition->addTag('dddominio.event_upgrade');
        $this->container->setDefinition('upgrade', $upgradeDefinition);
    }

    /**
     * @param string $upgradeClass
     */
    private function addNotTaggedUpgradeToContainer($upgradeClass)
    {
        $this->container->setDefinition('upgrade', new Definition($upgradeClass));
    }
}
