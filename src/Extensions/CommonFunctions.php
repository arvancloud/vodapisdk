<?php

namespace Arvan\Vod\Extensions;

trait CommonFunctions
{
    public function getBodyContents($body)
    {
        return json_decode($body);
    }

    public function urlBuilder(string $url, string $key = null, string $value = null)
    {
        if (isset($key) and isset($value)) {
            $result = str_replace("{$key}", $value, $url);

            return $result;
        }

        return $url;
    }
}
