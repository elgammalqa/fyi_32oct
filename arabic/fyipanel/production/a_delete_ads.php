<?php   
session_start();   ob_start();   
require_once ('../models/ads.model.php');  
include '../models/user.model.php';    
    if(userModel::islogged("Admin")==true){   
	   if (isset($_GET['id_del'])&&!empty($_GET['id_del'])) { 
	   $id=$_GET['id_del']; 
		    $thumbnail=adsModel::getthumbnail_ads2($id);
		    $pdf=adsModel::getpdf_ads2($id); 
		    $media=adsModel::getmedia_ads($id);  
		     if ($media!='') {  unlink('../../ads/image/'.$media);   }
		     if ($thumbnail!='') {  unlink('../../'.$thumbnail);   }
			 if ($pdf!='') {  unlink('../../ads/pdf/'.$pdf);  }
			 adsModel::delete_ad2($id);    ?>
				<script>
				window.location.replace('a_edit_delete_ads.php');
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