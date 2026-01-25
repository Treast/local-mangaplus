<?php

namespace App\Manager;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Twig\Environment;

readonly class NotificationManager
{
    public function __construct(
        private HubInterface $hub,
        private Environment $twig,
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
}
