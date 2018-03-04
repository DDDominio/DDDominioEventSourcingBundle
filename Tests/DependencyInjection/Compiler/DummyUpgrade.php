<?php

namespace DDDominio\EventSourcingBundle\Tests\DependencyInjection\Compiler;

use DDDominio\EventSourcing\EventStore\StoredEvent;
use DDDominio\EventSourcing\Versioning\UpgradeInterface;

class DummyUpgrade implements UpgradeInterface
{
    public function upgrade(StoredEvent $event)
    {
    }

    public function downgrade(StoredEvent $event)
    {
    }

    public function eventClass()
    {
    }

    public function from()
    {
    }

    public function to()
    {
    }
}