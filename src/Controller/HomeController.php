<?php

namespace App\Controller;

use App\Api\MangaPlusApi;
use App\Manager\SyncManager;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app.home.')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SerieRepository $serieRepository, MangaPlusApi $mangaPlusApi): Response
    {
        return $this->render('home/index.html.twig', [
            'series' => $serieRepository->getLatestUpdated(),
        ]);
    }

    #[Route('/sync', name: 'sync')]
    public function sync(SyncManager $syncManager): Response
    {
        $syncManager->sync();

        return $this->redirectToRoute('app.home.index');
    }
}
