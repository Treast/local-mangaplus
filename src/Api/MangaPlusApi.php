<?php

namespace App\Api;

use App\Api\Protobuf\MangaPlus\Response;
use App\Entity\Manga;
use App\Mapper\TitleMapper;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class MangaPlusApi
{
    public function __construct(
        private HttpClientInterface $mangaPlusClient,
        private TitleMapper $titleMapper,
    ) {}

    /**
     * @return array<Manga>
     */
    public function getTitlesV2(): array
    {
        $response = $this->mangaPlusClient->request('GET', 'title_list/allV2');
        $binaryData = $response->getContent();

        $mangas = [];

        try {
            $apiResponse = new Response();
            $apiResponse->mergeFromString($binaryData);

            foreach ($apiResponse->getSuccess()->getAllTitlesViewV2()->getAllTitlesGroup() as $item) {
                foreach ($item->getTitles() as $title) {
                    $mangas[] = $this->titleMapper->toManga($title);
                }
            }
        } catch (\Exception $e) {
            dump($e);
        }

        return $mangas;
    }
}
