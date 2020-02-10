<?php

require_once 'vendor/autoload.php';

$config = require_once 'config.php';

$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';

$twitter = new TwitterAPIExchange( $config['twitter'] );
$twitter->buildOAuth( $url, $requestMethod );

$youtube = new Madcoda\Youtube\Youtube( [
    'key' => $config['youtube']['key'],
]);

$videoList = $youtube->searchChannelVideos('', $config['youtube']['channel'], 50);

$k = array_rand($videoList);
$video = $videoList[$k];
$apiData = [
    'status' => $video->snippet->title.' https://www.youtube.com/watch?v='.$video->id->videoId,
];
$twitter->setPostFields( $apiData );
$response = $twitter->performRequest( true, [
    CURLOPT_SSL_VERIFYHOST => 0,
    CURLOPT_SSL_VERIFYPEER => 0,
] );

echo $response;