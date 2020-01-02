<?php

namespace Arvan\Vod\Extensions;

trait CommonFunctions
{
    public function getBodyContents($body)
    {
        return json_decode($body);
    }

    public function urlBuilder($url, $key, $value)
    {
        $result = str_replace("{$key}", $value, $url);

        return $result;
    }
}
