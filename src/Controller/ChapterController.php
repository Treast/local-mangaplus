<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Manager\ChapterManager;
use App\Message\DownloadChapterMessage;
use App\Repository\ChapterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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

    #[Route('/{id}/read', name: 'read', requirements: ['id' => Requirement::DIGITS], methods: 'GET')]
    public function read(Chapter $chapter, ChapterManager $chapterManager): Response
    {
        $pages = $chapterManager->extractChapterPages($chapter);

        return $this->render('chapters/read.html.twig', [
            'chapter' => $chapter,
            'pages' => $pages,
        ]);
    }

    #[Route('/{id}/save', name: 'save', requirements: ['id' => Requirement::DIGITS], methods: 'GET')]
    public function save(Chapter $chapter, ChapterManager $chapterManager): BinaryFileResponse
    {
        $filename = $chapterManager->getChapterFilename($chapter);

        $cbzPath = $chapter->getCbzPath();

        if (!file_exists($cbzPath)) {
            throw $this->createNotFoundException('Cannot open CBZ.');
        }

        return new BinaryFileResponse($cbzPath)
            ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename)
        ;
    }

    #[Route('{id}/read/{filename}', name: 'image', methods: 'GET')]
    public function image(Chapter $chapter, ChapterManager $chapterManager, string $filename): Response
    {
        $page = $chapterManager->extractChapterPage($chapter, $filename);

        if (null === $page) {
            throw $this->createNotFoundException('Cannot open CBZ.');
        }

        if (false === $page) {
            throw $this->createNotFoundException('Page not found.');
        }

        $response = new Response($page);
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $response->headers->set('Content-Type', $finfo->buffer($page));
        $response->setPublic();
        $response->setMaxAge(3600);

        return $response;
    }
}
