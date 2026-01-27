<?php

namespace App\Api;

use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class DiscordApi
{
    public function __construct(
        private HttpClientInterface $httpClient,
    ) {}

    public function sendMessage(string $webhookUrl, string $message): void
    {
        try {
            $this->httpClient->request('POST', $webhookUrl, [
                'json' => [
                    'content' => $message,
                    'username' => 'Local MangaPlus',
                    'avatar_url' => 'https://treast.dev/mangaplus_downloader.png',
                ],
            ]);
        } catch (\Exception $e) {
        }
    }
}
