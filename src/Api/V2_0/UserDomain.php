<?php

namespace Arvan\Vod\Api\V2_0;

final class UserDomain extends BaseClass
{
    public function createDomain(array $subdomain)
    {
        $result = null;

        try {
            $result = $this->createClientHttpRequest([
                'method' => 'POST',
                 'route' => '/domains',
                 '_tempBody' => $subdomain,
                 ]);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }

        return $result;
    }

    public function getDomain(array $subdomain)
    {
    }

    protected function dataBuilder()
    {
    }
}
