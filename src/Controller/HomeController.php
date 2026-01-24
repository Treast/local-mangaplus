<?php

namespace App\Controller;

use App\Api\MangaPlusApi;
use App\Manager\SyncManager;
use App\Repository\MangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app.home.')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(MangaRepository $mangaRepository, MangaPlusApi $mangaPlusApi): Response
    {
        dump($mangaPlusApi->getTitlesV3());

        return $this->render('home/index.html.twig', [
            'mangas' => $mangaRepository->findAll(),
        ]);
    }

    #[Route('/sync', name: 'sync')]
    public function sync(SyncManager $syncManager): Response
    {
        $syncManager->sync();

        return $this->redirectToRoute('app.home.index');
    }
}
