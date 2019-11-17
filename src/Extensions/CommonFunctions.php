<?php

namespace Arvan\Vod\Extensions;

trait CommonFunctions
{
    public function getBodyContents($body)
    {
        return json_decode($body);
    }
}
