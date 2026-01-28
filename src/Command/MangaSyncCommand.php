<?php

namespace App\Command;

use App\Message\SyncLibraryMangaMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'app:manga:sync', description: 'Force manga synchronisation')]
class MangaSyncCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bus->dispatch(new SyncLibraryMangaMessage());

        $output->writeln('<info>The sync message has been sent !</info>');

        return Command::SUCCESS;
    }
}
