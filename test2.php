<?php 
 if(isset($_GET['url']) && !empty($_GET['url'])){
	$url=$_GET['url'];  
 
 	$ch = curl_init();    
 	curl_setopt($ch, CURLOPT_URL, $url);
 	curl_setopt($ch, CURLOPT_HEADER, true); 
 	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 	curl_exec($ch);  
 	$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);   
 	curl_close($ch); 
 	$parse = parse_url($url);
 	$url=$parse['scheme'].'://'.$parse['host']; 
 
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
	echo "URL Doesn't Open"; 
} 
  
}  
 ?>