<?php

namespace DDDominio\EventSourcingBundle\Tests;

use DDDominio\EventSourcingBundle\DDDominioEventSourcingBundle;
use DDDominio\EventSourcingBundle\DependencyInjection\Compiler\EventUpgraderPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DDDominioEventSourcingBundleTest extends TestCase
{
    /**
     * @test
     */
    public function compilerPassesPresent()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($spy = $this->any())->method('addCompilerPass');
        $bundle = new DDDominioEventSourcingBundle();

        $bundle->build($container);

        $invocations = $spy->getInvocations();
        $firstInvocationParameters = method_exists($invocations[0], 'getParameters') ?
            $invocations[0]->getParameters() :
            $invocations[0]->parameters;
        $this->assertInstanceOf(EventUpgraderPass::class, $firstInvocationParameters[0]);
    }
}
