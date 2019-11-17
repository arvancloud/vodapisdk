<?php

namespace Arvan\Vod;

final class Configuration
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $host = 'https://napi.arvancloud.com/vod/2.0';

    /**
     * set apiKey.
     *
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * get host.
     *
     * @return string host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * get apiKey.
     *
     * @return string apiKey
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
}
