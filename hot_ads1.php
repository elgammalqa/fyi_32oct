<?php 
stop_hot_ad1('arabic');
stop_hot_ad1('chinese');
stop_hot_ad1('french');
stop_hot_ad1('german');
stop_hot_ad1('hebrew');
stop_hot_adEn(); 
  
function stop_hot_ad1($lang){   
	date_default_timezone_set('GMT');
	$files = glob($lang.'/hot_ads/media/*');  
		foreach($files as $file) {
		 	$lastslash=strrpos($file,"/");  
		 	$f=substr ($file,($lastslash+1));  
		 	$ad_exist=false;
		 	$variable=get_data_condition($lang.'/fyipanel/views/connect.php','hot_ads','media',$f);
		 	foreach ($variable as $key => $value) {
		 		$ad_exist=true;
		 		$id=$value['id']; 
		 		$ft=$value['finDate'];
		 		$thumbnail=$value['thumbnail']; 
		 	}
		 	if($ad_exist){  
			 	if ((time() - filectime($file)) > $ft) {  
				     stop_ad($lang.'/fyipanel/views/connect.php',$id);  
				} 
			}   
	} //files 
}

function stop_hot_adEn(){ 
	require_once ('fyipanel/models/ads.model.php');  
	date_default_timezone_set('GMT');
	$files = glob('hot_ads/media/*');  
		foreach($files as $file) {
		 	$lastslash=strrpos($file,"/");  
		 	$f=substr ($file,($lastslash+1));  
		 	$ad_exist=false;
		 	$variable=get_data_condition('fyipanel/views/connect.php','hot_ads','media',$f);
		 	foreach ($variable as $key => $value) {
		 		$ad_exist=true;
		 		$id=$value['id']; 
		 		$ft=$value['finDate'];
		 		$thumbnail=$value['thumbnail']; 
		 	}
		 	if($ad_exist){  
			 	if ((time() - filectime($file)) > $ft) {  
				     stop_ad('fyipanel/views/connect.php',$id);  
				} 
			}   
	} //files 
}
 


function stop_ad($link,$id){
  try {
    	include($link); 
    	$con->exec("UPDATE hot_ads set status=0 where id='".$id."' "); 
    	$con->exec("DELETE FROM times_hot_ads where id_add='".$id."'");
    	return true;
  } catch (PDOException $e) {
         return false;
  }     
}


function get_data_condition($link,$table,$cond,$value){  
    include($link); $tab = array();      
    $query=$con->query('select * from '.$table.' where '.$cond.'="'.$value.'" ');
    while ($data = $query->fetch())  $tab[] = $data;  
    return $tab; 
} 
 ?>