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

   function getrsstime2($d) 
{  
    if($d!=""){
    $d=trim($d);
    $parts=explode('T',$d);   
    $year=$parts[0];  
    $minutes=$parts[1];  
    $time=explode('Z',$minutes);  
    $date="$year $time[0]"; 
     return $date;
 }else{ 
     return "";
 }
} 

function getmonth($month){
   if($month=="Jan") $monthreal=1; if($month=="Feb") $monthreal=2; if($month=="Mar") $monthreal=3;
    if($month=="Apr") $monthreal=4;  if($month=="May") $monthreal=5;  if($month=="Jun") $monthreal=6;
    if($month=="Jul") $monthreal=7;  if($month=="Aug") $monthreal=8; if($month=="Sep") $monthreal=9;
     if($month=="Oct") $monthreal=10;  if($month=="Nov") $monthreal=11; if($month=="Dec") $monthreal=12; 
     return $monthreal;
 }   
   	 
    $m='https://iasbh.tmgrup.com.tr/cbff7b/320/320/103/0/1182/1080?u=https://isbh.tmgrup.com.tr/sbh/2019/08/21/bozcaadada-yepyeni-bir-festival-1566375449959.jpg';
     
echo $m;
$xSource='https://www.sabah.com.tr/rss/kultur-sanat.xml'; 
 $xsourcefile = file_get_contents($xSource);  
 $xml=str_replace('hh','media', $xsourcefile);
 //$xml=str_replace('</image>','</media>', $xml); 
    $xml = simplexml_load_string($xml); 
     /*  foreach ($xml->channel->item as $item) { 
     $description=$item->description."<br>";  
      echo "title : ".$item->title."<br>"; 
      $has_img= strpos($description, '<img') !== false;  
      if($has_img){
        $description='';
      } 
      echo "description : ".$description."<br>"; 
      echo "pubDate : ".getrsstime($item->pubDate)."<br>"; ?>
      <img width="800" height="500" src="<?php echo $item->image->url; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php 
       } 
  */
  // echo '<pre>';  print_r($xml);   echo '</pre>'; 
      /*  
      if ($src=='Milli Gazete') { 
          $vowels = array("<p>", "</p>");
          $description=str_replace($vowels, "", $description);
          $description=addslashes($description);
      } 
      //1 
      $xSource='https://www.milligazete.com.tr/rss';
      $src='Milli Gazete';  $word='enclosure';   $t='News';$signe='-';$hours=3;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);  
      
      //2
      $xSource='http://www.cumhuriyet.com.tr/rss/11.xml';
      $src='Cumhuriyet';  $word='enclosure';   $t='Technology';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
      //3
      $xSource='http://www.cumhuriyet.com.tr/rss/9.xml';
      $src='Cumhuriyet';  $word='enclosure';   $t='Sports';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //4
      $xSource='http://www.cumhuriyet.com.tr/rss/5.xml';
      $src='Cumhuriyet';  $word='enclosure';   $t='News';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //5
      $xSource='http://www.cumhuriyet.com.tr/rss/7.xml';
      $src='Cumhuriyet';  $word='enclosure';   $t='General Culture';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
  
      /*
      $xSource='https://www.turkiyegazetesi.com.tr/rss/rss.xml';
      $src='';  $word='media:thumbnail'; $t='News';$signe='-';$hours=3;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
      getrsstime2 
      
   function getrsstime2($d) 
{  
    if($d!=""){
    $d=trim($d);
    $parts=explode('T',$d);   
    $year=$parts[0];  
    $minutes=$parts[1];  
    $time=explode('Z',$minutes);  
    $date="$year $time[0]"; 
     return $date;
 }else{ 
     return "";
 }
} 

      https://www.turkiyegazetesi.com.tr/rss/rss.xml date prblm
      https://www.yenisafak.com/rss-listesi  if does not exist 4
      $xml=str_replace('<image>','<media>', $xsourcefile);
      $xml=str_replace('</image>','</media>', $xml);
 