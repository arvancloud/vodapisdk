<?php

namespace Arvan\Vod\Api\V2_0;

use Arvan\Vod\Config\Routes;

final class UserDomain extends BaseClass
{
    public function createDomain(array $subdomain)
    {
        $result = $this->createPostRequest(Routes::CREATE_USER_DOMAIN, $subdomain);

        return $result;
    }

    public function getDomain(array $options)
    {
        $result = $this->createGetRequest(Routes::GET_USER_DOMAIN, $options);

        return $result;
    }
}
