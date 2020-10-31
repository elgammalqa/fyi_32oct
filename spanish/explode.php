<?php 
$d="Sat, 13 Oct 2018 07:52:28 -0400"; 
$parts=explode(' ',$d);  
$month=$parts[2];  
$monthreal=getmonth($month);
$time=explode(':',$parts[4]);  
$date="$parts[3]-$monthreal-$parts[1] $time[0]:$time[1]:$time[2]";
     echo $date;


     function getmonth($month){
   if($month=="Jan") $monthreal=1; if($month=="Feb") $monthreal=2; if($month=="Mar") $monthreal=3;
    if($month=="Apr") $monthreal=4;  if($month=="May") $monthreal=5;  if($month=="Jun") $monthreal=6;
    if($month=="Jul") $monthreal=7;  if($month=="Aug") $monthreal=8; if($month=="Sep") $monthreal=9;
     if($month=="Oct") $monthreal=10;  if($month=="Nov") $monthreal=11; if($month=="Dec") $monthreal=12; 
     return $monthreal;
     }
 ?>