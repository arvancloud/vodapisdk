<?php

namespace Arvan\Vod\Api\V2_0;

final class Channel extends BaseClass
{
    public function showAll(string $filter = null, int $page = 1, int $perPage = 15)
    {
        $result = null;

        $queryParams['filter'] = $filter;
        $queryParams['page'] = $page;
        $queryParams['per_page'] = $perPage;

        try {
            $result = $this->createClientHttpRequest([
                'method' => 'GET',
                'route' => '/channels?'.$this->queryStringBuilder($queryParams),
                ]);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }

        return $result;
    }

    public function show()
    {
    }

    public function create()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    protected function dataBuilder()
    {
    }
}
