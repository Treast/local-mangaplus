<?php

namespace App\Controller;

use App\Form\SettingsType;
use App\Manager\SettingsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/settings', name: 'app.settings.')]
class SettingsController extends AbstractController
{
    #[Route('/', name: 'index', methods: 'GET|POST')]
    public function index(Request $request, SettingsManager $settingsManager): Response
    {
        $form = $this->createForm(SettingsType::class, $settingsManager->createSettings())
            ->handleRequest($request)
        ;

        if ($form->isSubmitted() && $form->isValid()) {
            $settingsManager->saveSettings($form->getData());

            $this->addFlash('success', 'Settings saved successfully.');

            return $this->redirectToRoute('app.settings.index');
        }

        return $this->render('settings/index.html.twig', [
            'form' => $form,
        ]);
    }
}
