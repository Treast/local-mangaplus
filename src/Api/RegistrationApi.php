<?php

namespace App\Api;

readonly class RegistrationApi extends BaseApi
{
    public function registerDevice(string $deviceToken, string $securityKey): ?string
    {
        $url = sprintf('register?device_token=%s&security_key=%s', $deviceToken, $securityKey);

        $response = $this->performRequest($url, 'PUT');

        if ($deviceSecret = $response?->getSuccess()?->getRegisterationData()?->getDeviceSecret()) {
            return $deviceSecret;
        }

        return null;
    }
}
