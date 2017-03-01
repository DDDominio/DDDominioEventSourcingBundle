<?php

namespace DDDominio\EventSourcingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitializeSnapshotStoreCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dddominio:snapshot-store:initialize')
            ->setDescription('Initialize the Snapshot Store');

    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $snapshotStore = $this->getContainer()->get('dddominio.snapshot_store');

        if ($snapshotStore->initialized()) {
            $output->writeln('<error>Snapshot Store already initialized</error>');
            return 1;
        }

        $output->writeln('<info>Snapshot store initialized</info>');
        $snapshotStore->initialize();

        return 0;
    }
}
