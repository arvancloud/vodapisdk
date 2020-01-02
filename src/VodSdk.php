<?php

namespace Arvan\Vod;

use Arvan\Vod\Api\V2_0\Channel;
use Arvan\Vod\Api\V2_0\UserDomain;

final class VodSdk
{
    public static $config;

    public static $channelApi;
    public static $userDomainApi;

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

    public static function userDomain()
    {
        if (empty(static::$userDomainApi)) {
            static::$userDomainApi = new UserDomain();
        }

        return static::$userDomainApi;
    }

    private static function configuration()
    {
        if (empty(static::$config)) {
            static::$config = new Configuration();
        }

        return static::$config;
    }
}
