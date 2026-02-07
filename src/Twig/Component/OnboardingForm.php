<?php

namespace App\Twig\Component;

use App\DTO\Onboarding;
use App\Form\OnboardingType;
use App\Manager\NotificationManager;
use App\Manager\OnboardingManager;
use App\Manager\SyncManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('OnboardingForm', template: 'components/OnboardingForm.html.twig')]
final class OnboardingForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?Onboarding $initialFormData = null;

    public function __construct(
        private readonly NotificationManager $notificationManager,
        private readonly OnboardingManager $onboardingManager,
        private readonly SyncManager $syncManager,
    ) {}

    #[LiveAction]
    public function save(): Response
    {
        try {
            $this->submitForm();
        } catch (UnprocessableEntityHttpException $e) {
            $this->notificationManager->error('The form is not valid!');

            return new Response();
        }

        $this->onboardingManager->saveOnboarding($this->initialFormData);

        $this->syncManager->loadMangas();

        return $this->redirectToRoute('app.home.index');
    }

    protected function instantiateForm(): FormInterface
    {
        $this->initialFormData ??= new Onboarding();

        return $this->createForm(OnboardingType::class, $this->initialFormData);
    }
}
