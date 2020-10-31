<?php
include 'fyipanel/views/connect.php';
/*
Template Name: Page: webservice
*/
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( ! function_exists('print_json_encode')){
    function print_json_encode($data){
            $datar = str_replace('\\/', '/', json_encode($data));
            $data = str_replace('null', '""', $datar);
            print($data);
    } 
}   
 
 if (isset($_REQUEST['action']) && $_REQUEST['action']=="iPhone_Notify") 
 {
 $messages = "Welcome to FYI Press."; 	 
 $app_id  = $_REQUEST['app_id'];  
 $devicetoken = $_REQUEST['device_id'];  

 if($devicetoken!='')
 {
	  $dates = date('Y-m-d'); 
	 // $wpdb->query('DELETE  FROM wl_device_registration WHERE device_id = "'.$devicetoken.'"'); 
	 
	 $qry = $con->prepare( "SELECT id FROM wl_device_registration WHERE app_id = '" . $app_id . "' && device_id = '".$devicetoken."' ");
	 
	 $qry->execute();
     $return =  $qry->fetchColumn();
	
     if( empty( $return ) ){ 
	
	  $success =$con->exec("insert into wl_device_registration set app_id='".$app_id."',device_id='".$devicetoken."',login_type='ios',receive_date='".$dates."' ");
		 
			ini_set('display_errors',1);ini_set('php_openssl',1);
			error_reporting(E_ALL);
			$passphrase = ''; 
			$token = $devicetoken;
			$tCert = "Certificates.pem"; 
			$apnsHost = 'gateway.sandbox.push.apple.com';
			$apnsCert = $tCert;
			$apnsPort = 2195;
			$streamContext = stream_context_create();
			if(!function_exists('stream_socket_client')){
			 echo "not there";
			 exit;
			}
			 //print_r($streamContext); 
			 
			 stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
			$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext); 
			$payload['aps'] = array('alert' =>  array('title' => "Notification from fyipress.net",'body' => $messages), 'badge' => 1, 'sound' => 'default');
			$output = json_encode($payload);
		
			$token = pack('H*', str_replace(' ', '', $token));
			$apnsMessage = chr(0) . chr(0) . chr(32) . $token . chr(0) . chr(strlen($output)) . $output;
			$result = fwrite($apns, $apnsMessage);
			@socket_close($apns); 
			
			// var_dump($result);
			//  exit;
			if (@$result)
			{
				//echo 'MESSAGE SENT TO ASPN';
				//return 'Message not delivered' . PHP_EOL;
			}
			else
			{
				//echo 'MESSAGE NOT SENT TO ASPN';
				//return 'Message successfully delivered' . PHP_EOL;
			} 
			@fclose(@$apns);	 
			  
			$queryresult['success'] = 'true';  
			$queryresult['message'] = "Device has been registered sucessfully.";
			echo print_json_encode($queryresult); 
	}
		 
   }else{
			$queryresult['success'] = 'false';
			$queryresult['error']   = 'parameter missing';
			echo print_json_encode($queryresult);
   } 
 }
 ?>

   