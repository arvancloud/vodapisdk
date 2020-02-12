<?php

namespace Arvan\Vod\Api\V2_0;

use Arvan\Vod\Config\Routes;

final class Profile extends BaseClass
{
    public function showAll(string $channelId, array $options = null)
    {
        $result = $this->createGetRequest(
            Routes::GET_PROFILES,
            $options,
            'channel_id',
            $channelId
        );

        return $result;
    }

    public function show(string $profileId)
    {
        $result = $this->createGetRequest(Routes::GET_PROFILE, null, 'profile_id', $profileId);

        return $result;
    }

    public function create(array $profile, string $channelId)
    {
        $result = $this->createPostRequest(
            Routes::CREATE_PROFILE,
            $profile,
            'channel_id',
            $channelId,
        );

        return $result;
    }

    public function update(string $profileId, array $profile)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::UPDATE_PROFILE, 'profile_id', $profileId, $profile);

        return $result;
    }

    public function delete($profileId)
    {
        $result = $this->createPatchOrDeleteRequest(Routes::DELETE_PROFILE, 'profile_id', $profileId, null, 'DELETE');

        return $result;
    }
}
