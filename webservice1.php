<?php
$messages = "Test";
			ini_set('display_errors',1);ini_set('php_openssl',1);
			error_reporting(E_ALL);
			$passphrase = ''; 
			$token = "EED050B900BDC59BA4D0507C75BE28B96E645E9D397D44351E6DFBB2227B370E";
			 $tCert = "PushPemCertificates.pem"; 
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
			// print_r($apns);
			$payload['aps'] = array('alert' =>  array('title' => "Notification from goldeneye-group.com",'body' => $messages), 'badge' => 1, 'sound' => 'default');
			$output = json_encode($payload);
		
			$token = pack('H*', str_replace(' ', '', $token));
			$apnsMessage = chr(0) . chr(0) . chr(32) . $token . chr(0) . chr(strlen($output)) . $output;
			$result = fwrite($apns, $apnsMessage);
			@socket_close($apns);
			 print_r($result);
			  exit;
			if ($result)
			{
				//echo 'MESSAGE SENT TO ASPN';
				//return 'Message not delivered' . PHP_EOL;
			}
			else
			{
				//echo 'MESSAGE NOT SENT TO ASPN';
				//return 'Message successfully delivered' . PHP_EOL;
			} 
			fclose($apns);	?>