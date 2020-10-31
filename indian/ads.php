<?php   
require_once ('fyipanel/models/ads.model.php'); 
$files = glob('ads/image/*'); 
							    date_default_timezone_set('GMT');
								foreach($files as $file) {
								     $lastslash=strrpos($file,"/");  
								     $f=substr ($file,($lastslash+1)); 
									$ft=adsModel::getfinDates($f);
									$id=adsModel::getid_ads($f);   
									$thumbnail=adsModel::getthumbnail_ads($id);
									$pdf=adsModel::getpdf_ads($id); 
								    if ((time() - filectime($file)) > $ft) {  
								     if (adsModel::delete_ad($id)) {
								      	  unlink($file); 
								      	  if ($thumbnail!='') {
								      	      unlink($thumbnail); 
								      	  }
								      	   if ($pdf!='') {
								      	      unlink('ads/pdf/'.$pdf); 
								      	  }
								      	   
								       }    
								    }    
								} 
 ?>