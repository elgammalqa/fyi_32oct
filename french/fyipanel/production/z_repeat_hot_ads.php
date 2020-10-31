<?php  
session_start();   ob_start();    
require_once ('../models/ads.model.php');   
include '../models/user.model.php';    
    if(userModel::islogged("Ads")==true){  
    if (isset($_COOKIE['fyipEmail'])&&!empty($_COOKIE['fyipEmail']))
            $fyipEmail=$_COOKIE['fyipEmail']; 
        else $fyipEmail=$_SESSION['auth']['Email'];   
	   if (isset($_GET['id_rep'])&&!empty($_GET['id_rep'])) { 
	   		$id=$_GET['id_rep']; 
	   		 $query=adsModel::get_data_condition('../views/connect.php','hot_ads','id',$id);
	   		$finDate=0; 
	   		 foreach($query as $news){ 
	   		 	$finDate=$news['finDate'];
	   		 } 
	   		date_default_timezone_set('GMT'); 
            $pubDate=date("Y-m-d H:i:s");
	   		adsModel::repeat_hot_ads('../views/connect.php',$pubDate,$id,$finDate,$fyipEmail);  
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