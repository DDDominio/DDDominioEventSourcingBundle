<?php

namespace DDDominio\EventSourcingBundle\Command;

use DDDominio\EventSourcing\EventStore\EventStoreInterface;
use DDDominio\EventSourcing\EventStore\InitializableInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitializeEventStoreCommand extends Command
{
    /**
     * @var EventStoreInterface
     */
    private $eventStore;

    /**
     * InitializeEventStoreCommand constructor.
     * @param InitializableInterface $eventStore
     */
    public function __construct(InitializableInterface $eventStore)
    {
        parent::__construct();
        $this->eventStore = $eventStore;
    }

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
        if ($this->eventStore->initialized()) {
            $output->writeln('<error>Event Store already initialized</error>');
            return 1;
        }

        $output->writeln('<info>Event store initialized</info>');
        $this->eventStore->initialize();

        return 0;
    }
}
