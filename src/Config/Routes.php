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
    const GET_FILES = '/channels/channel_id/files';
    const GET_FILE = '/files/file_id';
    const DELETE_FILE = '/files/file_id';

    const GET_VIDEOS = '/channels/channel_id/videos';
    const GET_VIDEO = '/videos/video_id';
    const CREATE_VIDEO = '/channels/channel_id/videos';
    const UPDATE_VIDEO = '/videos/video_id';
    const DELETE_VIDEO = '/videos/video_id';

    const GET_AUDIOS = '/channels/channel_id/audios';
    const GET_AUDIO = '/audios/audio_id';
    const CREATE_AUDIO = '/channels/channel_id/audios';
    const UPDATE_AUDIO = '/audios/audio_id';
    const DELETE_AUDIO = '/audios/audio_id';

    const GET_WATERMARKS = '/channels/channel_id/watermarks';
    const GET_WATERMARK = '/watermarks/watermark_id';
    const CREATE_WATERMARK = '/channels/channel_id/watermarks';
    const UPDATE_WATERMARK = '/watermarks/watermark_id';
    const DELETE_WATERMARK = '/watermarks/watermark_id';
}
