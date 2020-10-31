<?php
 /*
ini_set('error_reporting',E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log','LOG_twitter.log');
ini_set('max_execution_time', 0);
ini_set('memory_limit','512M');
 */
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
    include '../twc.php';

    $twitter_timeline           = "user_timeline";  //  mentions_timeline / user_timeline / home_timeline / retweets_of_me

    //  create request
    $request = array(
        'screen_name'       => $source,
        'count'             => '2'
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

$domain = 'https://www.fyipress.net/turkish/';

require 'fyipanel/views/connect.php';

require '../fcm/TopicNotification.php';
$n = new TopicNotification();

require '../fcm/WebFCMToTopic.php';
$fcm = new WebFCMToTopic();

require_once 'models/utilisateurs.model.php';
require_once 'fyipanel/models/news_published.model.php';
$u = new utilisateursModel();
 

$stmt = $con->prepare("select * from rss_sources where twitter != ''");
 $stmt->execute();
$data = $stmt->fetchAll();
 
$sources = array();

foreach ($data as $x){
    $item = array();
    $item['name'] = $x['twitter'];
    $item['source_name'] = $x['source'];
    $item['country'] = $x['country'];
    $item['id'] = $x['id'];
    $item['status'] = $x['status'];
    $sources[]= $item;
}
 

foreach ($sources as $key =>$val){
    
    if($val['status']==1){
    foreach(returnTweet($val['name']) as $i){
         $title = '';
         if(isset($i['text'])){
        $title = clear_link($i['text']);
         }
        if(trim($title) == ''){ continue; }
        
        $link = '';
        if(isset($i['entities']['urls'][0]['expanded_url'])){
            $link = $i['entities']['urls'][0]['expanded_url'];
        }
        if(stristr($link, 'twitter.com') || trim($link) == ''){ continue; }
        $link=addslashes($link);  
         $has_hashtag = strpos($link, '#') !== false;
        if($has_hashtag){
            $link = substr($link, 0,strpos($link, "#") );
        }  

        $title = str_replace("'", " ", $title);
        $title = str_replace('"', " ", $title);
        $q = $con->prepare("select * from rss where favorite = '$val[id]' and (link = '$link' or title = '$title') ");
        $q->execute();
        if($q->rowCount() < 1){
            $time = date("Y-m-d H:i:s");
            $media = $domain.'fyipanel/views/image_news/news_placeholde.png';
            if(isset($i['entities']['media'])){
                $media = $i['entities']['media'][0]['media_url'];
            }

            $stmt = $con->prepare("insert into rss values (NULL, '$title', '', '$link', '$time', '$media', '$val[id]', '')");
            $stmt->execute();
            $id = $con->lastInsertId();
          
            $n->sendTopicNotification($val['source_name'],$title, 'tu-'.str_replace(' ','__',$val['country']).'-'.str_replace(' ','__',$val['source_name']), $id, $link, 'tu');
            
            
            if (!news_publishedModel::source_not_open($val['source_name'])) { 
                 $has_http = strpos($link,'http://') !== false;
                 if($has_http){
                    $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                 }else{
                   $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                 }  
            } 
            $fcm->sendWebNoification('tu-'.str_replace(' ','__',$val['country']).'-'.str_replace(' ','__',$val['source_name']), $val['source_name'].' | '.$title,
                'FYIPress', $link);

            usleep(250000);
        }

    }
}//s

}

function clear_link($text){
    $string = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $text);
    return $string;
}