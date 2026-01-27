<?php

namespace App\Api;

use App\Api\Protobuf\MangaPlus\MangaViewer;
use App\Api\Protobuf\MangaPlus\Page;
use App\Entity\Chapter;
use App\Entity\Manga;
use App\Entity\Serie;
use App\Manager\CredentialsManager;
use App\Mapper\TitleContainerMapper;
use App\Mapper\TitleDetailViewMapper;
use App\Mapper\TitleMapper;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class MangaPlusApi extends BaseApi
{
    public function __construct(
        private HttpClientInterface $mangaPlusClient,
        private LoggerInterface $logger,
        private TitleMapper $titleMapper,
        private TitleContainerMapper $titleContainerMapper,
        private TitleDetailViewMapper $titleDetailViewMapper,
        private CredentialsManager $credentialsManager,
    ) {
        parent::__construct($this->mangaPlusClient, $this->logger);
    }

    /**
     * @return array<Manga>
     */
    public function getTitlesV2(): array
    {
        $response = $this->performRequest('title_list/allV2');

        if (!$response) {
            return [];
        }

        $mangas = [];
        foreach ($response->getSuccess()->getAllTitlesViewV2()->getAllTitlesGroup() as $item) {
            foreach ($item->getTitles() as $title) {
                $mangas[] = $this->titleMapper->toManga($title);
            }
        }

        return $mangas;
    }

    /**
     * @return array<Serie>
     */
    public function getTitlesV3(): array
    {
        $apiCrendetials = $this->credentialsManager->getCredentials();

        if (!$apiCrendetials->getDeviceSecret()) {
            return [];
        }

        $url = $this->withAuth('title_list/allV3?type=serializing&lang=fra&clang=eng%2Cfra', $apiCrendetials);

        $response = $this->performRequest($url);

        if (!$response) {
            return [];
        }

        $series = [];
        foreach ($response->getSuccess()->getAllTitlesViewV3()->getTitles() as $titleContainer) {
            $series[] = $this->titleContainerMapper->toSerie($titleContainer);
        }

        return $series;
    }

    public function getTitleDetailV3(Manga $manga): ?Manga
    {
        $apiCrendetials = $this->credentialsManager->getCredentials();

        if (!$apiCrendetials->getDeviceSecret()) {
            return $manga;
        }

        $url = $this->withAuth(
            sprintf('title_detailV3?title_id=%s', $manga->getMangaPlusId()),
            $apiCrendetials
        );

        $response = $this->performRequest($url);

        if (!$response) {
            return $manga;
        }

        if ($titleDetail = $response->getSuccess()?->getTitleDetailView()) {
            return $this->titleDetailViewMapper->updateManga($manga, $titleDetail);
        }

        return $manga;
    }

    public function getMangaViewer(Chapter $chapter): ?MangaViewer
    {
        $apiCrendetials = $this->credentialsManager->getCredentials();

        if (!$apiCrendetials->getDeviceSecret()) {
            return null;
        }

        $url = $this->withAuth(
            sprintf('manga_viewer?img_quality=super_high&split=yes&chapter_id=%s', $chapter->getMangaPlusId()),
            $apiCrendetials
        );

        $response = $this->performRequest($url);

        return $response?->getSuccess()?->getMangaViewer();
    }

    public function getPage(Page $page): ?string
    {
        if (!$page->getMangaPage()?->getImageUrl()) {
            return null;
        }

        $response = $this->mangaPlusClient->request(
            'GET',
            $page->getMangaPage()->getImageUrl(),
            [
                'headers' => [
                    'Content-Type' => 'image/jpeg',
                ],
            ]
        );

        return $response->getContent();
    }
}
