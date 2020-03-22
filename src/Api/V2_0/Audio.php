<?php

namespace Arvan\Vod\Api\V2_0;

use Arvan\Vod\Config\Routes;

final class Audio extends BaseClass
{
    public function showAll(string $channelId, array $options = null)
    {
        $result = $this->createGetRequest(Routes::GET_AUDIOS, $options, 'channel_id', $channelId);

        return $result;
    }

    public function show(string $audioId, array $options = null)
    {
        $result = $this->createGetRequest(Routes::GET_AUDIO, $options, 'audio_id', $audioId);

        return $result;
    }

    public function create(array $audio, string $channelId)
    {
        $result = $this->createPostRequest(
            Routes::CREATE_AUDIO,
            $audio,
            'channel_id',
            $channelId
        );

        return $result;
    }

    public function update(string $audioId, array $audio)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::UPDATE_AUDIO, 'audio_id', $audioId, $audio);

        return $result;
    }

    public function delete($audioId)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::DELETE_AUDIO, 'audio_id', $audioId, null, 'DELETE');

        return $result;
    }
}
