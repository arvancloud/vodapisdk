<?php

namespace Arvan\Vod\Api\V2_0;

use GuzzleHttp\Client;
use Arvan\Vod\HeaderSetup;
use Arvan\Vod\ApiException;
use Arvan\Vod\Configuration;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Arvan\Vod\ObjectSerializer;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\MultipartStream;
use Arvan\Vod\Extensions\CommonFunctions;
use GuzzleHttp\Exception\RequestException;

abstract class BaseClass
{
    use CommonFunctions;

    /**
     * @var ClientInterface
     */
    protected $client = null;
    /**
     * @var Configuration
     */
    protected $config = null;

    /**
     * @var HeaderSetup
     */
    protected $header = null;

    public function __construct()
    {
        $this->client = new Client();
        $this->config = $this->getConfig();
        $this->header = new HeaderSetup();
    }

    /**
     * @return Configuration
     */
    public function getConfig(): Configuration
    {
        if (isset($this->config)) {
            return $this->config;
        }
        $this->config = new Configuration();

        return $this->config;
    }

    /**
     * @return HeaderSetup
     */
    public function getHeader(): HeaderSetup
    {
        return $this->header;
    }

    /**
     * @return Client
     */
    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    /**
     * Create http client request.
     *
     * @return
     */
    public function createClientHttpRequest($params)
    {
        $request = $this->requestGenerator(
            $params['filter'] ?? null,
            $params['page'] ?? null,
            $params['per_page'] ?? null,
            $params['route'] ?? null,
            $params['_tempBody'] ?? null,
            $params['method'] ?? 'GET',
            $params['multipart'] ?? false);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            return [$this->getBodyContents($response->getBody()->getContents()), $statusCode];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Create request for operation 'channelsGet'.
     *
     * @param string $filter   Filter result (optional)
     * @param int    $page     Page number (optional)
     * @param int    $per_page Page limit (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function requestGenerator(
        $filter = null,
        $page = null,
        $per_page = null,
        $route = null,
        $_tempBody = null,
        $method = 'GET',
        $multipart = false)
    {
        $resourcePath = $route;
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';

        // query params
        if ($filter !== null) {
            $queryParams['filter'] = ObjectSerializer::toQueryValue($filter);
        }
        // query params
        if ($page !== null) {
            $queryParams['page'] = ObjectSerializer::toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = ObjectSerializer::toQueryValue($per_page);
        }

        if ($multipart) {
            $headers = $this->header->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->header->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue,
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);
            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\build_query($formParams);
            }
        }

        // this endpoint requires API key authentication
        $apiKey = $this->config->getApiKey();

        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $headers = array_merge(
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            $method,
            $this->config->getHost().$resourcePath.($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option.
     *
     * @throws \RuntimeException on file opening failure
     *
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: '.$this->config->getDebugFile());
            }
        }

        return $options;
    }

    abstract protected function dataBuilder();
}
