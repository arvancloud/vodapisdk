<?php

namespace Arvan\Vod\Api\V2_0;

use Arvan\Vod\Config\Routes;

final class Video extends BaseClass
{
    public function showAll(string $channelId, array $options = null)
    {
        $result = $this->createGetRequest(Routes::GET_VIDEOS, $options, 'channel_id', $channelId);

        return $result;
    }

    public function show(string $videoId)
    {
        $result = $this->createGetRequest(Routes::GET_VIDEO, null, 'video_id', $videoId);

        return $result;
    }

    public function create(array $video, string $channelId)
    {
        $result = $this->createPostRequest(
            Routes::CREATE_VIDEO,
            $video,
            'channel_id',
            $channelId,
        );

        return $result;
    }

    public function update(string $videoId, array $video)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::UPDATE_VIDEO, 'video_id', $videoId, $video);

        return $result;
    }

    public function delete($videoId)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::DELETE_VIDEO, 'video_id', $videoId, null, 'DELETE');

        return $result;
    }
}
