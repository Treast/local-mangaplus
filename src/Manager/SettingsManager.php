<?php

namespace App\Manager;

use App\DTO\Settings;
use App\Entity\Configuration;

readonly class SettingsManager
{
    public function __construct(
        private ConfigurationManager $configurationManager,
    ) {}

    public function createSettings(): Settings
    {
        return new Settings()
            ->setAndroidId($this->configurationManager->getValue('android_id'))
            ->setDeviceToken($this->configurationManager->getValue('device_token'))
            ->setSecurityKey($this->configurationManager->getValue('security_key'))
            ->setDeviceSecret($this->configurationManager->getValue('device_secret'))
            ->setFormatNaming($this->configurationManager->getValue('format_naming', Configuration::DEFAULT_FORMAT_NAMING))
            ->setDiscordWebhook($this->configurationManager->getValue('discord_webhook'))
        ;
    }

    public function saveSettings(Settings $settings): void
    {
        $this->configurationManager->set('format_naming', $settings->getFormatNaming());
        $this->configurationManager->set('discord_webhook', $settings->getDiscordWebhook());
    }
}
