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

```
2. Usage:

```php
SomeController.php

$vodSdk = app('arvan-vod-sdk');

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
 
$music = storage_path('music.mp3);
$channelId = 'xxxx-xxxx-xxxx-xxxx';

$file = $vodSdk->file();
$storageUrl = $file->createStorage($channelId, $music);
$file->upload($storageUrl);
```