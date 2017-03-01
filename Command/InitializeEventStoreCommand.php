<?php

namespace DDDominio\EventSourcingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitializeEventStoreCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dddominio:event-store:initialize')
            ->setDescription('Initialize the event store');

    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $eventStore = $this->getContainer()->get('dddominio.event_store');

        if ($eventStore->initialized()) {
            $output->writeln('<error>Event Store already initialized</error>');
            return 1;
        }

        $output->writeln('<info>Event store initialized</info>');
        $eventStore->initialize();

        return 0;
    }
}
