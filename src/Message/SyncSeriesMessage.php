<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage]
final class SyncSeriesMessage
{
    public function __construct() {}
}
