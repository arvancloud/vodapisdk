# VOD SDK is a client package to connect to Arvan VOD API as fast as you can :)

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
$music = storage_path('music.mp3);
$channelId = 'xxxx-xxxx-xxxx-xxxx';

$file = $vodSdk->file();
$storageUrl = $file->createStorage($channelId, $music);
$file->upload($storageUrl);
```