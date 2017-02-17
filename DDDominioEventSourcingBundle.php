<?php

namespace DDDominio\EventSourcingBundle;

use DDDominio\EventSourcingBundle\DependencyInjection\DDDominioEventSourcingExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DDDominioEventSourcingBundle extends Bundle
{
    /**
     * @return DDDominioEventSourcingExtension
     */
    public function getContainerExtension()
    {
        return new DDDominioEventSourcingExtension();
    }
}
