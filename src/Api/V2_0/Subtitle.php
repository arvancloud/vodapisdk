<?php

namespace Arvan\Vod\Api\V2_0;

use Arvan\Vod\Config\Routes;

final class Subtitle extends BaseClass
{
    public function showAll(string $channelId, array $options = null)
    {
        $result = $this->createGetRequest(
        Routes::GET_SUBTITLES,
            $options,
            'channel_id',
            $channelId);

        return $result;
    }

    public function show(string $subtitleId)
    {
        $result = $this->createGetRequest(Routes::GET_SUBTITLE, null, 'subtitle_id', $subtitleId);

        return $result;
    }

    public function create(array $subtitle, string $channelId)
    {
        $result = $this->createPostRequest(
            Routes::CREATE_SUBTITLE,
            $subtitle,
            'channel_id',
            $channelId,
            true,
            'subtitle'
        );

        return $result;
    }

    public function update(string $subtitleId, array $subtitle)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::UPDATE_SUBTITLE, 'subtitle_id', $subtitleId, $subtitle);

        return $result;
    }

    public function delete($subtitleId)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::DELETE_SUBTITLE, 'subtitle_id', $subtitleId, null, 'DELETE');

        return $result;
    }
}
