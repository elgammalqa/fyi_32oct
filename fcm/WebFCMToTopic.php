<?php

class WebFCMToTopic{

    
    private $key = 'AAAA3iimkek:APA91bHSL6kf4QrAqilpu9osFr-kXrKRsiNN1b6Lsz0uCTe4wq5vwhv5af-i4dXtlq9dlF67w2mUuesYKR3LZIbWQ3yq9nS_cFEMrlSvwLwX0yzmqqaQOkFGmCQmBer5WtuLHjeOqnpn';

    public function __construct()
    {

    }

    public function sendTopicNotification($body, $title, $topic, $link){

        $data = array(
            'to'  => '/topics/'.$topic,
            "notification" => array(
                "title" => $title,
                "body" => $body,
                "click_action" => $link
            )
        );
        $data_string = json_encode($data);

        //echo "The Json Data : ".$data_string;

        $headers = array
        (
            'Authorization: key=' . $this->key,
            'Content-Type: application/json'
        );

        $ch = curl_init(); curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);
        $result = curl_exec($ch);
        curl_close ($ch);
    }

    public function subscribe($token, $topic){

        $url = 'https://iid.googleapis.com/iid/v1/' . $token . '/rel/topics/' . $topic;

        $headers = array
        (
            'Authorization: key=' . $this->key
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        $result = curl_exec ( $ch );
        //echo $result;
        curl_close ( $ch );
    }

    public function unsubscribe($token, $topic) {
        $url = 'https://iid.googleapis.com/iid/v1/' . $token . '/rel/topics/' . $topic;

        $headers = array
        (
            'Authorization: key=' . $this->key
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

        $result = curl_exec ( $ch );
        echo $result;
        curl_close ( $ch );
    }

    public function sendWebNoification($topic, $title, $body, $url){
        $data = array(
            'to'  => '/topics/'.$topic,
            "notification" => array(
                "title" => $title,
                "body" => $body,
                "click_action" => $url,
                "icon" => '../logo1.png'
            )
        );
        $data_string = json_encode($data);
        //echo "The Json Data : ".$data_string;
        $headers = array
        (
            'Authorization: key=' . $this->key,
            'Content-Type: application/json'
        );

        $ch = curl_init(); curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);
        $result = curl_exec($ch);
        curl_close ($ch);
    }
}
?>