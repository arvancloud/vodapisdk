# VOD SDK is a client package to connect to Arvan VOD API to make your life much easier :)

### This package has written in pure php which can be implemented in any PHP framework.

#### For more details please kindly take a look at the [API Doc](https://napi.arvancloud.com/docs/vod/2.0#/)
1. The Package has too registered
```php
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind('arvan-vod-sdk', function ($app) {
            return VodSdk::setToken('Apikey xxxxxxxxxxxx');
        });
    }
}

// SomeController.php

$vodSdk = app('arvan-vod-sdk');

```
2. UserDomain:

```php
**
* UserDomain:
* There are only two end points for userDomains (create and show).
* please be informed that, create action is only available for just one time and if a user wants to change
* their userDomain, they need to cantact to Arvan support.
*/
 
// POST
$userDomain = $vodkSdk->userDomain();

$createdDomain = $userDomain->createDomain(['subdomain' => 'whatever']);

// GET
$getUserDomain = $userDomain->getDomain(); 
```
3. Channel:

```php
**
* in order to create a channel create method is available which accepts and array as the sample in below
*/
 
// Post

$channel = $vodSdk->channel();
$newChannel = $channel-> create([
    'title' => 'string',
    'description' => 'string',
    'secure_link_enabled' => false,
    'secure_link_key' => 'string',
    'secure_link_with_ip' => true,
    'ads_enabled' => false,
    'present_type' => 'auto',
    'campaign_id' => 'string'
]);

// GET (all channels)
$allChannels = $channel->showAll();

// GET (get specific channhel by id)
$channelDetails = $channel->show('********-****-****-****-********')

// PATCH (update a channel)
$updatedChannel = $channel->update('5c6b18de-9763-423f-8d3e-f2e84e93c9d5', [
    'title' => 'whatever from sdk'
    ]);
    
// DELETE (delete a channel) 
$channel->update('********-****-****-****-********');
```
4. File:

```php
// GET (get the whole channel files)
$channelId = 'xxxx-xxxx-xxxx-xxxx';
$file = $vodSdk->file();
$allChannelFiles = $file->showAll($channelId) // channel ID must be set as a string

$music = storage_path('music.mp3');
$storageUrl = $file->createStorage($channelId, $music);

**
* response will be file id and URL, URL can be used to get file offset
* in order to findout whether the file is completely uploaded or not.
*/
$uploadedFile = $file->upload($storageUrl);

// HEAD (Uploaded file url is required)
$fileOffset = $file->getOffset('https://napi.arvancloud.com/**************');

// DELETE (by file ID)
$file->delete('********-****-****-****-********');
```
5. Video / Audio:

```php
$channelId = 'xxxx-xxxx-xxxx-xxxx';
$fileId = 'xxxx-xxxx-xxxx-xxxx';
$video = $file->video();

// GET (get the whole channel videos)
$allChannelVideos = $video->showAll($channelId);

// GET (get specific video by ID)
$getVideo = $video->showAll('********-****-****-****-********');  //VideoId

// POST (convert an uploaded file / upload with an address (URL)
$newVideo = $video->create([
    'title' => 'string',
    'description' => 'string',
    'video_url' => 'string', // should be null or removed if file_id is exist 
    'file_id' => 'string',
    'convert_mode' => 'auto/manual/profile',
    'profile_id' => 'string',
    'parallel_convert' => false,
    'thumbnail_time' => 0,
    'watermark_id' => 'string',
    'watermark_area' => 'CENTER', // required if watermark_id is set
    'convert_info' => [         // required if convert_mode is manual
        [
            'audio_bitrate' => 0,
            'video_bitrate' => 0,
            'resolution' => 'string'
        ],
        [
            'audio_bitrate' => 0,
            'video_bitrate' => 0,
            'resolution' => 'string'
        ],
        [
            'audio_bitrate' => 0,
            'video_bitrate' => 0,
            'resolution' => 'string'
        ]
    ]
], channelId);

// PATCH (update video or audio. Only title and description are editable)
$updatedVideo = $video->update('video_id', [
    'title' => 'whatever',
    'description' => 'something...'
]);

// DELETE (by video / audio ID)
$video->delete('********-****-****-****-********');
```
6. Watermark:

```php
// GET (get all channel watermarks)
$channelId = 'xxxx-xxxx-xxxx-xxxx';
$watermark = $vodSdk->watermark();
$allChannelWarermark = $watermark->showAll($channelId) // channel ID must be set as a string

// GET (get specific watermkark)
$getWatermark = $watermark->showAll('********-****-****-****-********');  //WatermarkId

// Post
$newWatermark = $watermark->create([
            'title' => 'test',
            'description' => 'dasdas',
            'watermark' => storage_path('1.jpg')

        ], 'channel_id');
        
// PATCH
$updatedWatermark = $watermark->update([
    'title' => 'new Name',
    'description' => 'updated description'
]);

// DELETE (by watermark ID)
$watermark->delete('********-****-****-****-********');  //WatermarkId
```
7. Subtitle:

```php

$subtitle = $vodSdk->subtitle();

// GET (get all video subtitles)
$videoSubtitles = $subtitle->showAll('********-****-****-****-********');  //VideoId

// GET (get specific subtitle)
$subtitle = $subtitle->show('********-****-****-****-********');  //SubtitleId

// POST (create a subtitle)
$newSubtitle = $subtitle->create([
            'lang' => 'en',
            'subtitle' => storage_path('test.vtt')
        ], '********-****-****-****-********');  //VideoId
        
// DELETE
$subtitle->delete('********-****-****-****-********');  //SubtitleId
```
8. Porfile:

```php
$profile = $vodSdk->profile();

//GET (get all channel profiles)
$allChannelprofiles = $profile->showAll('********-****-****-****-********');  //ChannelID

//GET (get specific profile)
$profile = $profile->show('********-****-****-****-********');  //ProfileID

//POST
$newProfile = $profile->create([
        'title' => 'string',
        'description' => 'string',
        'convert_mode' => 'auto',
        'thumbnail_time' => 0,
        'watermark_id' => 'string',
        'watermark_area' => 'CENTER',
        'convert_info' => [
            [
                'audio_bitrate' => 0,
                'video_bitrate' => 0,
                'resolution' => 'string'
            ]
        ]
    ], '********-****-****-****-********');  //ChannelID
    
//PATCH

$newProfile = $profile->update('8a953ada-30b6-4279-b1ba-217ca108c06a', [
        'title' => 'updated title',
        'description' => 'updated description',
        'convert_mode' => 'manual',
        'thumbnail_time' => 1,
        'convert_info' => [
            [
                'audio_bitrate' => ***,
                'video_bitrate' => ***,
                'resolution' => '****x***'
            ]
        ]
    ]);

// DELETE
$profile->delete('********-****-****-****-********');  //ProfileId

```
