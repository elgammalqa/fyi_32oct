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
    if($month=="Jul") $monthreal=7;  if($month=="Aug") $monthreal=8; if($month=="Sep") $monthreal=9;
     if($month=="Oct") $monthreal=10;  if($month=="Nov") $monthreal=11; if($month=="Dec") $monthreal=12; 
     return $monthreal;
 }  

$xSource='https://www.yenisafak.com/ar/rss'; 
 $xsourcefile = file_get_contents($xSource); 
 //$xml=str_replace('media:content','media', $xsourcefile); 
    $xml = simplexml_load_string($xsourcefile);  
      foreach ($xml->channel->item as $item) {  
     echo "title : ".$item->title."<br>"; 
     echo "description : ".$item->description."<br>"; 
      echo "pubDate : ".getrsstime($item->pubDate)."<br>"; ?> 
      <img  width="100%"   style="padding-bottom: 5px; object-fit: contain; height: 340px;"  
      src="<?php echo $item->image->url; ?>"  alt="Image"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php  } 
  //  echo '<pre>';  print_r($xml);   echo '</pre>'; 
       
//with  media
 // $xSource='';
  //$src='';  $word='';   $t='';$signe='';$hours=;
  $xSource='https://arabic.rt.com/rss/';
  $src='RT Arabic';  $word='enclosure';   $t='News';$signe='+';$hours=0; 
  //2
  $xSource='https://arabi21.com/feed';
  $src='arabi21';  $word='enclosure';   $t='News';$signe='+';$hours=0;
  //3  image au lieu de enclosure url
  $xSource='https://www.aa.com.tr/ar/rss/default?cat=live';
  $src='aa';  $word='imagex';   $t='News';$signe='-';$hours=3;
 //4
  $xSource='https://www.alarab.qa/rss';
  $src='alarab_qa';  $word='enclosure';   $t='News';$signe='+';$hours=0;
  //5 image->url
  $xSource='https://www.yenisafak.com/ar/rss';
  $src='yenisafak';  $word='imagex';   $t='News';$signe='+';$hours=0;
 //6
  $xSource='https://arabia.as.com/rssFeed/55';
  $src='As Arabia';  $word='media:content';   $t='Sports';$signe='-';$hours=3;
  //7 desc null 
  $xSource='http://www.alsopar.com/rss-action-feed-m-news-id-0-feed-rss20.xml';
  $src='alsopar';  $word='enclosure';   $t='Sports';$signe='+';$hours=0;
  //8
   $xSource='http://www.alblaad.com/rss/9/%D8%B1%D9%8A%D8%A7%D8%B6%D8%A9/';
  $src='alblaad';  $word='enclosure';   $t='Sports';$signe='+';$hours=0;
  //9
   $xSource='http://www.alblaad.com/rss/20/%D9%81%D9%86-%D9%88-%D8%AB%D9%82%D8%A7%D9%81%D8%A9/';
  $src='alblaad';  $word='enclosure';   $t='Arts';$signe='+';$hours=0;
  //10
   $xSource='http://www.alblaad.com/rss/17/%D8%B9%D9%84%D9%88%D9%85-%D9%88-%D8%AA%D9%83%D9%86%D9%88%D9%84%D9%88%D8%AC%D9%8A%D8%A7/';
  $src='alblaad';  $word='enclosure';   $t='Technology';$signe='+';$hours=0;
  //11
   $xSource='http://www.alblaad.com/rss/16/%D8%A7%D9%84%D8%B5%D8%AD%D9%87-%D9%88-%D8%A7%D9%84%D8%AC%D9%85%D8%A7%D9%84/';
  $src='alblaad';  $word='enclosure';   $t='General Culture';$signe='+';$hours=0;
  //12
   $xSource='http://www.alblaad.com/rss/25/%D8%B9%D9%80%D8%B1%D8%A8%D9%8A-%D9%88-%D8%B9%D9%80%D8%A7%D9%84%D9%85%D9%8A/';
  $src='alblaad';  $word='enclosure';   $t='News';$signe='+';$hours=0;
 















//https://www.btolat.com/RSS/videosfeed sports desc null
 ?>