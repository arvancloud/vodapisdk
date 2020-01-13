<?php

use Arvan\Vod\VodSdk;

$config = ConfigBuilder::withToken('YOUR_API_KEY')->build();
$c = new HttpClient($config);
$channel = new Channel($c);
$channel->showAll();

// $sdk = new VODSdk($channel, $audio);
// VodSdk::channel()->showAll();
