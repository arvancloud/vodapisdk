<?php

namespace Arvan\Vod\Api\V2_0;

use Arvan\Vod\Config\Routes;

final class Watermark extends BaseClass
{
    public function showAll(string $channelId, array $options = null)
    {
        $result = $this->createGetRequest(
        Routes::GET_WATERMARKS,
            $options,
            'channel_id',
            $channelId);

        return $result;
    }

    public function show(string $watermarkId)
    {
        $result = $this->createGetRequest(Routes::GET_WATERMARK, null, 'watermark_id', $watermarkId);

        return $result;
    }

    public function create(array $watermark, string $channelId)
    {
        $result = $this->createPostRequest(
            Routes::CREATE_WATERMARK,
            $watermark,
            'channel_id',
            $channelId,
            true,
            'watermark'
        );

        return $result;
    }

    public function update(string $watermarkId, array $watermark)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::UPDATE_WATERMARK, 'watermark_id', $watermarkId, $watermark);

        return $result;
    }

    public function delete($watermarkId)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::DELETE_WATERMARK, 'watermark_id', $watermarkId, null, 'DELETE');

        return $result;
    }
}
