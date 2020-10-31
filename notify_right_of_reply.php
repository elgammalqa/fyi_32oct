<?php
ini_set('error_reporting',E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log','notify.log');
date_default_timezone_set('GMT');

require_once 'vendor/autoload.php';
use Twilio\Rest\Client;
$sid    = "AC491fd98cdd0bd224122441dee93691d3";
$token  = "324536d8566d951252848fbdc93998ae";
$twilio = new Client($sid, $token);


try
{   $con= new PDO('mysql:host=localhost;dbname=fyi;charset=utf8', 'thatsfyidb', 'AAAaaa@1234' );
    //$con= new PDO('mysql:host=localhost;dbname=fyi;charset=utf8', 'root', '' );
}
catch (Exception $e){
    die('Error : ' . $e->getMessage());
}

$stmt = $con->prepare("select * from right_of_reply_settings where id = '2'");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$mentor_notify_minutes = $row['mentor_notify'] * 60;
$admin_notify_minutes = $row['admin_notify'] * 60;
$admin_phone = $row['admin_phone'];
//echo $mentor_notify_minutes.' - '.$admin_notify_minutes.'<br>';
$con = null;


$databases = array();
$databases[] = 'fyi';
$databases[] = 'fyi_arabic';
$databases[] = 'fyi_indian';
$databases[] = 'fyi_chinese';
$databases[] = 'fyi_french';
$databases[] = 'fyi_german';
$databases[] = 'fyi_hebrew';
$databases[] = 'fyi_japanese';
$databases[] = 'fyi_russian';
$databases[] = 'fyi_spanish';
$databases[] = 'fyi_turkish';
$databases[] = 'fyi_urdu';

foreach ($databases as $database){
    try
    {   $con= new PDO('mysql:host=localhost;dbname='.$database.';charset=utf8', 'thatsfyidb', 'AAAaaa@1234' );
        //$con= new PDO('mysql:host=localhost;dbname=fyi_arabic;charset=utf8', 'root', '' );
    }
    catch (Exception $e){
        die('Error : ' . $e->getMessage());
    }

    $notify_mentor = array();
    $notify_admin = array();
    $stmt1 = $con->prepare("select id, created_at, status from rss_right_of_reply where status = '2' order by id desc");
    $stmt1->execute();
    while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
        $added_minutes_ago =  ((strtotime(date('Y-m-d H:i')) - strtotime($row['created_at'])) / 60);
        //echo $row['id'].' - '.$added_minutes_ago.'<br>';
        if($added_minutes_ago > $mentor_notify_minutes){
            //echo ' ---- mentor will be notified<br>';
            $notify_mentor[] = $row['id'];
        }
        if($added_minutes_ago > $admin_notify_minutes){
            //echo ' -------- admin will be notified';
            $notify_admin[] = $row['id'];
        }

        //echo '<p>******************************************************************</p>';
    }

    if(count($notify_mentor) > 0){
        $stmt1 = $con->prepare("select Phone from users");
        $stmt1->execute();
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
            $message = $twilio->messages
                ->create($row1['Phone'], // to
                    array(
                        "body" => "New right of reply need attention",
                        "from" => "FYI Press"
                    )
                );
        }
    }
    unset($notify_mentor);

    if(count($notify_admin) > 0){

        $message = $twilio->messages
            ->create($admin_phone, // to
                array(
                    "body" => "Follow up with mentors to review new right of reply",
                    "from" => "FYI Press"
                )
            );
    }
    unset($notify_admin);

    $con = null;
}



