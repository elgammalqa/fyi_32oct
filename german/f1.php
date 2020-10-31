<?php 
  
 //JUNGE FREIHEIT  news gmt
//https://jungefreiheit.de/feed/

//ARD Mediathek gmt  sports
//https://www.sportschau.de//sportschauindex100~_type-rss.feed

//Motorsport -1 sports
//https://www.motorsport-magazin.com/rss/alle-rennserien.xml
 
//COMPUTER BILD -1 tech 
//https://www.computerbild.de/rssfeed_2261.html?node=10

//PC-WELT   tech -1
//https://www.pcwelt.de/rss/ratgeberfeed.xml
 
//
$xSource='https://www.neues-deutschland.de/rss/sport.xml';
 $xsourcefile = file_get_contents($xSource); 
    $xml = simplexml_load_string($xsourcefile ); 
     foreach ($xml->channel->item as $item) {  
     echo "pubDate : ".$item->pubDate."<br>";   
      echo "title : ".$item->title."<br>";   
      echo "description : ".$item->description."<br>";  
          echo "link : ".$item->link."<br><br><br>";  }  
   
   //  echo '<pre>';  print_r($xml);   echo '</pre>';
    
      /*    
    //1 
        $xSource = 'https://www.sportschau.de//sportschauindex100~_type-rss.feed';
        $src='Sportschau'; $t='Sports'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);  
    //2 
        $xSource = 'https://www.neues-deutschland.de/rss/kultur.xml';
        $src='neues deutschland'; $t='General Culture'; $signe='-';$hours=2;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 




/* ne pas pris en charge 
   //3 
        $xSource = 'https://www.neues-deutschland.de/rss/politik.xml';
        $src='neues deutschland'; $t='News'; $signe='-';$hours=2;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //4 
        $xSource = 'https://www.neues-deutschland.de/rss/sport.xml';
        $src='neues deutschland'; $t='Sports'; $signe='-';$hours=2;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
        
*/
 
      
 ?>