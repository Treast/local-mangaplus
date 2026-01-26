<?php

namespace App\Twig\Component;

use App\Form\SettingsType;
use App\Manager\ApiManager;
use App\Manager\SettingsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('SettingsForm', template: 'components/SettingsForm.html.twig')]
final class SettingsForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    public function __construct(
        private readonly SettingsManager $settingsManager,
        private readonly ApiManager $apiManager,
    ) {}

    #[LiveAction]
    public function regenerateCredentials(): void
    {
        $this->apiManager->generateCredentials();

        $settings = $this->settingsManager->createSettings();

        $this->getForm()->setData($settings);
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SettingsType::class, $this->settingsManager->createSettings());
    }
}
