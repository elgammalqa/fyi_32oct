
<?php          
 function getrsstime($d) 
{  
    if($d!=""){
    $d=trim($d);
    $parts=explode(' ',$d);   
    $month=$parts[2];  
    $monthreal=getmonth($month);  
    $time=explode(':',$parts[4]);  
    $date="$parts[3]-$monthreal-$parts[1] $time[0]:$time[1]:$time[2]"; 
     return $date;
 }else{ 
     return "";
 }
} 
function getmonth($month){
   if($month=="Jan") $monthreal=1; if($month=="Feb") $monthreal=2; if($month=="Mar") $monthreal=3;
    if($month=="Apr") $monthreal=4;  if($month=="May") $monthreal=5;  if($month=="Jun") $monthreal=6;
    if($month=="Jul"||$month=="July") $monthreal=7;  if($month=="Aug") $monthreal=8; if($month=="Sep") $monthreal=9;
     if($month=="Oct") $monthreal=10;  if($month=="Nov") $monthreal=11; if($month=="Dec") $monthreal=12; 
     return $monthreal;
 }  

     $xSource=''; 
     $xsourcefile = file_get_contents($xSource); 
    $xml=str_replace('enclosure','media', $xsourcefile);
    $xml = simplexml_load_string($xml); 
       foreach ($xml->channel->item as $item) {  
     echo "title : ".$item->title."<br>"; 
     $description=$item->description;
      $has_Paragraph_img = strpos($description, '<img') !== false; 
      $has_Paragraph = strpos($description, '</p>') !== false; 
         if($has_Paragraph_img||$has_Paragraph) $description='';
     echo "description : ".$description."<br>";
      echo "pubDate : ".getrsstime($item->pubDate)."<br>"; ?>
      <img width="800" src="<?php echo $item->media['url']; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php  }  


        /* 
        //1 
        $xSource = 'https://www.prabhasakshi.com/feed.aspx?cat_id=120';
        $src='प्रभासाक्षी'; $word='enclosurex'; $t='General Culture'; $signe='+';$hours=0; $mintes=0;
         getrsswithmedia($xSource,$src,$t,$word,$signe,$hours,$mintes); 
        
        */ 
   
         //https://hindi.oneindia.com/rss/hindi-news-fb.xml news
 
 
    ?>