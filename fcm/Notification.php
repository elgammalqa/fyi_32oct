<?php

class TopicNotification2{

    
    private $key = 'AAAAPgPoiIs:APA91bH2TG_MYTVwal46NzWBYFrfyoUak_4NMQzfcLWLxrdHWEOAIw-RdYlVJtdiCD4hLCv7fpYKmKOPrTaD9CWneTda5Z2vjC6MiKrFvZ6F0aNYLDJC5IVcvm7spbaRyl43OnAkCE6V';

    public function __construct()
    {

    }  

    public function sendTopicNotification2($body, $title, $topic, $news_id, $link, $lang){
        $data            =  ["rank" => 2, "news_id" => $news_id, "link" => $link, "lang" => $lang] ;
        $msg = array
        (
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            'title'  => '',
            'body'     => $body.' | '.$title,
            'vibrate'   => 1,
            'sound'     => 1,
            'notId'     => time().mt_rand(11111,99999),
            "data" =>  $data
        );
        $fields = array
        (
            'to'  => '/topics/'.$topic,
            'notification'          => $msg
        );
        $headers = array
        (
            'Authorization: key=' . $this->key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        //print_r($result);
    }
}