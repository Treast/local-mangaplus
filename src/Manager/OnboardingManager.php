<?php

namespace App\Manager;

use App\DTO\Onboarding;

readonly class OnboardingManager
{
    public function __construct(
        private ConfigurationManager $configurationManager
    ) {}

    public function saveOnboarding(Onboarding $onboarding): void
    {
        $this->configurationManager->set('languages', $onboarding->getLanguages());
        $this->configurationManager->set('onboarding_done', true);
    }
}
