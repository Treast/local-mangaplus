<?php

namespace App\Validator\DiscordWebhook;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class DiscordWebhook extends Constraint
{
    public string $message = 'Invalid Discord webhook URL.';
}
