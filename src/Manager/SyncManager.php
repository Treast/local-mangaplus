<?php

namespace App\Manager;

use App\Message\SyncSeriesMessage;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class SyncManager
{
    public function __construct(
        private MessageBusInterface $bus
    ) {}

    public function sync(): void
    {
        $this->bus->dispatch(new SyncSeriesMessage());
    }
}
