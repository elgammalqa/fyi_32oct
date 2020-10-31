 <?php  
 
// stern  enclosure url  gmt 
 //https://www.stern.de/feed/standard/politik/   news
 //https://www.stern.de/feed/standard/sport/    sports
 //https://www.stern.de/feed/standard/kultur/ arts
 //http://www.stern.de/feed/standard/lifestyle/   culture
 
 //RP ONLINE   enclosure url  desc null -1
 //https://rp-online.de/politik/feed.rss   news 
 //https://rp-online.de/sport/feed.rss   sports
 //https://rp-online.de/kultur/feed.rss  culture
// https://rp-online.de/digitales/feed.rss   technology
   


 // ksta   enclosure url -1
 //https://www.ksta.de/blueprint/servlet/xml/ksta/23699296-asYahooFeed.xml    news
 //https://www.ksta.de/blueprint/servlet/xml/ksta/23699302-asYahooFeed.xml    arts

//Berliner Zeitung  enclosure url -1
 //https://www.berliner-zeitung.de/blueprint/servlet/xml/berliner-zeitung/23699614-asYahooFeed.xml news 
 //https://www.berliner-zeitung.de/blueprint/servlet/xml/berliner-zeitung/23699874-asYahooFeed.xml
 //sports
 //https://www.berliner-zeitung.de/blueprint/servlet/xml/berliner-zeitung/23700020-asYahooFeed.xml culture
 //https://www.berliner-zeitung.de/blueprint/servlet/xml/berliner-zeitung/23700594-asYahooFeed.xml tech

 //GALA  enclosure url  gmt
 //http://www.gala.de/feed/standard-rss/ news
 
 
$xSource='https://www.noz.de/rss/ressort/Vermischtes'; 
 $xsourcefile = file_get_contents($xSource); 
 //$xml2=str_replace('media:content','enclosure', $xsourcefile); 
    $xml = simplexml_load_string($xsourcefile); 
      foreach ($xml->channel->item as $item) {  
     echo "title : ".$item->title."<br>"; 
     // echo "description :  <br>";
     echo "description : ".$item->description." <br>";
      echo "pubDate : ".$item->pubDate."<br>"; ?>
      <img width="800" src="<?php echo $item->enclosure['url']; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php  }


/*
     //1  
      $xSource='https://www.wiwo.de/contentexport/feed/rss/technologie';
      $src='WiWo';  $word='enclosure'; $t='Technology';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
     //2  
      $xSource='https://www.wiwo.de/contentexport/feed/rss/politik';
      $src='WiWo';  $word='enclosure'; $t='News';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
     //3  
      $xSource='https://www.wiwo.de/contentexport/feed/rss/lifestyle';
      $src='WiWo';  $word='enclosure'; $t='General Culture';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
     //4 
      $xSource='https://bnn.de/nachrichten/kultur/feed';
      $src='BNN';  $word='enclosure'; $t='General Culture';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
     //5 
      $xSource='https://bnn.de/nachrichten/sport/feed';
      $src='BNN';  $word='enclosure'; $t='Sports';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
     //6 
      $xSource='https://bnn.de/nachrichten/politik/feed';
      $src='BNN';  $word='enclosure'; $t='News';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
     //7 
      $xSource='https://www.noz.de/rss/ressort/Sport';
      $src='NOZ';  $word='enclosure'; $t='Sports';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
     //8
      $xSource='https://www.noz.de/rss/ressort/Politik';
      $src='NOZ';  $word='enclosure'; $t='News';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
     //9
      $xSource='https://www.noz.de/rss/ressort/Kultur';
      $src='NOZ';  $word='enclosure'; $t='Arts';$signe='-';$hours=2;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
 
*/

//https://www.morgenpost.de
//https://www.augsburger-allgemeine.de/rss
//   echo $item->enclosure->attributes()->url;  
//$item->enclosure['url']
  ?>