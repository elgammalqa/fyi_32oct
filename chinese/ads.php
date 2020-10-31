<?php    //l5
		require_once ('fyipanel/models/ads.model.php'); 
		$files = glob('ads/image/*'); 
		date_default_timezone_set('GMT');
		   
		foreach($files as $file) {
			 $lastslash=strrpos($file,"/");  
			 $f=substr ($file,($lastslash+1)); 
		 	 $variable=adsModel::get_data_condition('fyipanel/views/connect.php','ads','media',$f);
			 foreach ($variable as $key => $value) {
				$id=$value['id'];
				$ft=$value['finDate'];
				$thumbnail=$value['thumbnail']; 
				$pdf=$value['pdf']; 
			 }    

			if ((time() - filectime($file)) > $ft) { 
			    if (adsModel::delete('fyipanel/views/connect.php','ads','id',$id)>0) {  
			    	if(file_exists($file)) unlink($file); 
			    	if ($thumbnail!='') { 
			    		if(file_exists($thumbnail)) unlink($thumbnail);    
			    	}
					if ($pdf!='') {  
						if(file_exists('ads/pdf/'.$pdf))  unlink('ads/pdf/'.$pdf);    
					} 
				}    
			}    
		}  
  

?>