<?php

namespace App\Controller;

use App\Api\MangaPlusApi;
use App\Entity\Manga;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/mangas', name: 'app.mangas.')]
class MangaController extends AbstractController
{
    #[Route('/{id}', name: 'show', requirements: ['id' => Requirement::DIGITS])]
    public function show(Manga $manga, MangaPlusApi $mangaPlusApi): Response
    {
        if ($manga->shouldSync()) {
            $mangaPlusApi->getTitleDetailV3($manga);
        }

        return $this->render('mangas/show/index.html.twig', [
            'manga' => $manga,
        ]);
    }

    #[Route('/{id}/sync', name: 'sync', requirements: ['id' => Requirement::DIGITS])]
    public function sync(Manga $manga, MangaPlusApi $mangaPlusApi): Response
    {
        $mangaPlusApi->getTitleDetailV3($manga);

        return $this->redirectToRoute('app.mangas.show', ['id' => $manga->getId()]);
    }

    #[Route('/explore', name: 'explore', methods: 'GET')]
    public function explore(): Response
    {
        return $this->render('mangas/explore.html.twig');
    }
}
