<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage]
final class SyncLibraryMangaMessage
{
    public function __construct() {}
}
