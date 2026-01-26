<?php

namespace App\DTO;

class Settings
{
    private ?string $androidId = null;
    private ?string $deviceToken = null;
    private ?string $securityKey = null;
    private ?string $deviceSecret = null;
    private ?string $discordWebhook = null;

    public function getAndroidId(): ?string
    {
        return $this->androidId;
    }

    public function setAndroidId(?string $androidId): self
    {
        $this->androidId = $androidId;

        return $this;
    }

    public function getDeviceToken(): ?string
    {
        return $this->deviceToken;
    }

    public function setDeviceToken(?string $deviceToken): self
    {
        $this->deviceToken = $deviceToken;

        return $this;
    }

    public function getSecurityKey(): ?string
    {
        return $this->securityKey;
    }

    public function setSecurityKey(?string $securityKey): self
    {
        $this->securityKey = $securityKey;

        return $this;
    }

    public function getDeviceSecret(): ?string
    {
        return $this->deviceSecret;
    }

    public function setDeviceSecret(?string $deviceSecret): self
    {
        $this->deviceSecret = $deviceSecret;

        return $this;
    }

    public function getDiscordWebhook(): ?string
    {
        return $this->discordWebhook;
    }

    public function setDiscordWebhook(?string $discordWebhook): self
    {
        $this->discordWebhook = $discordWebhook;

        return $this;
    }
}
