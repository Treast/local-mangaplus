<?php

namespace App\EventListener;

use App\Manager\ConfigurationManager;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

readonly class OnboardingListener
{
    public function __construct(
        private ConfigurationManager $configurationManager,
        private UrlGeneratorInterface $urlGenerator
    ) {}

    #[AsEventListener(KernelEvents::REQUEST)]
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        if ($request->isXmlHttpRequest()) {
            return;
        }

        if (
            str_starts_with($route, 'app.onboarding')
            || str_starts_with($route, '_')
        ) {
            return;
        }

        if ($this->configurationManager->getValue('onboarding_done', false)) {
            return;
        }

        $event->setResponse(
            new RedirectResponse($this->urlGenerator->generate('app.onboarding.index'))
        );
    }
}
