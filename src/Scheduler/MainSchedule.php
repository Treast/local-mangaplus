<?php

namespace App\Scheduler;

use App\Message\SyncLibraryMangaMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule('mainschedule')]
final class MainSchedule implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        $syncLibraryManga = RecurringMessage::cron('0 */4 * * *', new SyncLibraryMangaMessage());

        return new Schedule()
            ->with(
                $syncLibraryManga
            )
        ;
    }
}
