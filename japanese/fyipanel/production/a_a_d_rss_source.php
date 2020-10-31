<?php   
session_start();   ob_start();   
require_once ('../models/news_published.model.php');  
include '../models/user.model.php';     
    if(userModel::islogged("Admin")==true){    
	   if(isset($_POST['maj'])&&isset($_POST['id'])&&isset($_POST['status'])) { 
      		if($_POST['status']==1) $st=0; else $st=1;
      		 news_publishedModel::update_rss_sources($st,$_POST['id']);
      		 echo "<script >  window.location.replace('a_activate_rss_source.php'); </script>";
      	 
    } else{   
            echo "<script> window.location.replace('index.php'); </script>";
   }  
    }else{   
           echo  "<script> window.location.replace('index.php'); </script>";
  } ?>  