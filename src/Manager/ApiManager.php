<?php

namespace App\Manager;

use App\DTO\ApiCredentials;
use Doctrine\ORM\EntityManagerInterface;
use Random\Randomizer;

readonly class ApiManager
{
    private const string SECRET_KEY_SALT = '4Kin9vGg';

    public function __construct(
        private ConfigurationManager $configurationManager,
        private EntityManagerInterface $entityManager,
    ) {}

    public function getCredentials(): ApiCredentials
    {
        if (!$androidId = $this->configurationManager->getValue('android_id')) {
            return $this->generateCredentials();
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

    public function generateCredentials(): ApiCredentials
    {
        $androidId = $this->generateAndroidId();
        $this->configurationManager->set('android_id', $androidId);

        $deviceToken = md5($androidId);
        $this->configurationManager->set('device_token', $deviceToken);

        $securityKey = md5($deviceToken . self::SECRET_KEY_SALT);
        $this->configurationManager->set('security_key', $securityKey);

        $this->configurationManager->set('device_secret', null);

        $apiCrendetials = new ApiCredentials()
            ->setAndroidId($androidId)
            ->setDeviceToken($deviceToken)
            ->setSecurityKey($securityKey)
            ->setDeviceSecret(null)
        ;

        $this->entityManager->flush();

        return $apiCrendetials;
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
