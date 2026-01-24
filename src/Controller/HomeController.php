<?php

namespace App\Controller;

use App\Api\MangaPlusApi;
use App\Manager\SyncManager;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app.home.')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index', methods: 'GET')]
    public function index(SerieRepository $serieRepository, MangaPlusApi $mangaPlusApi): Response
    {
        return $this->render('home/index.html.twig', [
            'series' => $serieRepository->getLatestUpdated(),
        ]);
    }

    #[Route('/search', name: 'search', methods: 'POST', condition: 'request.isXmlHttpRequest()')]
    public function search(Request $request, SerieRepository $serieRepository): Response
    {
        $query = $request->query->get('q', '');
        $series = $serieRepository->search($query);

        return $this->render('home/search.html.twig', [
            'series' => $series,
        ]);
    }

    #[Route('/sync', name: 'sync', methods: 'GET')]
    public function sync(SyncManager $syncManager): Response
    {
        $syncManager->sync();

        return $this->redirectToRoute('app.home.index');
    }
}
