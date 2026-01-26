<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Message\DownloadChapterMessage;
use App\Repository\ChapterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/chapters', name: 'app.chapters.')]
class ChapterController extends AbstractController
{
    #[Route('/downloads', name: 'downloads', methods: 'GET')]
    public function downloads(ChapterRepository $chapterRepository): Response
    {
        return $this->render('chapters/downloads.html.twig', [
            'chapters' => $chapterRepository->findLatestDownloaded(),
        ]);
    }

    #[Route('/{id}/download', name: 'download', requirements: ['id' => Requirement::DIGITS], methods: 'GET')]
    public function download(Chapter $chapter, MessageBusInterface $messageBus): Response
    {
        $messageBus->dispatch(new DownloadChapterMessage($chapter->getId()));

        $this->addFlash('info', 'The download has started in the background.');

        return $this->redirectToRoute('app.mangas.show', ['id' => $chapter->getManga()->getId()]);
    }
}
