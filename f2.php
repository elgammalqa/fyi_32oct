<?php   
$xSource='https://www.infoworld.com/category/internet/index.rss'; 
 $xsourcefile = file_get_contents($xSource);  
 $xml=str_replace('media:thumbnail','enclosure', $xsourcefile); 
    $xml = simplexml_load_string($xml ); 
      foreach ($xml->channel->item as $item) {  
     echo "title : ".$item->title."<br>"; 
    // echo "description : ".$item->description."<br>";
      $has_Paragraph = strpos($item->description, '</p>') !== false; 
      if(!$has_Paragraph) echo "nonodescription : ".$item->description."<br>";
      else echo 'yesyes';
      echo "pubDate : ".$item->pubDate."<br>"; ?>
      <img width="500" height="500" src="<?php echo $item->enclosure['url']; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php  } 
 
 //  echo '<pre>';  print_r($xml);   echo '</pre>'; 
      /* v2
      $has_questionMark = strpos($m, '?') !== false; 
      if($has_questionMark){
        $m = substr($m, 0,strpos($m, "?") ); 
      } 
      //1 slate +0 Arts
      $xSource='https://slate.com/feeds/culture.rss';
      $src='slate';  $word='media:content';   $t='Arts';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //2 slate +0 Technology
      $xSource='https://slate.com/feeds/technology.rss';
      $src='slate';  $word='media:content';   $t='Technology';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //3 slate +0 News
      $xSource='https://slate.com/feeds/news-and-politics.rss';
      $src='slate';  $word='media:content';   $t='News';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //4 slate +0 General
      $xSource='https://slate.com/feeds/human-interest.rss';
      $src='slate';  $word='media:content';   $t='General Culture';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //5 
      $xSource = 'http://www.independent.co.uk/news/rss';
      $src='independent'; $word='media:thumbnai'; $t='News';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
      //6
      $xSource = 'https://www.standard.co.uk/rss';
      $src='standard'; $word='media:content'; $t='News';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //7
      $xSource = 'https://www.thestar.co.uk/sport/rss';
      $src='thestar'; $word='media:content'; $t='Sports';$signe='-';$hours=1;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //8
      $xSource = 'https://www.thestar.co.uk/news/rss';
      $src='thestar'; $word='media:content'; $t='News';$signe='-';$hours=1;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //9
      $xSource = 'https://www.thestar.co.uk/lifestyle/rss';
      $src='thestar'; $word='media:content'; $t='General Culture';$signe='-';$hours=1;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
      //10 
      $xSource = 'https://www.walesonline.co.uk/news/?service=rss';
      $src='wales online'; $word='enclosure'; $t='News';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
      //11
      $xSource = 'https://www.walesonline.co.uk/sport/?service=rss';
      $src='wales online'; $word='enclosure'; $t='Sports';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //12
      $xSource = 'https://www.walesonline.co.uk/lifestyle/?service=rss';
      $src='wales online'; $word='enclosure'; $t='General Culture';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);  
      //13
      $xSource = 'https://www.dailypost.co.uk/news/?service=rss';
      $src='daily post'; $word='enclosure'; $t='News';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //14
      $xSource = 'https://www.dailypost.co.uk/sport/?service=rss';
      $src='daily post'; $word='enclosure'; $t='Sports';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
      //15
      $xSource = 'https://www.dailypost.co.uk/whats-on/?service=rss';
      $src='daily post'; $word='enclosure'; $t='General Culture';$signe='+';$hours=0;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
      //16
      $xSource = 'https://www.infoworld.com/category/internet/index.rss';
      $src='info world'; $word='media:thumbnail'; $t='Technology';$signe='+';$hours=7;
      getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);  
      for all if des contains </p> desc=''
   
      */
 ?>



















