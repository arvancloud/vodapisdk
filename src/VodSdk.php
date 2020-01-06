<?php

namespace Arvan\Vod;

use Arvan\Vod\Api\V2_0\File;
use Arvan\Vod\Api\V2_0\Audio;
use Arvan\Vod\Api\V2_0\Video;
use Arvan\Vod\Api\V2_0\Channel;
use Arvan\Vod\Api\V2_0\UserDomain;

final class VodSdk
{
    public static $config;

    public static $channelApi;
    public static $audioApi;
    public static $videoApi;
    public static $fileApi;
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

    public static function audio()
    {
        if (empty(static::$audioApi)) {
            static::$audioApi = new Audio();
        }

        return static::$audioApi;
    }

    public static function video()
    {
        if (empty(static::$videoApi)) {
            static::$videoApi = new Video();
        }

        return static::$videoApi;
    }

    public static function file()
    {
        if (empty(static::$fileApi)) {
            static::$fileApi = new File();
        }

        return static::$fileApi;
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
