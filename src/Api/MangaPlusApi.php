<?php

namespace App\Api;

use App\Api\Protobuf\MangaPlus\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class MangaPlusApi {
    public function __construct(
        private HttpClientInterface $mangaPlusClient
    ) {}

    public function getTitlesV2(): array {
        $response = $this->mangaPlusClient->request('GET', 'title_list/allV2');
        $binaryData = $response->getContent();

        try {
            $apiResponse = new Response();
            $apiResponse->mergeFromString($binaryData);
            dump(iterator_to_array($apiResponse->getSuccess()->getAllTitlesViewV2()->getAllTitlesGroup()));
        } catch (\Exception $e) {
            dump($e);
        }


        return [];
    }
}
