  
<?php   
//NDTV Khabar    -530
//http://feeds.feedburner.com/ndtvkhabar-world  news 
//http://feeds.feedburner.com/ndtvkhabar-sports sports
 
  

//Navbharat Times      gmt  
//https://navbharattimes.indiatimes.com/world/rssfeedsection/2279801.cms     news 
//https://navbharattimes.indiatimes.com/sports/rssfeedsection/2279790.cms sports
//  
 
//अमर उजाला -530
//https://www.amarujala.com/rss/sports.xml   sports
//https://www.amarujala.com/rss/technology.xml tech
//https://www.amarujala.com/rss/india-news.xml news


//प्रभासाक्षी  gmt 
//https://www.prabhasakshi.com/feed.aspx?cat_id=3      news
//https://www.prabhasakshi.com/feed.aspx?cat_id=5    sports
//https://www.prabhasakshi.com/feed.aspx?cat_id=24   tech



//देशबंधु   gmt
//http://www.deshbandhu.co.in/rss/politics  news 
//http://www.deshbandhu.co.in/rss/sports sports


 //वेबदुनिया -530
 //http://hindi.webdunia.com/rss/mobile-updates-10104.rss   tech

//nn

// पुढारी  2018-11-23 16:47:17
//http://www.pudhari.news/rss.php?rss_value=category&rss_name=Sports    sports
//http://www.pudhari.news/rss.php?rss_value=category&rss_name=International  news
  
$xSource='';
 $xsourcefile = file_get_contents($xSource); 
    $xml = simplexml_load_string($xsourcefile ); 
     foreach ($xml->channel->item as $item) {  
      echo "pubDate : ".$item->pubDate."<br>";   
      echo "title : ".$item->title."<br>";   
      echo "description : ".$item->description."<br>";  
      echo "link : ".$item->link."<br><br><br>";  } 
   // echo '<pre>';  print_r($xml);   echo '</pre>';

      /*
        //1 
       $xSource = 'https://www.amarujala.com/rss/lifestyle.xml';
        $src='अमर उजाला'; $t='General Culture'; $signe='-';$hours=5; $mintes=30;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes);
        //2
        $xSource = 'https://navbharattimes.indiatimes.com/tech/gadgets-news/rssfeedsection/66130905.cms';
        $src='Navbharat Times'; $t='Technology'; $signe='-';$hours=5; $mintes=30;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes); 
        //3
        $xSource = 'http://navbharattimes.indiatimes.com/travel/rssfeedsection/2355172.cms';
        $src='Navbharat Times'; $t='General Culture'; $signe='-';$hours=5; $mintes=30;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes);  
       //4
        $xSource = 'https://zeenews.india.com/hindi/world.xml';
        $src='Zee News'; $t='News'; $signe='-';$hours=5; $mintes=30;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes); 
       //5 
        $xSource = 'https://zeenews.india.com/hindi/sports.xml';
        $src='Zee News'; $t='Sports'; $signe='-';$hours=5; $mintes=30;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes); 
       //6 
        $xSource = 'http://dabangdunia.co/feed.aspx?cat_id=25';
        $src='दबंग दुनिआ'; $t='Sports'; $signe='+';$hours=0; $mintes=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes); 
       //7
        $xSource = 'http://dabangdunia.co/feed.aspx?cat_id=31';
        $src='दबंग दुनिआ'; $t='General Culture'; $signe='+';$hours=0; $mintes=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes);  
        //8
        $xSource = 'https://tarunmitra.in/feed';
        $src='तरुण मित्र'; $t='News'; $signe='+';$hours=0; $mintes=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes);
        //9
        $xSource = 'https://www.bhadas4media.com/feed/';
        $src='Bhadas4Media'; $t='News'; $signe='+';$hours=0; $mintes=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes);
 
   


   //https://www.w3newspapers.com/india/hindi/ from Puri Dunia

        */
       
    ?>