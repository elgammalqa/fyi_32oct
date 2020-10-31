<?php

date_default_timezone_set('GMT');

function buildBaseString($baseURI, $method, $params) {
    $r = array();
    ksort($params);
    foreach($params as $key=>$value){
        $r[] = "$key=" . rawurlencode($value);
    }
    return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function buildAuthorizationHeader($oauth) {
    $r = 'Authorization: OAuth ';
    $values = array();
    foreach($oauth as $key=>$value)
        $values[] = "$key=\"" . rawurlencode($value) . "\"";
    $r .= implode(', ', $values);
    return $r;
}

function returnTweet($source){
    $oauth_access_token         = "15700164-fpX77cMzogSmXqQ8hDFY6os9i9uHw4aNR4xVxx0jC";
    $oauth_access_token_secret  = "B0eQZNVbglWpEuFDFipSDxFbzrwHFzVQQujmVSlZDFAhZ";
    $consumer_key               = "NT2ybFd5ayf5Dkzroo5YunpWq";
    $consumer_secret            = "AOvSRkuOH6IGIM9Gs4ueU47DwRaa8GTMDulam5aEzA2nfgoa3i";

    $twitter_timeline           = "user_timeline";  //  mentions_timeline / user_timeline / home_timeline / retweets_of_me

    //  create request
    $request = array(
        'screen_name'       => $source,
        'count'             => '10'
    );

    $oauth = array(
        'oauth_consumer_key'        => $consumer_key,
        'oauth_nonce'               => time(),
        'oauth_signature_method'    => 'HMAC-SHA1',
        'oauth_token'               => $oauth_access_token,
        'oauth_timestamp'           => time(),
        'oauth_version'             => '1.0'
    );

    //  merge request and oauth to one array
    $oauth = array_merge($oauth, $request);

    //  do some magic
    $base_info              = buildBaseString("https://api.twitter.com/1.1/statuses/$twitter_timeline.json", 'GET', $oauth);
    $composite_key          = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
    $oauth_signature            = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
    $oauth['oauth_signature']   = $oauth_signature;

    //  make request
    $header = array(buildAuthorizationHeader($oauth), 'Expect:');
    $options = array( CURLOPT_HTTPHEADER => $header,
        CURLOPT_HEADER => false,
        CURLOPT_URL => "https://api.twitter.com/1.1/statuses/$twitter_timeline.json?". http_build_query($request),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false);

    $feed = curl_init();
    curl_setopt_array($feed, $options);
    $json = curl_exec($feed);
    curl_close($feed);

    return json_decode($json, true);
}

require 'fyipanel/views/connect.php';

$sources = array();

$item = array();
$item['name'] = 'AlMasryAlYoum';
//$item['id'] = 37;
$item['id'] = 49;
$sources[]= $item;

$item = array();
$item['name'] = 'Alwatan_Live';
//$item['id'] = 36;
$item['id'] = 59;
$sources[]= $item;

$item = array();
$item['name'] = 'masrawy';
//$item['id'] = 35;
$item['id'] = 70;
$sources[]= $item;

$item = array();
$item['name'] = 'youm7';
$item['id'] = 65;
//$item['id'] = 34;
$sources[]= $item;

$item = array();
$item['name'] = 'Vetogate';
//$item['id'] = 33;
$item['id'] = 67;
$sources[]= $item;

$item = array();
$item['name'] = 'ElBaladOfficial';
//$item['id'] = 32;
$item['id'] = 62;
$sources[]= $item;

$item = array();
$item['name'] = 'akhbarelyom';
//$item['id'] = 31;
$item['id'] = 68;
$sources[]= $item;

foreach ($sources as $key =>$val){
    foreach(returnTweet($val['name']) as $i){
        $title = clear_link($i['text']);
        $link = '';
        if(isset($i['entities']['urls'][0]['expanded_url'])){
            $link = $i['entities']['urls'][0]['expanded_url'];
        }
        if(stristr($link, 'twitter.com') || trim($link) == ''){ continue; }
        if(strstr($title, 'عاجل')){
            $q = $con->prepare("select * from rss where title = '$title' and favorite = '$val[id]'");
            $q->execute();
            if($q->rowCount() < 1){
                $time = date("Y-m-d H:i:s");

                $media = '';
                if(isset($i['entities']['media'])){
                    $media = $i['entities']['media'][0]['media_url'];
                }

                $stmt = $con->prepare("insert into rss values (NULL, '$title', '', '$link', '$time', '$media', '$val[id]', '')");
                $stmt->execute();
                //usleep(500000);
            }
        }

    }

}

function clear_link($text){
    $string = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $text);
    return $string;
}