<?php

namespace App\Twig;

use App\Repository\ConfigurationRepository;
use Twig\Attribute\AsTwigFunction;

final readonly class ConfigurationExtension
{
    public function __construct(
        private ConfigurationRepository $configurationRepository
    ) {}

    #[AsTwigFunction('get_last_sync')]
    public function getLastSync(): ?\DateTime
    {
        return $this->configurationRepository->getValue('last_sync');
    }
}
