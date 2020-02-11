<?php

namespace Arvan\Vod\Api\V2_0;

use Arvan\Vod\ApiException;
use Arvan\Vod\Config\Routes;
use Arvan\Vod\Extensions\CommonFunctions;
use Arvan\Vod\ObjectSerializer;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;

final class File extends BaseClass
{
    use CommonFunctions;

    const TUS_VERSION = '1.0.0';

    protected $fileInfo = [];

    public function showAll(string $channel_id, array $options = null)
    {
        $result = $this->createGetRequest(Routes::GET_FILES, $options, 'channel_id', $channel_id);

        return $result;
    }

    public function show(string $fileId)
    {
        $result = $this->createGetRequest(Routes::GET_FILE, null, 'file_id', $fileId);

        return $result;
    }

    public function getOffset($url)
    {
        $request = $this->getOffsetFromServer($url);

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

            $response = $response->getHeaders();

            return [
                'Upload-Length' => $response['Upload-Length'][0],
                'Upload-Offset' => $response['Upload-Offset'][0],
            ];
        } catch (ApiException $e) {
            throw $e->getCode();
        }
    }

    protected function getOffsetFromServer($url)
    {
        $resourcePath = $url;
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // body params
        $_tempBody = null;

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
            $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    public function upload($url, $offset = 0)
    {
        $returnType = '';
        $request = $this->transferFileToServer($url, $offset);

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

            return ['body' => $url, 'status' => $statusCode];
        } catch (ApiException $e) {
            throw $e->getCode();
        }
    }

    protected function transferFileToServer(array $url, int $offset)
    {
        $tus_resumable = self::TUS_VERSION;
        $content_type = 'application/offset+octet-stream';

        if ($url === null || !isset($url)) {
            throw new \InvalidArgumentException(
                'Invalid URL'
            );
        }

        $resourcePath = $url['url'];
        $formParams = $this->fileInfo;
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        if ($tus_resumable !== null) {
            $headerParams['tus-resumable'] = ObjectSerializer::toHeaderValue($tus_resumable);
        }

        $headerParams['Content-Type'] = ObjectSerializer::toHeaderValue($content_type);

        $offset = $offset !== 0 ?? $offset = 0;
        $headerParams['upload-offset'] = ObjectSerializer::toHeaderValue($offset);

        $_tempBody = null;

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

            if ($headers['Content-Type'] === 'application/json' || $headers['Content-Type'] === $content_type) {
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
        } else {
            throw new \InvalidArgumentException(
                'File is empty'
            );
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

        $httpBody = fopen($this->fileInfo['realpath'], 'rb');

        $query = \GuzzleHttp\Psr7\build_query($queryParams);

        return new Request(
            'PATCH',
            $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    public function createStorage($channelId, $file)
    {
        $fileInfo = $this->fileInfoGenerator($file);

        $returnType = '';
        $request = $this->storageBuilder($channelId, $fileInfo);

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

            $storageUrl = $response->getHeaders();
            $responseHeaderLocation = $storageUrl['Location'][0];

            $fileId = explode('/', $responseHeaderLocation);

            return [
                'file_id' => end($fileId),
                'url' => $responseHeaderLocation,
            ];
        } catch (ApiException $e) {
            throw $e->getCode();
        }
    }

    protected function storageBuilder(string $channelId, array $file)
    {
        $tus_resumable = self::TUS_VERSION;

        if (!isset($file) || !is_array($file)) {
            throw new \InvalidArgumentException(
                '$file must be an array'
            );
        }

        if (!isset($file['size']) && $file['size'] <= 0) {
            throw new \InvalidArgumentException(
                'File size is invalid'
            );
        }

        $upload_length = $file['size'];

        $upload_metadata = $this->getBase64FileAndType($file);

        $resourcePath = $this->urlBuilder(Routes::UPLOAD_FILE, 'channel_id', $channelId);
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

        // body params
        $_tempBody = null;

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
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    public function delete($fileId)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::DELETE_FILE, 'file_id', $fileId, null, 'DELETE');

        return $result;
    }

    private function getBase64FileAndType($file): string
    {
        $fileNameInBase64 = base64_encode($file['basename']);
        $fileTypeInBase64 = base64_encode($file['mime']);

        $result = "filename {$fileNameInBase64},filetype {$fileTypeInBase64}";

        return $result;
    }

    private function fileInfoGenerator($file): array
    {
        $pathinfo = pathinfo($file);
        $stat = stat($file);
        $this->fileInfo['realpath'] = realpath($file);
        $this->fileInfo['dirname'] = $pathinfo['dirname'];
        $this->fileInfo['basename'] = $pathinfo['basename'];
        $this->fileInfo['filename'] = $pathinfo['filename'];
        $this->fileInfo['extension'] = $pathinfo['extension'];
        $this->fileInfo['mime'] = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file);
        $this->fileInfo['encoding'] = finfo_file(finfo_open(FILEINFO_MIME_ENCODING), $file);
        $this->fileInfo['size'] = $stat[7];

        return $this->fileInfo;
    }
}
