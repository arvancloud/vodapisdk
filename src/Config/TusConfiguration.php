<?php

namespace Arvan\Vod\Config;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\ClientInterface;
use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Swagger\Client\HeaderSelector;
use GuzzleHttp\Psr7\MultipartStream;
use Swagger\Client\ObjectSerializer;
use GuzzleHttp\Exception\RequestException;

trait TusConfiguration
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation channelsChannelFilesFileHead.
     *
     * Get upload offset. See https://tus.io/ for more detail.
     *
     * @param string $channel The Id of channel (required)
     * @param string $file    The Id of file (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     */
    public function channelsChannelFilesFileHead($channel, $file)
    {
        $this->channelsChannelFilesFileHeadWithHttpInfo($channel, $file);
    }

    /**
     * Operation channelsChannelFilesFileHeadWithHttpInfo.
     *
     * Get upload offset. See https://tus.io/ for more detail.
     *
     * @param string $channel The Id of channel (required)
     * @param string $file    The Id of file (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function channelsChannelFilesFileHeadWithHttpInfo($channel, $file)
    {
        $returnType = '';
        $request = $this->channelsChannelFilesFileHeadRequest($channel, $file);

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

            return [null, $statusCode, $response->getHeaders()];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation channelsChannelFilesFileHeadAsync.
     *
     * Get upload offset. See https://tus.io/ for more detail.
     *
     * @param string $channel The Id of channel (required)
     * @param string $file    The Id of file (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function channelsChannelFilesFileHeadAsync($channel, $file)
    {
        return $this->channelsChannelFilesFileHeadAsyncWithHttpInfo($channel, $file)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation channelsChannelFilesFileHeadAsyncWithHttpInfo.
     *
     * Get upload offset. See https://tus.io/ for more detail.
     *
     * @param string $channel The Id of channel (required)
     * @param string $file    The Id of file (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function channelsChannelFilesFileHeadAsyncWithHttpInfo($channel, $file)
    {
        $returnType = '';
        $request = $this->channelsChannelFilesFileHeadRequest($channel, $file);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'channelsChannelFilesFileHead'.
     *
     * @param string $channel The Id of channel (required)
     * @param string $file    The Id of file (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function channelsChannelFilesFileHeadRequest($channel, $file)
    {
        // verify the required parameter 'channel' is set
        if ($channel === null || (is_array($channel) && count($channel) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $channel when calling channelsChannelFilesFileHead'
            );
        }
        // verify the required parameter 'file' is set
        if ($file === null || (is_array($file) && count($file) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file when calling channelsChannelFilesFileHead'
            );
        }

        $resourcePath = '/channels/{channel}/files/{file}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // path params
        if ($channel !== null) {
            $resourcePath = str_replace(
                '{'.'channel'.'}',
                ObjectSerializer::toPathValue($channel),
                $resourcePath
            );
        }
        // path params
        if ($file !== null) {
            $resourcePath = str_replace(
                '{'.'file'.'}',
                ObjectSerializer::toPathValue($file),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;

            if ($headers['Content-Type'] === 'application/json') {
                // \stdClass has no __toString(), so we should encode it manually
                if ($httpBody instanceof \stdClass) {
                    $httpBody = \GuzzleHttp\json_encode($httpBody);
                }
                // array has no __toString(), so we should encode it manually
                if (is_array($httpBody)) {
                    $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($httpBody));
                }
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
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'HEAD',
            $this->config->getHost().$resourcePath.($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation channelsChannelFilesFilePatch.
     *
     * Upload and apply bytes to a file. See https://tus.io/ for more detail.
     *
     * @param string $channel       The Id of channel (required)
     * @param string $file          The Id of file (required)
     * @param string $tus_resumable version of tus.io (required)
     * @param int    $upload_offset request and response header indicates a byte offset within a resource.      * For uploading entire file in one request, set this to &#39;0&#39; (required)
     * @param string $content_type  Request content type (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     */
    public function channelsChannelFilesFilePatch($channel, $file, $tus_resumable, $upload_offset, $content_type)
    {
        $this->channelsChannelFilesFilePatchWithHttpInfo($channel, $file, $tus_resumable, $upload_offset, $content_type);
    }

    /**
     * Operation channelsChannelFilesFilePatchWithHttpInfo.
     *
     * Upload and apply bytes to a file. See https://tus.io/ for more detail.
     *
     * @param string $channel       The Id of channel (required)
     * @param string $file          The Id of file (required)
     * @param string $tus_resumable version of tus.io (required)
     * @param int    $upload_offset request and response header indicates a byte offset within a resource.      * For uploading entire file in one request, set this to &#39;0&#39; (required)
     * @param string $content_type  Request content type (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function channelsChannelFilesFilePatchWithHttpInfo($channel, $file, $tus_resumable, $upload_offset, $content_type)
    {
        $returnType = '';
        $request = $this->channelsChannelFilesFilePatchRequest($channel, $file, $tus_resumable, $upload_offset, $content_type);

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

            return [null, $statusCode, $response->getHeaders()];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation channelsChannelFilesFilePatchAsync.
     *
     * Upload and apply bytes to a file. See https://tus.io/ for more detail.
     *
     * @param string $channel       The Id of channel (required)
     * @param string $file          The Id of file (required)
     * @param string $tus_resumable version of tus.io (required)
     * @param int    $upload_offset request and response header indicates a byte offset within a resource.      * For uploading entire file in one request, set this to &#39;0&#39; (required)
     * @param string $content_type  Request content type (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function channelsChannelFilesFilePatchAsync($channel, $file, $tus_resumable, $upload_offset, $content_type)
    {
        return $this->channelsChannelFilesFilePatchAsyncWithHttpInfo($channel, $file, $tus_resumable, $upload_offset, $content_type)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation channelsChannelFilesFilePatchAsyncWithHttpInfo.
     *
     * Upload and apply bytes to a file. See https://tus.io/ for more detail.
     *
     * @param string $channel       The Id of channel (required)
     * @param string $file          The Id of file (required)
     * @param string $tus_resumable version of tus.io (required)
     * @param int    $upload_offset request and response header indicates a byte offset within a resource.      * For uploading entire file in one request, set this to &#39;0&#39; (required)
     * @param string $content_type  Request content type (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function channelsChannelFilesFilePatchAsyncWithHttpInfo($channel, $file, $tus_resumable, $upload_offset, $content_type)
    {
        $returnType = '';
        $request = $this->channelsChannelFilesFilePatchRequest($channel, $file, $tus_resumable, $upload_offset, $content_type);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'channelsChannelFilesFilePatch'.
     *
     * @param string $channel       The Id of channel (required)
     * @param string $file          The Id of file (required)
     * @param string $tus_resumable version of tus.io (required)
     * @param int    $upload_offset request and response header indicates a byte offset within a resource.      * For uploading entire file in one request, set this to &#39;0&#39; (required)
     * @param string $content_type  Request content type (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function channelsChannelFilesFilePatchRequest($channel, $file, $tus_resumable, $upload_offset, $content_type)
    {
        // verify the required parameter 'channel' is set
        if ($channel === null || (is_array($channel) && count($channel) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $channel when calling channelsChannelFilesFilePatch'
            );
        }
        // verify the required parameter 'file' is set
        if ($file === null || (is_array($file) && count($file) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file when calling channelsChannelFilesFilePatch'
            );
        }
        // verify the required parameter 'tus_resumable' is set
        if ($tus_resumable === null || (is_array($tus_resumable) && count($tus_resumable) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $tus_resumable when calling channelsChannelFilesFilePatch'
            );
        }
        // verify the required parameter 'upload_offset' is set
        if ($upload_offset === null || (is_array($upload_offset) && count($upload_offset) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $upload_offset when calling channelsChannelFilesFilePatch'
            );
        }
        // verify the required parameter 'content_type' is set
        if ($content_type === null || (is_array($content_type) && count($content_type) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $content_type when calling channelsChannelFilesFilePatch'
            );
        }

        $resourcePath = '/channels/{channel}/files/{file}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // header params
        if ($tus_resumable !== null) {
            $headerParams['tus-resumable'] = ObjectSerializer::toHeaderValue($tus_resumable);
        }
        // header params
        if ($upload_offset !== null) {
            $headerParams['upload-offset'] = ObjectSerializer::toHeaderValue($upload_offset);
        }
        // header params
        if ($content_type !== null) {
            $headerParams['Content-Type'] = ObjectSerializer::toHeaderValue($content_type);
        }

        // path params
        if ($channel !== null) {
            $resourcePath = str_replace(
                '{'.'channel'.'}',
                ObjectSerializer::toPathValue($channel),
                $resourcePath
            );
        }
        // path params
        if ($file !== null) {
            $resourcePath = str_replace(
                '{'.'file'.'}',
                ObjectSerializer::toPathValue($file),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;

            if ($headers['Content-Type'] === 'application/json') {
                // \stdClass has no __toString(), so we should encode it manually
                if ($httpBody instanceof \stdClass) {
                    $httpBody = \GuzzleHttp\json_encode($httpBody);
                }
                // array has no __toString(), so we should encode it manually
                if (is_array($httpBody)) {
                    $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($httpBody));
                }
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
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'PATCH',
            $this->config->getHost().$resourcePath.($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation channelsChannelFilesGet.
     *
     * Return all draft files of channel.
     *
     * @param string $channel The Id of channel (required)
     * @param string $filter  Filter result (optional)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     */
    public function channelsChannelFilesGet($channel, $filter = null)
    {
        $this->channelsChannelFilesGetWithHttpInfo($channel, $filter);
    }

    /**
     * Operation channelsChannelFilesGetWithHttpInfo.
     *
     * Return all draft files of channel.
     *
     * @param string $channel The Id of channel (required)
     * @param string $filter  Filter result (optional)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function channelsChannelFilesGetWithHttpInfo($channel, $filter = null)
    {
        $returnType = '';
        $request = $this->channelsChannelFilesGetRequest($channel, $filter);

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

            return [null, $statusCode, $response->getHeaders()];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation channelsChannelFilesGetAsync.
     *
     * Return all draft files of channel.
     *
     * @param string $channel The Id of channel (required)
     * @param string $filter  Filter result (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function channelsChannelFilesGetAsync($channel, $filter = null)
    {
        return $this->channelsChannelFilesGetAsyncWithHttpInfo($channel, $filter)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation channelsChannelFilesGetAsyncWithHttpInfo.
     *
     * Return all draft files of channel.
     *
     * @param string $channel The Id of channel (required)
     * @param string $filter  Filter result (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function channelsChannelFilesGetAsyncWithHttpInfo($channel, $filter = null)
    {
        $returnType = '';
        $request = $this->channelsChannelFilesGetRequest($channel, $filter);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'channelsChannelFilesGet'.
     *
     * @param string $channel The Id of channel (required)
     * @param string $filter  Filter result (optional)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function channelsChannelFilesGetRequest($channel, $filter = null)
    {
        // verify the required parameter 'channel' is set
        if ($channel === null || (is_array($channel) && count($channel) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $channel when calling channelsChannelFilesGet'
            );
        }

        $resourcePath = '/channels/{channel}/files';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($filter !== null) {
            $queryParams['filter'] = ObjectSerializer::toQueryValue($filter);
        }

        // path params
        if ($channel !== null) {
            $resourcePath = str_replace(
                '{'.'channel'.'}',
                ObjectSerializer::toPathValue($channel),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;

            if ($headers['Content-Type'] === 'application/json') {
                // \stdClass has no __toString(), so we should encode it manually
                if ($httpBody instanceof \stdClass) {
                    $httpBody = \GuzzleHttp\json_encode($httpBody);
                }
                // array has no __toString(), so we should encode it manually
                if (is_array($httpBody)) {
                    $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($httpBody));
                }
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
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'GET',
            $this->config->getHost().$resourcePath.($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation channelsChannelFilesPost.
     *
     * Request a new upload file. See https://tus.io/ for more detail.
     *
     * @param string $channel         The Id of channel (required)
     * @param string $tus_resumable   version of tus.io (required)
     * @param int    $upload_length   To indicate the size of entire upload in bytes (required)
     * @param string $upload_metadata To add additional metadata to the upload creation request.      * MUST contain &#39;filename&#39; and &#39;filetype&#39;. From all available fields only these two fields will be used.      * MUST consist of one or more comma-separated key-value pairs.      * The key and value MUST be separated by a space.      * The key MUST NOT contain spaces and commas and MUST NOT be empty.      * The key SHOULD be ASCII encoded and the value MUST be Base64 encoded. (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     */
    public function channelsChannelFilesPost($channel, $tus_resumable, $upload_length, $upload_metadata)
    {
        $this->channelsChannelFilesPostWithHttpInfo($channel, $tus_resumable, $upload_length, $upload_metadata);
    }

    /**
     * Operation channelsChannelFilesPostWithHttpInfo.
     *
     * Request a new upload file. See https://tus.io/ for more detail.
     *
     * @param string $channel         The Id of channel (required)
     * @param string $tus_resumable   version of tus.io (required)
     * @param int    $upload_length   To indicate the size of entire upload in bytes (required)
     * @param string $upload_metadata To add additional metadata to the upload creation request.      * MUST contain &#39;filename&#39; and &#39;filetype&#39;. From all available fields only these two fields will be used.      * MUST consist of one or more comma-separated key-value pairs.      * The key and value MUST be separated by a space.      * The key MUST NOT contain spaces and commas and MUST NOT be empty.      * The key SHOULD be ASCII encoded and the value MUST be Base64 encoded. (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function channelsChannelFilesPostWithHttpInfo($channel, $tus_resumable, $upload_length, $upload_metadata)
    {
        $returnType = '';
        $request = $this->channelsChannelFilesPostRequest($channel, $tus_resumable, $upload_length, $upload_metadata);

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

            return [null, $statusCode, $response->getHeaders()];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation channelsChannelFilesPostAsync.
     *
     * Request a new upload file. See https://tus.io/ for more detail.
     *
     * @param string $channel         The Id of channel (required)
     * @param string $tus_resumable   version of tus.io (required)
     * @param int    $upload_length   To indicate the size of entire upload in bytes (required)
     * @param string $upload_metadata To add additional metadata to the upload creation request.      * MUST contain &#39;filename&#39; and &#39;filetype&#39;. From all available fields only these two fields will be used.      * MUST consist of one or more comma-separated key-value pairs.      * The key and value MUST be separated by a space.      * The key MUST NOT contain spaces and commas and MUST NOT be empty.      * The key SHOULD be ASCII encoded and the value MUST be Base64 encoded. (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function channelsChannelFilesPostAsync($channel, $tus_resumable, $upload_length, $upload_metadata)
    {
        return $this->channelsChannelFilesPostAsyncWithHttpInfo($channel, $tus_resumable, $upload_length, $upload_metadata)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation channelsChannelFilesPostAsyncWithHttpInfo.
     *
     * Request a new upload file. See https://tus.io/ for more detail.
     *
     * @param string $channel         The Id of channel (required)
     * @param string $tus_resumable   version of tus.io (required)
     * @param int    $upload_length   To indicate the size of entire upload in bytes (required)
     * @param string $upload_metadata To add additional metadata to the upload creation request.      * MUST contain &#39;filename&#39; and &#39;filetype&#39;. From all available fields only these two fields will be used.      * MUST consist of one or more comma-separated key-value pairs.      * The key and value MUST be separated by a space.      * The key MUST NOT contain spaces and commas and MUST NOT be empty.      * The key SHOULD be ASCII encoded and the value MUST be Base64 encoded. (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function channelsChannelFilesPostAsyncWithHttpInfo($channel, $tus_resumable, $upload_length, $upload_metadata)
    {
        $returnType = '';
        $request = $this->channelsChannelFilesPostRequest($channel, $tus_resumable, $upload_length, $upload_metadata);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'channelsChannelFilesPost'.
     *
     * @param string $channel         The Id of channel (required)
     * @param string $tus_resumable   version of tus.io (required)
     * @param int    $upload_length   To indicate the size of entire upload in bytes (required)
     * @param string $upload_metadata To add additional metadata to the upload creation request.      * MUST contain &#39;filename&#39; and &#39;filetype&#39;. From all available fields only these two fields will be used.      * MUST consist of one or more comma-separated key-value pairs.      * The key and value MUST be separated by a space.      * The key MUST NOT contain spaces and commas and MUST NOT be empty.      * The key SHOULD be ASCII encoded and the value MUST be Base64 encoded. (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function channelsChannelFilesPostRequest($channel, $tus_resumable, $upload_length, $upload_metadata)
    {
        // verify the required parameter 'channel' is set
        if ($channel === null || (is_array($channel) && count($channel) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $channel when calling channelsChannelFilesPost'
            );
        }
        // verify the required parameter 'tus_resumable' is set
        if ($tus_resumable === null || (is_array($tus_resumable) && count($tus_resumable) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $tus_resumable when calling channelsChannelFilesPost'
            );
        }
        // verify the required parameter 'upload_length' is set
        if ($upload_length === null || (is_array($upload_length) && count($upload_length) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $upload_length when calling channelsChannelFilesPost'
            );
        }
        // verify the required parameter 'upload_metadata' is set
        if ($upload_metadata === null || (is_array($upload_metadata) && count($upload_metadata) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $upload_metadata when calling channelsChannelFilesPost'
            );
        }

        $resourcePath = '/channels/{channel}/files';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // header params
        if ($tus_resumable !== null) {
            $headerParams['tus-resumable'] = ObjectSerializer::toHeaderValue($tus_resumable);
        }
        // header params
        if ($upload_length !== null) {
            $headerParams['upload-length'] = ObjectSerializer::toHeaderValue($upload_length);
        }
        // header params
        if ($upload_metadata !== null) {
            $headerParams['upload-metadata'] = ObjectSerializer::toHeaderValue($upload_metadata);
        }

        // path params
        if ($channel !== null) {
            $resourcePath = str_replace(
                '{'.'channel'.'}',
                ObjectSerializer::toPathValue($channel),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;

            if ($headers['Content-Type'] === 'application/json') {
                // \stdClass has no __toString(), so we should encode it manually
                if ($httpBody instanceof \stdClass) {
                    $httpBody = \GuzzleHttp\json_encode($httpBody);
                }
                // array has no __toString(), so we should encode it manually
                if (is_array($httpBody)) {
                    $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($httpBody));
                }
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
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'POST',
            $this->config->getHost().$resourcePath.($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation filesFileDelete.
     *
     * Remove the specified file.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     */
    public function filesFileDelete($file)
    {
        $this->filesFileDeleteWithHttpInfo($file);
    }

    /**
     * Operation filesFileDeleteWithHttpInfo.
     *
     * Remove the specified file.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function filesFileDeleteWithHttpInfo($file)
    {
        $returnType = '';
        $request = $this->filesFileDeleteRequest($file);

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

            return [null, $statusCode, $response->getHeaders()];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation filesFileDeleteAsync.
     *
     * Remove the specified file.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function filesFileDeleteAsync($file)
    {
        return $this->filesFileDeleteAsyncWithHttpInfo($file)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation filesFileDeleteAsyncWithHttpInfo.
     *
     * Remove the specified file.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function filesFileDeleteAsyncWithHttpInfo($file)
    {
        $returnType = '';
        $request = $this->filesFileDeleteRequest($file);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'filesFileDelete'.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function filesFileDeleteRequest($file)
    {
        // verify the required parameter 'file' is set
        if ($file === null || (is_array($file) && count($file) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file when calling filesFileDelete'
            );
        }

        $resourcePath = 'files/{file}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // path params
        if ($file !== null) {
            $resourcePath = str_replace(
                '{'.'file'.'}',
                ObjectSerializer::toPathValue($file),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;

            if ($headers['Content-Type'] === 'application/json') {
                // \stdClass has no __toString(), so we should encode it manually
                if ($httpBody instanceof \stdClass) {
                    $httpBody = \GuzzleHttp\json_encode($httpBody);
                }
                // array has no __toString(), so we should encode it manually
                if (is_array($httpBody)) {
                    $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($httpBody));
                }
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
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'DELETE',
            $this->config->getHost().$resourcePath.($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation filesFileGet.
     *
     * Return the specified file.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     */
    public function filesFileGet($file)
    {
        $this->filesFileGetWithHttpInfo($file);
    }

    /**
     * Operation filesFileGetWithHttpInfo.
     *
     * Return the specified file.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     *
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function filesFileGetWithHttpInfo($file)
    {
        $returnType = '';
        $request = $this->filesFileGetRequest($file);

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

            return [null, $statusCode, $response->getHeaders()];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
            }
            throw $e;
        }
    }

    /**
     * Operation filesFileGetAsync.
     *
     * Return the specified file.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function filesFileGetAsync($file)
    {
        return $this->filesFileGetAsyncWithHttpInfo($file)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation filesFileGetAsyncWithHttpInfo.
     *
     * Return the specified file.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function filesFileGetAsyncWithHttpInfo($file)
    {
        $returnType = '';
        $request = $this->filesFileGetRequest($file);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    return [null, $response->getStatusCode(), $response->getHeaders()];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'filesFileGet'.
     *
     * @param string $file The Id of file (required)
     *
     * @throws \InvalidArgumentException
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function filesFileGetRequest($file)
    {
        // verify the required parameter 'file' is set
        if ($file === null || (is_array($file) && count($file) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file when calling filesFileGet'
            );
        }

        $resourcePath = '/files/{file}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // path params
        if ($file !== null) {
            $resourcePath = str_replace(
                '{'.'File'.'}',
                ObjectSerializer::toPathValue($file),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                []
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                [],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;

            if ($headers['Content-Type'] === 'application/json') {
                // \stdClass has no __toString(), so we should encode it manually
                if ($httpBody instanceof \stdClass) {
                    $httpBody = \GuzzleHttp\json_encode($httpBody);
                }
                // array has no __toString(), so we should encode it manually
                if (is_array($httpBody)) {
                    $httpBody = \GuzzleHttp\json_encode(ObjectSerializer::sanitizeForSerialization($httpBody));
                }
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
        $apiKey = $this->config->getApiKeyWithPrefix('Authorization');
        if ($apiKey !== null) {
            $headers['Authorization'] = $apiKey;
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'GET',
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
}
