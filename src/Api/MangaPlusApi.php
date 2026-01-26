<?php

namespace App\Api;

use App\Api\Protobuf\MangaPlus\MangaViewer;
use App\Api\Protobuf\MangaPlus\Page;
use App\Api\Protobuf\MangaPlus\Response;
use App\DTO\ApiCredentials;
use App\Entity\Chapter;
use App\Entity\Manga;
use App\Entity\Serie;
use App\Manager\ApiManager;
use App\Mapper\TitleContainerMapper;
use App\Mapper\TitleDetailViewMapper;
use App\Mapper\TitleMapper;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class MangaPlusApi
{
    public function __construct(
        private HttpClientInterface $mangaPlusClient,
        private TitleMapper $titleMapper,
        private TitleContainerMapper $titleContainerMapper,
        private TitleDetailViewMapper $titleDetailViewMapper,
        private ApiManager $apiManager,
    ) {}

    /**
     * @return array<Manga>
     */
    public function getTitlesV2(): array
    {
        $mangas = [];

        try {
            $response = $this->mangaPlusClient->request('GET', 'title_list/allV2');
            $binaryData = $response->getContent();

            $apiResponse = new Response();
            $apiResponse->mergeFromString($binaryData);

            foreach ($apiResponse->getSuccess()->getAllTitlesViewV2()->getAllTitlesGroup() as $item) {
                foreach ($item->getTitles() as $title) {
                    $mangas[] = $this->titleMapper->toManga($title);
                }
            }
        } catch (\Exception|ExceptionInterface $e) {
        }

        return $mangas;
    }

    /**
     * @return array<Serie>
     */
    public function getTitlesV3(): array
    {
        $apiCrendetials = $this->getCredentials();

        if (!$apiCrendetials->getDeviceSecret()) {
            return [];
        }

        $series = [];

        try {
            $response = $this->mangaPlusClient->request(
                'GET',
                $this->withAuth('title_list/allV3?type=serializing&lang=fra&clang=eng%2Cfra', $apiCrendetials)
            );
            $binaryData = $response->getContent();

            $apiResponse = new Response();
            $apiResponse->mergeFromString($binaryData);

            foreach ($apiResponse->getSuccess()->getAllTitlesViewV3()->getTitles() as $titleContainer) {
                $series[] = $this->titleContainerMapper->toSerie($titleContainer);
            }
        } catch (\Exception|ExceptionInterface) {
        }

        return $series;
    }

    public function getTitleDetailV3(Manga $manga): ?Manga
    {
        $apiCrendetials = $this->getCredentials();

        if (!$apiCrendetials->getDeviceSecret()) {
            return $manga;
        }

        try {
            $response = $this->mangaPlusClient->request(
                'GET',
                $this->withAuth(
                    sprintf('title_detailV3?title_id=%s', $manga->getMangaPlusId()),
                    $apiCrendetials
                )
            );
            $binaryData = $response->getContent();

            $apiResponse = new Response();
            $apiResponse->mergeFromString($binaryData);

            if ($titleDetail = $apiResponse->getSuccess()?->getTitleDetailView()) {
                return $this->titleDetailViewMapper->updateManga($manga, $titleDetail);
            }
        } catch (\Exception|ExceptionInterface) {
        }

        return $manga;
    }

    public function getMangaViewer(Chapter $chapter): ?MangaViewer
    {
        $apiCrendetials = $this->getCredentials();

        if (!$apiCrendetials->getDeviceSecret()) {
            return null;
        }

        try {
            $response = $this->mangaPlusClient->request(
                'GET',
                $this->withAuth(
                    sprintf('manga_viewer?img_quality=super_high&split=yes&chapter_id=%s', $chapter->getMangaPlusId()),
                    $apiCrendetials
                )
            );
            $binaryData = $response->getContent();

            $apiResponse = new Response();
            $apiResponse->mergeFromString($binaryData);

            return $apiResponse->getSuccess()?->getMangaViewer();
        } catch (\Exception|ExceptionInterface) {
        }

        return null;
    }

    public function getPage(Page $page): ?string
    {
        if (!$page->getMangaPage()?->getImageUrl()) {
            return null;
        }

        try {
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
        } catch (\Exception|ExceptionInterface) {
        }

        return null;
    }

    public function registerDevice(ApiCredentials $apiCredentials): ?string
    {
        $response = $this->mangaPlusClient->request(
            'PUT',
            $this->withoutAuth(
                sprintf(
                    'register?device_token=%s&security_key=%s',
                    $apiCredentials->getDeviceToken(),
                    $apiCredentials->getSecurityKey(),
                )
            )
        );

        $binaryData = $response->getContent();

        $apiResponse = new Response();
        $apiResponse->mergeFromString($binaryData);

        if ($deviceSecret = $apiResponse->getSuccess()->getRegisterationData()->getDeviceSecret()) {
            $this->apiManager->setDeviceSecret($deviceSecret);

            return $deviceSecret;
        }

        return null;
    }

    private function withAuth(string $url, ApiCredentials $apiCredentials): string
    {
        return sprintf(
            '%s&security_key=%s',
            $this->withoutAuth($url),
            $apiCredentials->getSecurityKey()
        );
    }

    private function withoutAuth(string $url): string
    {
        return sprintf(
            '%s%sos=android&os_ver=36&app_ver=233',
            $url,
            str_contains($url, '?') ? '&' : '?'
        );
    }

    private function getCredentials(): ApiCredentials
    {
        $apiCrendetials = $this->apiManager->getCredentials();

        if (!$apiCrendetials->getDeviceSecret() && $deviceSecret = $this->registerDevice($apiCrendetials)) {
            $apiCrendetials->setDeviceSecret($deviceSecret);
        }

        return $apiCrendetials;
    }
}
