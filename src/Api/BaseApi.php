<?php

namespace App\Api;

use App\Api\Protobuf\MangaPlus\Response;
use App\DTO\ApiCredentials;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class BaseApi
{
    public const string COMMON_QUERY_PARAMS = 'os=android&os_ver=36&app_ver=233';

    public function __construct(
        private HttpClientInterface $mangaPlusClient,
        private LoggerInterface $logger,
    ) {}

    /**
     * @param array<array<string, string>> $options
     */
    public function performRequest(string $url, string $method = 'GET', array $options = []): ?Response
    {
        $url = sprintf(
            '%s%s%s',
            $url,
            str_contains($url, '?') ? '&' : '?',
            self::COMMON_QUERY_PARAMS
        );

        try {
            $response = $this->mangaPlusClient->request($method, $url, $options);

            $binaryData = $response->getContent();
            $apiResponse = new Response();
            $apiResponse->mergeFromString($binaryData);

            if ($error = $apiResponse->getError()) {
                $this->logger->error(
                    sprintf(
                        'MangaPlus API request to %s return an error: %s',
                        $url,
                        $error->serializeToJsonString()
                    )
                );

                return null;
            }

            return $apiResponse;
        } catch (ExceptionInterface $e) {
            $this->logger->error(
                sprintf(
                    'MangaPlus API request to %s failed: %s',
                    $url,
                    $e->getMessage()
                )
            );
        }

        return null;
    }

    protected function withAuth(string $url, ApiCredentials $apiCredentials): string
    {
        return sprintf(
            '%s%ssecurity_key=%s',
            $url,
            str_contains($url, '?') ? '&' : '?',
            $apiCredentials->getSecurityKey()
        );
    }
}
