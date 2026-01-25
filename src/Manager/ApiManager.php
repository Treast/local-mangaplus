<?php

namespace App\Manager;

use App\DTO\ApiCredentials;
use Random\Randomizer;

readonly class ApiManager
{
    private const string SECRET_KEY_SALT = '4Kin9vGg';

    public function __construct(
        private ConfigurationManager $configurationManager,
    ) {}

    public function getCredentials(): ApiCredentials
    {
        if (!$androidId = $this->configurationManager->getValue('android_id')) {
            $androidId = $this->generateAndroidId();
            $this->configurationManager->set('android_id', $androidId);
        }

        if (!$deviceToken = $this->configurationManager->getValue('device_token')) {
            $deviceToken = md5($androidId);
            $this->configurationManager->set('device_token', $deviceToken);
        }

        if (!$securityKey = $this->configurationManager->getValue('security_key')) {
            $securityKey = md5($deviceToken . self::SECRET_KEY_SALT);
            $this->configurationManager->set('security_key', $securityKey);
        }

        $deviceSecret = $this->configurationManager->getValue('device_secret');

        return new ApiCredentials()
            ->setAndroidId($androidId)
            ->setDeviceToken($deviceToken)
            ->setSecurityKey($securityKey)
            ->setDeviceSecret($deviceSecret)
        ;
    }

    public function setDeviceSecret(string $deviceSecret): void
    {
        $this->configurationManager->set('device_secret', $deviceSecret);
    }

    private function generateAndroidId(): string
    {
        $randomizer = new Randomizer();

        return bin2hex($randomizer->getBytes(8));
    }
}
