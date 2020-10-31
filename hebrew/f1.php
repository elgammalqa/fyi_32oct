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
 function getrssfromsource($xSource,$src,$t,$signe,$hours){}
$xSource='';
 $xsourcefile = file_get_contents($xSource); 
    $xml = simplexml_load_string($xsourcefile ); 
     foreach ($xml->channel->item as $item) {  
      echo "pubDate : ".getrsstime($item->pubDate)."<br>";   
      echo "title : ".$item->title."<br>";   
       $description=$item->description;
       $has_post = strpos($description, '</div>') !== false; 
        if($has_post){
           $description = substr($description,strpos($description, "</div>")+6 ); 
        }  
      echo "description : ".$description."<br>";  
      echo "link : ".$item->link."<br><br><br>";  
    }  
  
 
      /*
      $has_div = strpos($description, '</div>') !== false; 
        if($has_div){
           $description = substr($description,strpos($description, "</div>")+6 ); 
        }

        calcalist   ynet  TGspot
      */
     //calcalist
        $xSource = 'https://www.calcalist.co.il/GeneralRSS/0,16335,L-3778,00.xml';
        $src='calcalist'; $t='Technology'; $signe='-';$hours=3;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
     //calcalist
        $xSource = 'https://www.calcalist.co.il/GeneralRSS/0,16335,L-13,00.xml';
        $src='calcalist'; $t='News'; $signe='-';$hours=3;
        getrssfromsource($xSource,$src,$t,$signe,$hours);  
        //
        $xSource = 'https://www.calcalist.co.il/GeneralRSS/0,16335,L-18,00.xml';
        $src='calcalist'; $t='Sports'; $signe='-';$hours=3;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
       
        /*
        $has_div = strpos($description, '</div>') !== false; 
        if($has_div){
           $description = substr($description,strpos($description, "</div>")+6 ); 
        }
        */
        //5
         $xSource = 'http://www.ynet.co.il/Integration/StoryRss545.xml';
        $src='ynet'; $t='Technology'; $signe='-';$hours=2;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
        //6
         $xSource = 'http://www.ynet.co.il/Integration/StoryRss3.xml';
        $src='ynet'; $t='Sports'; $signe='-';$hours=2;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
        //7
         $xSource = 'http://www.ynet.co.il/Integration/StoryRss538.xml';
        $src='ynet'; $t='General Culture'; $signe='-';$hours=2;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
        //8
         $xSource = 'http://www.ynet.co.il/Integration/StoryRss2.xml';
        $src='ynet'; $t='News'; $signe='-';$hours=2;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
         //14
        /*
      $has_div = strpos($description, '</div>') !== false; 
        if($has_div){
           $description = substr($description,strpos($description, "</div>")+6 ); 
        }
      */ 
        $xSource = 'https://www.tgspot.co.il/category/software/feed/';
        $src='TGspot'; $t='Technology'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);




        
        
        //9
        /*
        $has_post = strpos($description, 'The post') !== false; 
        if($has_post){
           $description = substr($description,0,strpos($description, "The post") ); 
        } 
        $vowels = array("<p>", "</p>");
        $description=str_replace($vowels, "", $description);
        debka
        */
         $xSource = 'https://www.debka.co.il/feed/';
        $src='debka'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
        //10
        /*
         $has_post = strpos($description, '<a') !== false; 
        if($has_post){
           $description = substr($description,0,strpos($description, "<a") ); 
        } 
        $vowels = array("<p>", "</p>");
        $description=str_replace($vowels, "", $description);
        news-israel
        */
         $xSource = 'http://www.news-israel.net/feed/';
        $src='news-israel'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 





        //11
         /*
        $has_post = strpos($description, '</p>') !== false; 
        if($has_post){
           $description = substr($description,0,strpos($description, "</p>") ); 
        } 
        $vowels = array("<p>", "</p>");
        $description=str_replace($vowels, "", $description);
        */
         $xSource = 'https://www.srugim.co.il/feed';
        $src='srugim'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
        //12
         /*
        $has_post = strpos($description, '</p>') !== false; 
        if($has_post){
           $description = substr($description,0,strpos($description, "</p>") ); 
        } 
        $vowels = array("<p>", "</p>");
        $description=str_replace($vowels, "", $description);
        */
         $xSource = 'https://hwzone.co.il/feed/';
        $src='HWzone'; $t='Technology'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);

        //13
        /*
        $has_post = strpos($description, '</p>') !== false; 
        if($has_post){
           $description = substr($description,0,strpos($description, "</p>") ); 
        } 
        $vowels = array("<p>", "</p>");
        $description=str_replace($vowels, "", $description);
        */
         $xSource = 'http://www.93fm.co.il/feed/';
        $src='93fm'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
      
       //4
         $xSource = 'http://www.themarker.com/cmlink/1.146';
        $src='themarker'; $t='News'; $signe='-';$hours=3;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 

         $xSource = 'https://www.hazofe.co.il/feed/';
        $src='hazofe'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 










/*  
       /*
         $description=$item->description->p;
         $vowels = array("<p>", "</p>");
         $description=str_replace($vowels,"", $description);
         item->picture;
         Behadrei
        */
        $xSource = 'https://www.bhol.co.il/rss/index.xml';
        $src='Behadrei'; $word='enclosurex'; $t='News';$signe='-';$hours=4;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);

     //Geektime kkkk
        $xSource = 'https://www.geektime.co.il/feed/';
        $src='Geektime'; $t='Technology'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
        //inn kkkk
        $xSource = 'https://www.inn.co.il/Rss.aspx';
        $src='inn'; $t='News'; $signe='-';$hours=3;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
    */

 ?> 