<?php

class TopicNotification{

    
    private $key = 'AAAAQpiCYzM:APA91bE2ElLvtddXCHOJcjFFbgnbVVZaUTlOM9pxrRCNUn-ESu7L1HHG5a0MX2fSh14fnVS22osoQYDsoCIlZOfvW-wC9cHN8Om2XBLP_cRuFufd8SkTWAT6Zw9OqyzDZOcS0sYNGBNm';

    public function __construct()
    {

    }

    public function sendTopicNotification($body, $title, $topic, $news_id, $link, $lang){

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

/*define( 'API_ACCESS_KEY', 'AAAArE4GgNo:APA91bEqObcF3f7RozTfX98kF0nPIOZYHmak6ZIm2BDMqeWUg
-hcKmFN5qqF56RHL3xQHCslGiykUNtvJbJ0ZiANO1eOAsVjUCNb2X_Q0WdjvskHfpCIRI0e_P4i5aITPyS5NkfpmYmt' );

$msg = array
(
    'body'  => "abc",
    'title'     => "Hello from Api",
    'vibrate'   => 1,
    'sound'     => 1,
);

$fields = array
(
    'to'  => '/topics/Egypt-Youm7',
    'notification'          => $msg
);

$headers = array
(
    'Authorization: key=' . API_ACCESS_KEY,
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
echo $result;*/
?>
