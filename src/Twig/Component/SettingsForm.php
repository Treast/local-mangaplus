<?php

namespace App\Twig\Component;

use App\DTO\Settings;
use App\Form\SettingsType;
use App\Manager\CredentialsManager;
use App\Manager\NotificationManager;
use App\Manager\SettingsManager;
use App\Message\SyncLibraryMangaMessage;
use App\Message\SyncSeriesMessage;
use App\Validator\DiscordWebhook\DiscordWebhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('SettingsForm', template: 'components/SettingsForm.html.twig')]
final class SettingsForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?Settings $formData = null;

    public function __construct(
        private readonly SettingsManager $settingsManager,
        private readonly CredentialsManager $credentialsManager,
        private readonly NotificationManager $notificationManager,
        private readonly MessageBusInterface $bus,
    ) {}

    public function mount(): void
    {
        $this->formData = $this->settingsManager->createSettings();
    }

    #[LiveAction]
    public function regenerateCredentials(): void
    {
        $this->credentialsManager->generateCredentials();

        $this->formData = $this->settingsManager->createSettings();

        $this->getForm()->setData($this->formData);
    }

    #[LiveAction]
    public function testDiscordWebhook(ValidatorInterface $validator): void
    {
        $discordWebhook = $this->formData->getDiscordWebhook();

        if (empty($discordWebhook)) {
            $this->notificationManager->error('Cannot test an empty Discord webhook URL.');

            return;
        }

        $violations = $validator->validate($discordWebhook, new DiscordWebhook());

        if ($violations->count() > 0) {
            $this->notificationManager->error('Cannot test an invalid Discord webhook URL.');

            return;
        }

        $this->notificationManager->success('A test notification has been sent to Discord.');
        $this->notificationManager->sendDiscordMessage('Test successful !', $this->formData->getDiscordWebhook());
    }

    #[LiveAction]
    public function save(): void
    {
        try {
            $this->submitForm();
        } catch (UnprocessableEntityHttpException $e) {
            $this->notificationManager->error('Cannot save settings!');

            return;
        }

        $this->settingsManager->saveSettings($this->formData);

        $this->notificationManager->success('Settings saved successfully.');
    }

    #[LiveAction]
    public function syncAllSeries(): void
    {
        $this->bus->dispatch(new SyncSeriesMessage());
    }

    #[LiveAction]
    public function downloadChapters(): void
    {
        $this->bus->dispatch(new SyncLibraryMangaMessage());
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(SettingsType::class, $this->formData);
    }
}
