<?php

namespace DDDominio\EventSourcingBundle;

use DDDominio\EventSourcingBundle\DependencyInjection\Compiler\EventUpgraderPass;
use DDDominio\EventSourcingBundle\DependencyInjection\DDDominioEventSourcingExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DDDominioEventSourcingBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new EventUpgraderPass());
    }

    /**
     * @return DDDominioEventSourcingExtension
     */
    public function getContainerExtension()
    {
        return new DDDominioEventSourcingExtension();
    }
}
