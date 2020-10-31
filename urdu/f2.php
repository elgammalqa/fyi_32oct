 <?php  
  
//Express News   media:content url  desc null   gmt
 //https://www.express.pk/world/feed/     news 
 //https://www.express.pk/science/feed/    tech
//https://www.express.pk/saqafat/feed/ culture
 //https://www.express.pk/sports/feed/ sports

 //BBC  news gmt  media:thumbnail url 
 //http://feeds.bbci.co.uk/urdu/rss.xml 

//The Siasat    gmt desc null image 
//https://urdu.siasat.com/feed/  
 

//VOA  -5 enclosure url 
 //https://www.urduvoa.com/api/zoot_egkty   news
 //https://www.urduvoa.com/api/zuytpepqum sports
 //https://www.urduvoa.com/api/zg_tte_rut  arts
 //https://www.urduvoa.com/api/zoytmegru_   tech

 function getrsstime($d) 
{ 
    $parts=explode(' ',$d);  
    $month=$parts[2];  
    $monthreal=getmonth($month);
    $time=explode(':',$parts[4]);  
    $date="$parts[3]-$monthreal-$parts[1] $time[0]:$time[1]:$time[2]"; 
     return $date;
} 
function getmonth($month){
   if($month=="Jan") $monthreal=1; if($month=="Feb") $monthreal=2; if($month=="Mar") $monthreal=3;
    if($month=="Apr") $monthreal=4;  if($month=="May") $monthreal=5;  if($month=="Jun") $monthreal=6;
    if($month=="Jul") $monthreal=7;  if($month=="Aug") $monthreal=8; if($month=="Sep") $monthreal=9;
     if($month=="Oct") $monthreal=10;  if($month=="Nov") $monthreal=11; if($month=="Dec") $monthreal=12; 
     return $monthreal;
     }  

$xSource='https://www.express.pk/sports/feed/'; 
 $xsourcefile = file_get_contents($xSource); 
  $xml2=str_replace('media:content','enclosure', $xsourcefile); 
    $xml = simplexml_load_string($xml2); 
      foreach ($xml->channel->item as $item) {  
     echo "title : ".$item->title."<br>";  
      echo "description : ".$item->description." <br>";
      echo "pubDate : ".getrsstime($item->pubDate)."<br>"; ?>
      <img src="<?php echo $item->enclosure['url']; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php    }



      //$item->enclosure['url'];
      //https://www.urduvoa.com/api/ziotyejktv   news  
      //echo $item->enclosure->attributes()->url;  
      //$item->enclosure['url']
  ?>