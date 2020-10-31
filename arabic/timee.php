<?php  
  function  comments_time($d){
	$c='';
date_default_timezone_set('GMT');
$time2=date("Y-m-d H:i:s");    
$time1=$d;   
$nb = round((strtotime($time2) - strtotime($time1)),1);
$nbseconds = floor($nb); 
if ($nbseconds>=0) {
	if ($nbseconds<=59) {
	 //seconds
	if($nbseconds==0) $n=1;
	else $n=$nbseconds;
	if($n<=1) $c= "قبل ثانية";
	else if($n<=2) $c= " قبل ثانيتين";
    else if($n<11) $c="   قبل   ".$n. " ثواني   " ;
    else   $c= "   قبل   ".$n. "  ثانية   " ;
}else if (round(($nbseconds/60))<60) {
	//minutes
	$n=round(($nbseconds/60),1) ;
	if($n<2) $c= "قبل دقيقة";
	else if($n<3) $c= "قبل دقيقتين";
    else if($n<11) $c="   قبل   ".floor($n)."  دقائق   ";
    else  $c= "   قبل   ".floor($n)."  دقيقة  ";
}else if (round(($nbseconds/3660),1)<24) {
	//hours 
	$n=round(($nbseconds/3660),1);
	  if($n<2) $c= "قبل ساعة ";
	   else if($n<3) $c= "قبل ساعتين"; 
	   else if($n<11) $c= "   قبل   ".floor($n)."  ساعات  ";
	    else $c= "   قبل   ".floor($n)."   ساعة   ";
}else if (round(($nbseconds/86400),1)<7) {
	//day  
	$n= round(($nbseconds/86400),1) ;
	if($n<2) $c= "قبل يوم";
	else if($n<3) $c= "قبل يومين";  
    else $c= "   قبل   ".floor($n)."  ايام  ";

}else if (round(($nbseconds/604800),1)<4) {
	//weeks  
	$n=round(($nbseconds/604800),1);
	if($n<2) $c= " قبل اسبوع  ";
	else if($n<3) $c= " قبل  اسبوعين ";
    else $c="   قبل   ".floor($n)."   اسابيع  ";
}else if (round(($nbseconds/2629800),1)<12) {
	//month  
	$n= round(($nbseconds/2629800),1) ;
	if($n<2) $c= "قبل شهر";
	else if($n<3) $c= "قبل شهرين";
	else if($n<11) $c="   قبل   ".floor($n)."   اشهر   ";
    else $c="   قبل   ".floor($n)."   شهر  ";
}else {
	//years  
	$n= round(($nbseconds/31557600),1);
	if($n<2) $c= " قبل سنة ";
	else if($n<3) $c= "قبل سنتين";
	else if($n<11) $c="   قبل   ".floor($n)."   سنوات   ";
    else $c= "   قبل   ".floor($n)."   سنة   ";
} 
}else{
	$c='Err';
}

 return $c;
}









 function  news_time($d){
	$c='';
date_default_timezone_set('GMT');
$time2=date("Y-m-d H:i:s");    
$time1=$d;   
$nb = round((strtotime($time2) - strtotime($time1)),1);
$nbseconds = floor($nb); 
if ($nbseconds>=0) {
	 if ($nbseconds<=59) {
	 //seconds
	if($nbseconds==0) $n=1;
	else $n=$nbseconds;
	if($n<=1) $c= "قبل ثانية";
	else if($n<=2) $c= " قبل ثانيتين";
    else if($n<11) $c="   قبل   ".$n."  ثواني   ";
    else   $c="   قبل   ".$n."  ثانية  ";
}else if (round(($nbseconds/60))<60) {
	//minutes
	$n=round(($nbseconds/60),1) ;
	if($n<2) $c= "قبل دقيقة";
	else if($n<3) $c= "قبل دقيقتين";
    else if($n<11) $c="   قبل   ".floor($n)."  دقائق   ";
    else  $c= "   قبل   ".floor($n)."  دقيقة  ";
}else if (round(($nbseconds/3660),1)<24) {
	//hours 
	$n=round(($nbseconds/3660),1);
	  if($n<2) $c= "قبل ساعة ";
	   else if($n<3) $c= "قبل ساعتين"; 
	   else if($n<11) $c= "   قبل   ".floor($n)."   ساعات  ";
	    else $c= "   قبل   ".floor($n)."   ساعة   ";
}else if (round(($nbseconds/86400),1)<7) {
	//day  
	$n= round(($nbseconds/86400),1) ;
	if($n<2) $c= "قبل يوم";
	else if($n<3) $c= "قبل يومين";  
    else $c= "   قبل   ".floor($n)."   ايام  ";

}else if (round(($nbseconds/604800),1)<4) {
	//weeks  
	$n=round(($nbseconds/604800),1);
	if($n<2) $c= " قبل اسبوع  ";
	else if($n<3) $c= " قبل  اسبوعين ";
    else $c= "   قبل   ".floor($n)."  اسابيع  ";
} else {
	//?????  
	$c= "date";
} 
}else{
	$c='Err';
}

 return $c;
}
 






 function  real_news_time($d){
 	$cc=news_time($d);
 	if($cc=="date"||$cc=="Err"){
 			echo $d;
 	}else{
 			echo $cc;
 	}
 } 

 

 function  news_time_without_before($d){
	$c='';
date_default_timezone_set('GMT');
$time2=date("Y-m-d H:i:s");    
$time1=$d;   
$nb = round((strtotime($time2) - strtotime($time1)),1);
$nbseconds = floor($nb); 
if ($nbseconds>=0) {
	 if ($nbseconds<=59) {
	 //seconds
	if($nbseconds==0) $n=1;
	else $n=$nbseconds;
	if($n<=1) $c= "ق انية";
	else if($n<=2) $c= "ثانيتين";
    else if($n<11) $c=$n."  ثواني   ";
    else   $c=$n."  ثانية  ";
}else if (round(($nbseconds/60))<60) {
	//minutes
	$n=round(($nbseconds/60),1) ;
	if($n<2) $c= "دقيقة";
	else if($n<3) $c= " دقيقتين";
    else if($n<11) $c=floor($n)."  دقائق   ";
    else  $c= floor($n)."  دقيقة  ";
}else if (round(($nbseconds/3660),1)<24) {
	//hours 
	$n=round(($nbseconds/3660),1);
	  if($n<2) $c= "ساعة ";
	   else if($n<3) $c= "ساعتين"; 
	   else if($n<11) $c= floor($n)."   ساعات  ";
	    else $c=  floor($n)."   ساعة   ";
}else if (round(($nbseconds/86400),1)<7) {
	//day  
	$n= round(($nbseconds/86400),1) ;
	if($n<2) $c= "يوم";
	else if($n<3) $c= "يومين";  
    else $c= floor($n)."   ايام  ";

}else if (round(($nbseconds/604800),1)<4) {
	//weeks  
	$n=round(($nbseconds/604800),1);
	if($n<2) $c= " اسبوع  ";
	else if($n<3) $c= "  اسبوعين ";
    else $c=floor($n)."  اسابيع  ";
} else {
	//?????  
	$c= "date";
} 
}else{
	$c='Err';
}

 return $c;
}
 


 function  real_news_time_without_before($d){
 	$cc=news_time_without_before($d);
 	if($cc=="date"||$cc=="Err"){
 			echo $d;
 	}else{
 			echo $cc;
 	}
 } 
 function  real_comments_time($d){
 	$cc=comments_time($d);
 	if($cc=="Err"){
 			echo $d;
 	}else{
 			echo $cc;
 	}
 }

 function current_lang(){ 
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
if(isset($_COOKIE['current_language'])){  
	if($actual_link!=$_COOKIE['current_language']){
		setcookie('current_language',$actual_link,time()+31104000,"/");
	}
}else{
	setcookie('current_language',$actual_link,time()+31104000,"/");
}
 }
 

?>