<?php

namespace App\Manager;

use App\Api\RegistrationApi;
use App\DTO\ApiCredentials;
use Random\Randomizer;

readonly class CredentialsManager
{
    private const string SECRET_KEY_SALT = '4Kin9vGg';

    public function __construct(
        private ConfigurationManager $configurationManager,
        private RegistrationApi $registrationApi,
    ) {}

    public function getCredentials(): ApiCredentials
    {
        if (!$androidId = $this->configurationManager->getValue('android_id')) {
            return $this->generateCredentials();
        }

        return new ApiCredentials()
            ->setAndroidId($androidId)
            ->setDeviceToken($this->configurationManager->getValue('device_token'))
            ->setSecurityKey($this->configurationManager->getValue('security_key'))
            ->setDeviceSecret($this->configurationManager->getValue('device_secret'))
        ;
    }

    public function generateCredentials(): ApiCredentials
    {
        $androidId = $this->generateAndroidId();
        $deviceToken = md5($androidId);
        $securityKey = md5($deviceToken . self::SECRET_KEY_SALT);
        $deviceSecret = $this->registrationApi->registerDevice($deviceToken, $securityKey);

        $this->configurationManager->setMany([
            'android_id' => $androidId,
            'device_token' => $deviceToken,
            'security_key' => $securityKey,
            'device_secret' => $deviceSecret,
        ]);

        return new ApiCredentials()
            ->setAndroidId($androidId)
            ->setDeviceToken($deviceToken)
            ->setSecurityKey($securityKey)
            ->setDeviceSecret($deviceSecret)
        ;
    }

    private function generateAndroidId(): string
    {
        $randomizer = new Randomizer();

        return bin2hex($randomizer->getBytes(8));
    }
}
