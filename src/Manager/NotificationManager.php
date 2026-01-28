<?php

namespace App\Manager;

use App\Api\DiscordApi;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Twig\Environment;

readonly class NotificationManager
{
    public function __construct(
        private HubInterface $hub,
        private Environment $twig,
        private DiscordApi $discordApi,
        private ConfigurationManager $configurationManager,
    ) {}

    public function notify(string $type, string $message): void
    {
        $htmlContent = $this->twig->render('_flash_message.html.twig', [
            'label' => $type,
            'message' => $message,
        ]);

        $update = new Update(
            'notifications',
            json_encode(['html' => $htmlContent])
        );

        $this->hub->publish($update);
    }

    public function info(string $message): void
    {
        $this->notify('info', $message);
    }

    public function error(string $message): void
    {
        $this->notify('error', $message);
    }

    public function success(string $message): void
    {
        $this->notify('success', $message);
    }

    public function sendDiscordMessage(string $message, ?string $webhookUrl = null): void
    {
        $url = $webhookUrl ?: $this->configurationManager->getValue('discord_webhook');

        if (!$url) {
            return;
        }

        $this->discordApi->sendMessage($url, $message);
    }
}
