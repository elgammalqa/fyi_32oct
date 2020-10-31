 <?php    

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
function getrsswithmedia($xSource,$src,$t,$word,$signe,$hours){}
$xSource=''; 
 $xsourcefile = file_get_contents($xSource); 
  $xml2=str_replace('media:content','media', $xsourcefile); 
    $xml = simplexml_load_string($xml2); 
      foreach ($xml->channel->item as $item) {  
      echo "title : ".$item->title."<br>";   
      $description=$item->description->p;
      $vowels = array("<p>", "</p>");
      $description=str_replace($vowels,"", $description);
      echo "description : ".$description." <br>";
      echo "pubDate : ".getrsstime($item->pubDate)."<br>";  ?>
      <img src="<?php echo $item->picture; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php   } 

        //1  ex
        $xSource = 'https://www.globes.co.il/webservice/rss/rssfeeder.asmx/FeederNode?iid=9010';
        $src='globes'; $word='media:content'; $t='General Culture';$signe='-';$hours=3;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
        //2 
        /*
         $has_div = strpos($description, '</div>') !== false; 
         if($has_div){ $description=''; }
        item->image
        Israel Hayom
        */ 
        $xSource = 'https://www.israelhayom.co.il/rss.xml';
        $src='Israel Hayom'; $word='media:content'; $t='News';$signe='+';$hours=0;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);

 
        //3
        $xSource = 'https://www.davar1.co.il/feed/';
        $src='Davar news'; $word='media:content'; $t='News';$signe='+';$hours=0;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
        






 
 

//   echo $item->enclosure->attributes()->url;  
      //$item->enclosure['url']
  ?>