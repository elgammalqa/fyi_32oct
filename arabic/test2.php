<?php 
 if(isset($_GET['url']) && !empty($_GET['url'])){
	$url=$_GET['url'];     

	// Use curl_init() function to initialize a cURL session 
	$curl = curl_init($url);  

	// Use curl_setopt() to set an option for cURL transfer 
	curl_setopt($curl, CURLOPT_NOBODY, true); 

	// Use curl_exec() to perform cURL session 
	$result = curl_exec($curl); 

if ($result !== false) {  
	// Use curl_getinfo() to get information 
	// regarding a specific transfer 

	$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
	if ($statusCode == 404) { 
		echo "URL Doesn't Open"; 
	} 
	else { 
		echo "URL Open"; 
	} 
} 
else { 
	echo "URL Doesn't Open f"; 
} 
 
}  
 ?>