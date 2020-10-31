<?php  
    $url = $_SERVER['QUERY_STRING']; 
    $url = substr($url, 0,strpos($url, "&id=") );
    $url = substr($url, 5); 
    $id=$_GET['id'];    
    $ch = curl_init();    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch); // $a will contain all headers
    $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);   
    $has_hashtag = strpos($url, '#') !== false;
    if($has_hashtag){
         $url = substr($url, 0,strpos($url, "#") );
    }    
    $has_http = strpos($url, 'http://') !== false;
    if ($has_http) {
        $link = "http://www.fyipress.net/german/iframe.php?link=" . stripslashes($url) . "&id=" . $id;
    } else {
        $link = "https://www.fyipress.net/german/iframe.php?link=" . stripslashes($url) . "&id=" . $id;
    }  
 ?> 
  <script type="text/javascript">
     window.open('<?php echo $link; ?>',"_self"); 
 </script>
   