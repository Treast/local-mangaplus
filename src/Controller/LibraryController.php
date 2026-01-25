<?php

namespace App\Controller;

use App\Repository\MangaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/library', name: 'app.library.')]
class LibraryController extends AbstractController
{
    #[Route('/', name: 'index', methods: 'GET')]
    public function index(MangaRepository $mangaRepository): Response
    {
        return $this->render('library/index.html.twig', [
            'mangas' => $mangaRepository->findAllInLibrary(),
        ]);
    }
}
