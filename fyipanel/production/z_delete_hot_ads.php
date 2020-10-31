<?php   
session_start();   ob_start();   
require_once ('../models/ads.model.php');  
include '../models/user.model.php';    
    if(userModel::islogged("Ads")==true){   
	   if (isset($_GET['id_del'])&&!empty($_GET['id_del'])) { 
	   		$id=$_GET['id_del']; 
	   		$variable=adsModel::get_data_condition('../views/connect.php','hot_ads','id',$id);
			foreach ($variable as $key => $value) {  
				$thumbnail=$value['thumbnail']; 
				$media=$value['media']; 
			 }     
		     if ($media!='') {  
		     	if(file_exists('../../hot_ads/media/'.$media)) unlink('../../hot_ads/media/'.$media);   
		     }
		     if ($thumbnail!='') {  
		     	if(file_exists('../../hot_ads/thumbnail/'.$thumbnail)) unlink('../../hot_ads/thumbnail/'.$thumbnail);   
		     }  
		     adsModel::delete('../views/connect.php','hot_ads','id',$id);
		    ?>
				<script>
				window.location.replace('z_edit_delete_hot_ads.php');
				</script> 
 <?php  } else{?>  
            <script>
				window.location.replace('index.php');
			</script>
<?php  }  
    }else{?>  
            <script>
				window.location.replace('index.php');
			</script>
<?php  } ?>  