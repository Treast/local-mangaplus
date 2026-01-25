<?php

namespace App\ImmutableValue;

enum DownloadStatus: string
{
    case NotDownloaded = 'not_downloaded';
    case Downloading = 'downloading';
    case Downloaded = 'downloaded';
    case DownloadingFailed = 'downloading_failed';
}
