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

$music = storage_path('music.mp3);
$channelId = 'xxxx-xxxx-xxxx-xxxx';

$file = $vodSdk->file();
$storageUrl = $file->createStorage($channelId, $music);
$file->upload($storageUrl);
```