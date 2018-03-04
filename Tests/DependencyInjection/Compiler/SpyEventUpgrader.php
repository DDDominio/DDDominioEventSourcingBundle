<?php

namespace DDDominio\EventSourcingBundle\Tests\DependencyInjection\Compiler;

use DDDominio\EventSourcing\EventStore\StoredEvent;
use DDDominio\EventSourcing\Versioning\Annotation\Version;
use DDDominio\EventSourcing\Versioning\EventUpgraderInterface;
use DDDominio\EventSourcing\Versioning\UpgradeInterface;

class SpyEventUpgrader implements EventUpgraderInterface
{
    /**
     * @var array
     */
    private $registeredUpgrades = [];

    /**
     * @param UpgradeInterface $upgrade
     */
    public function registerUpgrade(UpgradeInterface $upgrade)
    {
        $this->registeredUpgrades[get_class($upgrade)] = get_class($upgrade);
    }

    /**
     * @param StoredEvent $storedEvent
     * @param Version $version
     */
    public function migrate(StoredEvent $storedEvent, $version = null)
    {
    }

    /**
     * @param StoredEvent $storedEvent
     * @param Version $version
     */
    public function upgrade(StoredEvent $storedEvent, $version = null)
    {
    }

    /**
     * @param StoredEvent $storedEvent
     * @param Version $version
     */
    public function downgrade(StoredEvent $storedEvent, $version = null)
    {
    }

    /**
     * @return bool
     */
    public function isRegistered($upgradeClass)
    {
        return array_key_exists($upgradeClass, $this->registeredUpgrades);
    }

    /**
     * @return int
     */
    public function upgradesCount()
    {
        return count($this->registeredUpgrades);
    }
}
