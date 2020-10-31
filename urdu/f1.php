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
 

$xSource='http://boltapakistan.com.pk/feed/';
 $xsourcefile = file_get_contents($xSource);   
    $xml = simplexml_load_string($xsourcefile); 
     foreach ($xml->channel->item as $item) {  
          echo "pubDate : ".getrsstime($item->pubDate)."<br>";   
          echo "title : ".$item->title."<br>"; 
          $description=$item->description;   
          echo "description : ".$description."<br>";  
          echo "link : ".$item->link."<br><br><br>";  
           }   

     //1
        $xSource = 'http://dailyaag.com/phase2/feed/';
        $src='dailyaag'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);   
    //2 
       /*  aaa
       $vowels = array("<p>", "</p>");
          $description=str_replace($vowels, "", $item->description); 
          $has_post = strpos($description, 'The post') !== false; 
          if($has_post){ $description = substr($description,0,strpos($description,"The post")); }
        */
        $xSource = 'http://www.bhatkallys.com/ur/feed/';
        $src='Bhatkallys'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //3 aaa
        $xSource = 'http://urdu.chauthiduniya.com/feed/';
        $src='Chauthi Duniya'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //4   
        /* bbb
          $has_post = strpos($description, '<a') !== false; 
          if($has_post){ $description = substr($description,0,strpos($description,"<a")); } 
          $vowels = array("<p>", "</p>");
          $description=str_replace($vowels, "", $description);
        */
        $xSource = 'http://aajkal.com.pk/feed/';
        $src='Aaj Kal'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //5 
        /* ccc
        $has_post = strpos($description, '</div>') !== false; 
        if($has_post){ $description = substr($description,strpos($description,"</div>")+6); } 
        */
        $xSource = 'https://zamaswat.com/feed/';
        $src='Zama Swat'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //6 
        $xSource = 'https://www.jasarat.com/feed/';
        $src='Jasarat'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //7 bbbb
        $xSource = 'http://juraat.com/feed/';
        $src='Juraat'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
    //8
        $xSource = 'http://dailymussalman.com/?feed=rss2';
        $src='Daily Mussalman'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //9 bbb
        $xSource = 'https://dailylahorepost.com/feed/';
        $src='Lahore Post'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //10  
        /* 
         $xml=str_replace('This post was written by Saif Ur Rehman This post was written by Saif Ur Rehman', '',$xsourcefile); 
        $xml=str_replace('Check out WPBeginner', '',$xml);
       */
        $xSource = 'https://chitraltimes.com/feed/';
        $src='Chitral Times'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //11
        $xSource = 'https://www.nawaiwaqt.com.pk/rss/international';
        $src='Nawaiwaqt'; $t='News'; $signe='-';$hours=5;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //12 
         $xSource = 'http://boltapakistan.com.pk/feed/';
        $src='Bolta'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);

    //13 ccc 
        $xSource = 'https://dailytaqat.com/feed/';
        $src='Daily Taqat'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    //14  ccc
        $xSource = 'https://ummat.net/feed/';
        $src='Ummat'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
        //15 
        $xSource = 'http://dailyuniversal.com.pk/feed';
        $src='Daily Universal'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
     

        /*
        $xSource = 'http://nawaeislam.com/feed/';
        $src='Nawa-e-Islam'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);

        $xSource = 'https://www.dailytafteesh.com.pk/feed/';
        $src='Daily Tafteesh'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);

        $xSource = 'https://www.nawaiwaqt.com.pk/rss/sports';
        $src='Nawaiwaqt'; $t='Sports'; $signe='-';$hours=5;
        getrssfromsource($xSource,$src,$t,$signe,$hours);

        */
 ?>