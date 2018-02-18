<?php

namespace DDDominio\EventSourcingBundle\Command;

use DDDominio\EventSourcing\EventStore\InitializableInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitializeSnapshotStoreCommand extends Command
{
    /**
     * @var InitializableInterface
     */
    private $snapshotStore;

    /**
     * InitializeSnapshotStoreCommand constructor.
     * @param InitializableInterface $snapshotStore
     */
    public function __construct(InitializableInterface $snapshotStore)
    {
        parent::__construct();
        $this->snapshotStore = $snapshotStore;
    }

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
        if ($this->snapshotStore->initialized()) {
            $output->writeln('<error>Snapshot Store already initialized</error>');
            return 1;
        }

        $output->writeln('<info>Snapshot store initialized</info>');
        $this->snapshotStore->initialize();

        return 0;
    }
}
