<?php

namespace Arvan\Vod;

use Arvan\Vod\Api\V2_0\Channel;

final class VodSdk
{
    public static $config;
    public static $channelApi;

    public static function setToken($apiKey)
    {
        static::configuration();
        static::$config->setApiKey($apiKey);

        return new static();
    }

    public static function channel()
    {
        if (empty(static::$channelApi)) {
            static::$channelApi = new Channel();
        }

        return static::$channelApi;
    }

    private static function configuration()
    {
        if (empty(static::$config)) {
            static::$config = new Configuration();
        }

        return static::$config;
    }
}
