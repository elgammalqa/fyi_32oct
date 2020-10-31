 
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
 
$xSource='https://www.lexpress.fr/rss/monde.xml'; 
 $xsourcefile = file_get_contents($xSource);  
 $xml=str_replace('media:content','enclosure', $xsourcefile); 
    $xml = simplexml_load_string($xml ); 
      foreach ($xml->channel->item as $item) {  
     echo "title : ".$item->title."<br>"; 
     echo "description : ".$item->description."<br>";
      echo "pubDate : ".getrsstime($item->pubDate)."<br>"; ?>
      <img src="<?php echo $item->enclosure['url']; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php  } 
   
 //L'equipe  L'OBS  le monde  le parisien    sud-ouest  
   //le point   france info    la presse    le figaro  sud-ouest 

  //  echo '<pre>';  print_r($xml);   echo '</pre>'; 
      /* v2
      $has_questionMark = strpos($m, '?') !== false; 
      if($has_questionMark){
        $m = substr($m, 0,strpos($m, "?") ); 
      } 
      //1  challenges News -2 
      $xSource='https://www.challenges.fr/monde/rss.xml';
      $src='challenges';  $word='enclosure';   $t='News';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //2  challenges Technology -2
      $xSource='https://www.challenges.fr/high-tech/rss.xml';
      $src='challenges';  $word='enclosure';   $t='Technology';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //3  
      $xSource='https://www.challenges.fr/patrimoine/rss.xml';
      $src='challenges';  $word='enclosure';   $t='General Culture';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //4  courrierinternational
      $xSource='https://www.courrierinternational.com/feed/all/rss.xml';
      $src='courrier international';  $word='enclosure';   $t='News';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
        


      */
    ?>