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
  include 'models/utilisateurs.model.php'; 
function getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes){ 
    if(utilisateursModel::get_source_status($src,$t)!=null&&utilisateursModel::get_source_status($src,$t)==1){ 
    if (!$xsourcefile = file_get_contents($xSource)) { }else{
    $xml = simplexml_load_string($xsourcefile ); 
    $rss = new rssModel();
    $rss_date = new rssModel();
     include 'fyipanel/views/connect.php' ; 
      $media=""; 
      $photo="";  
 if (rssModel::rrsfeedsbysource($src,$t)>0) { 
     $d1=$rss_date->last_date_rss_all($src,$t);
    if ($hours!=0) {
          if($signe=="+") $sig="-";  else $sig="+";
          $d_last=date("Y-m-d H:i:s", strtotime("$sig{$hours} hours $sig{$mintes} minutes", strtotime($d1))); 
          $d_last=strtotime($d_last);  
     }else{
        $d_last=strtotime($d1); 
     }  
    foreach ($xml->channel->item as $item) {  
        $date=getrsstime($item->pubDate);  
        $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours $signe{$mintes} minutes", strtotime($date))); 
        $d_insert=strtotime($date); 
        $title=addslashes($item->title);
        $description=addslashes($item->description);
        $link=addslashes($item->link); 
        echo 'link : '.$link.'<br>';
        echo 'date from link :'.$date.'<br>'; 
        echo 'date to db :'.$d2.'<br><br><br>';
       if ($d_insert > $d_last){  
         $con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$src', '$media', '$t', '$photo')");
        }
 } // foreach 
}else{ 
      foreach ($xml->channel->item as $item) {  
        $title=addslashes($item->title);
        $description=addslashes($item->description);
        $link=addslashes($item->link); 
    $date=getrsstime($item->pubDate);  
     $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date))); 

        echo 'link : '.$link.'<br>';
        echo 'date from link :'.$date.'<br>'; 
        echo 'date to db :'.$d2.'<br><br><br>'; 
    $con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$src', '$media', '$t', '$photo')");
     } // foreach 
} 
}// xsourcefile 

} //status

} //func 
  

 
function getrsswithmedia($xSource,$src,$t,$word,$signe,$hours,$mintes){  
    if(utilisateursModel::get_source_status($src,$t)!=null&&utilisateursModel::get_source_status($src,$t)==1){ 
    if (!$xsourcefile = file_get_contents($xSource)) { }else{
        $xml2=str_replace($word,'media', $xsourcefile); 
        $photo="";  
        $xml = simplexml_load_string($xml2);  
    $rss = new rssModel();
    $rss_date = new rssModel();    
     include 'fyipanel/views/connect.php';  
 if (rssModel::rrsfeedsbysource($src,$t)>0) { 
     $d1=$rss_date->last_date_rss_all($src,$t);
     if ($hours!=0) {
          if($signe=="+") $sig="-";  else $sig="+";
          $d_last=date("Y-m-d H:i:s", strtotime("$sig{$hours} hours $sig{$mintes} minutes", strtotime($d1))); 
          $d_last=strtotime($d_last);  
     }else{
        $d_last=strtotime($d1); 
     } 
    foreach ($xml->channel->item as $item) {   
        $title=addslashes($item->title); 
        $link=addslashes($item->link); 
        if ($src=="डेली न्यूज") {
             $description=" ";
               $date=$item->pubDate;  
               $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours $signe{$mintes} minutes", strtotime($date)));
               $m=addslashes($item->image);   
        }else{
              $description=addslashes($item->description);
               $m=addslashes($item->media["url"]);   
               $date=getrsstime($item->pubDate);  
               $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours $signe{$mintes} minutes", strtotime($date)));
        }
        $d_insert=strtotime($date);  
       if ($d_insert > $d_last){   
        $con->exec("INSERT INTO `rss` VALUES (NULL, '$item->title' , '$item->description','$item->link', '$d2', '$src', '$m', '$t', '$photo')");
        }
 } // foreach 
}else{  
    foreach ($xml->channel->item as $item) {  
        if ($src=="डेली न्यूज") {
             $description=" ";
               $date=$item->pubDate;  
               $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours $signe{$mintes} minutes", strtotime($date)));
               $m=addslashes($item->image);   
        }else{
              $description=addslashes($item->description);
               $m=addslashes($item->media["url"]);   
               $date=getrsstime($item->pubDate);  
               $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours $signe{$mintes} minutes", strtotime($date)));
        }
        $title=addslashes($item->title); 
        $link=addslashes($item->link); 
          $con->exec("INSERT INTO `rss` VALUES (NULL, '$title' , '$description','$link', '$d2', '$src','$m', '$t', '$photo')");
    } // foreach 
}  
}// xsourcefile 

} //status

} //func 


try{   
     require_once('models/rssModel.php'); 
     
     // without media 
      

      //अमर उजाला
       $xSource = 'https://www.amarujala.com/rss/india-news.xml';
        $src='अमर उजाला'; $t='News'; $signe='-';$hours=5; $mintes=30;
        getrssfromsource($xSource,$src,$t,$signe,$hours,$mintes); 
        
 
    
  require_once ('ads.php'); 
          ?>
 <div style="font-size: 40px; color: green; margin-left: 20%;margin-top: 20% "  >
    <span style='font-size: 60px; color: black;' > Updated On : </span>
    <?php echo date("Y-m-d H:i:s");  ?>
</div> 

 <?php 
}catch(Exception $e){ }  ?>  