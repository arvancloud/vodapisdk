<?php

namespace Arvan\Vod\Api\V2_0;

use Arvan\Vod\Config\Routes;

final class File extends BaseClass
{
    protected $client;

    public function __construct($channelId)
    {
        $baseUrl = $this->urlBuilder(Routes::UPLOAD_FILE, 'channel_id', $channelId);

        $this->client = new \TusPhp\Tus\Client($baseUrl);
    }

    public function tus($file, $perChunkSize)
    {
        $client = new \TusPhp\Tus\Client('http://tus-php-server');
        // Alert: Sanitize all inputs properly in production code
        if (!empty($file)) {
            $fileMeta = $file['tus_file'];
            $uploadKey = hash_file('md5', $fileMeta['tmp_name']);
            try {
                $client->setKey($uploadKey)->file($fileMeta['tmp_name'], 'chunk_a');
                // Upload 50MB starting from 10MB
                $bytesUploaded = $client->seek(10000000)->upload(50000000);
                $partialKey1 = $client->getKey();
                $checksum = $client->getChecksum();
                // Upload first 10MB
                $bytesUploaded = $client->setFileName('chunk_b')->seek(0)->upload(10000000);
                $partialKey2 = $client->getKey();
                // Upload remaining bytes starting from 60,000,000 bytes (60MB => 50000000 + 10000000)
                $bytesUploaded = $client->setFileName('chunk_c')->seek(60000000)->upload();
                $partialKey3 = $client->getKey();
                $client->setFileName($fileMeta['name'])->concat($uploadKey, $partialKey2, $partialKey1, $partialKey3);
                header('Location: '.$_SERVER['HTTP_REFERER'].'?state=uploaded');
            } catch (ConnectionException | FileException | TusException $e) {
                header('Location: '.$_SERVER['HTTP_REFERER'].'?state=failed');
            }
        }
    }
}
