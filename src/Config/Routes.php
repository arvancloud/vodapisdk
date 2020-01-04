<?php

namespace Arvan\Vod\Config;

class Routes
{
    const CREATE_USER_DOMAIN = '/domains';
    const GET_USER_DOMAIN = '/domains';

    const GET_CHANNELS = '/channels';
    const GET_CHANNEL = '/channels/channel_id';
    const CREATE_CHANNEL = '/channels';
    const UPDATE_CHANNEL = '/channels/channel_id';
    const DELETE_CHANNEL = '/channels/channel_id';

    const UPLOAD_FILE = '/channels/channel_id/files';
}
