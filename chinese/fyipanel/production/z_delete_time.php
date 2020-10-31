<?php  
session_start();   ob_start();   
require_once ('../models/ads.model.php');  
include '../models/user.model.php';    
    if(userModel::islogged("Ads")==true){   
	   if (isset($_GET['id'])&&!empty($_GET['id']) && isset($_GET['id_time'])&&!empty($_GET['id_time'])) { 
	   		$id_time=$_GET['id_time'];  $id=$_GET['id'];  
		    adsModel::delete('../views/connect.php','times_hot_ads','id',$id_time);
?> 	 
	<script> window.location.replace('z_add_time_hot_ads.php?id=<?php echo $id; ?>'); </script> 

 <?php  } else{
 		      echo "<script> window.location.replace('index.php'); </script>";
 		}  
    }else{
    	     echo "<script> window.location.replace('index.php'); </script>";
    } ?>  