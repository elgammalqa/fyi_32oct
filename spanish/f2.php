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
 
$xSource='https://www.sport.es/rss/futbol-internacional/rss.xml'; 
 $xsourcefile = file_get_contents($xSource);  
 $xml=str_replace('media:content','media', $xsourcefile); 
    $xml = simplexml_load_string($xml ); 
      foreach ($xml->channel->item as $item) {  
     echo "title : ".$item->title."<br>"; 
    // echo "description : ".$item->description."<br>";
      $has_Paragraph = strpos($item->description, '</p>') !== false; 
      if(!$has_Paragraph) echo "description : ".$item->description."<br>";
      else echo 'no desc <br>';
      echo "pubDate : ".getrsstime($item->pubDate)."<br>"; ?>
      <img width="800" height="500" src="<?php echo $item->media['url']; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php  } 
/*
https://www.canarias7.es/corporativa/canales-rss   5 

  
//1
      $xSource='https://www.deia.eus/rss/politica.xml';
      $src='Deia';  $word='enclosure'; $t='News';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
//2
      $xSource='https://www.deia.eus/rss/deportes.xml';
      $src='Deia';  $word='enclosure'; $t='Sports';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
//3
      $xSource='https://www.deia.eus/rss/ocio-y-cultura.xml';
      $src='Deia';  $word='enclosure'; $t='Arts';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);

//4
      $xSource='https://www.larazon.es/rss/deportes.xml';
      $src='La Razón';  $word='media:content'; $t='Sports';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);

//5
      $xSource='https://www.larazon.es/rss/internacional.xml';
      $src='La Razón';  $word='media:content'; $t='News';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
//6
      $xSource='https://www.larazon.es/rss/cultura.xml';
      $src='La Razón';  $word='media:content'; $t='General Culture';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);

//7
      $xSource='https://www.larazon.es/rss/cultura/cine.xml';
      $src='La Razón';  $word='media:content'; $t='Arts';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);

//ideal
