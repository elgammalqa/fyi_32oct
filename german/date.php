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
function getrssfromsource($xSource,$src,$t,$signe,$hours){ 
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
          $d_last=date("Y-m-d H:i:s", strtotime("$sig{$hours} hours", strtotime($d1))); 
          $d_last=strtotime($d_last);  
     }else{
        $d_last=strtotime($d1); 
     }  
    foreach ($xml->channel->item as $item) {  
        $date=getrsstime($item->pubDate);  
        $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date))); 
        $d_insert=strtotime($date); 
        $title=addslashes($item->title);
        $description=addslashes($item->description);
        $link=addslashes($item->link); 
        
 } // foreach 
}else{ 
      foreach ($xml->channel->item as $item) {  
        $title=addslashes($item->title);
        $description=addslashes($item->description);
        $link=addslashes($item->link); 
    $date=getrsstime($item->pubDate);  
    echo $date." ----------- <br>";
     $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date)));  
    
     } // foreach 
} 
}// xsourcefile 

} //status

} //func 

     
 require_once('models/rssModel.php'); 
    //ARD Mediathek 0h
        $xSource = 'https://www.sportschau.de//sportschauindex100~_type-rss.feed';
        $src='ARD Mediathek'; $t='Sports'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 


 ?>