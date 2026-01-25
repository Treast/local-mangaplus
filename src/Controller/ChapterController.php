<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Message\DownloadChapterMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chapters', name: 'app.chapters.')]
class ChapterController extends AbstractController
{
    #[Route('/{id}/download', name: 'download', methods: 'GET')]
    public function download(Chapter $chapter, MessageBusInterface $messageBus): Response
    {
        $messageBus->dispatch(new DownloadChapterMessage($chapter->getId()));

        $this->addFlash('info', 'The download has started in the background.');

        return $this->redirectToRoute('app.mangas.show', ['id' => $chapter->getManga()->getId()]);
    }
}
