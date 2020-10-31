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
	if($n<=1) $c= "до ".$n." секунды ";
    else $c= "до ".$n." секунд ";
}else if (round(($nbseconds/60))<60) {
	//минуты 
	$n=round(($nbseconds/60),1) ;
	if($n<=1) $c= "до ".ceil($n)." Минута  ";
	else if($n<2) $c= "до ".floor($n)." Минута  "; 
    else $c= "до ".floor($n)." минуты  ";
}else if (round(($nbseconds/3660),1)<24) {
	//часов 
	$n=round(($nbseconds/3660),1);
	  if($n<=1) $c= "до ".ceil($n)." Час  ";
	else if($n<2) $c= "до ".floor($n)." Час  "; 
	    else $c= "до ".floor($n)." часов ";
}else if (round(($nbseconds/86400),1)<=10) {
	//дни  
	$n= round(($nbseconds/86400),1) ;
	if($n<=1) $c= "до ".ceil($n)." День  ";
	else if($n<2) $c= "до ".floor($n)." День  "; 
    else $c= "до ".floor($n)." дни ";

}else   {
	 $c= "date";
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
	if($n<=1) $c= "до ".$n." секунды "; 
    else $c= "до ".$n." секунд ";
}else if (round(($nbseconds/60))<60) {
	//минуты 
	$n= round(($nbseconds/60),1);
	if($n<=1) $c= "до ".ceil($n)." Минута  ";
	else if($n<2) $c= "до ".floor($n)." Минута  ";
    else $c= "до ".floor($n)." минуты  ";
}else if ( round(($nbseconds/3660),1)<24) {
	//часов   
	$n= round(($nbseconds/3660),1); 
	if($n<=1) $c= "до ".ceil($n)." Час  ";
	else if($n<2) $c= "до ".floor($n)." Час  ";
    else $c= "до ".floor($n)." часов ";
}else if (round(($nbseconds/86400),1)<7) {
	//дни  
	$n=round(($nbseconds/86400),1); 
	if($n<=1) $c= "до ".ceil($n)." День  ";
	else if($n<2) $c= "до ".floor($n)." День  ";
    else $c= "до ".floor($n)." дни ";

} else {
	//years  
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
 			echo $d." GMT";
 	}else{
 			echo $cc;
 	}
 } 
 function  real_comments_time($d){
 	$cc=comments_time($d);
 	if($cc=="Err"){
 			echo $d." GMT";
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