<?php     
session_start();   ob_start();    
require_once ('../../../fyipanel/models/v5.comments.php'); 
require_once ('../../models/utilisateurs.model.php'); 
require_once ('../models/user.model.php');    
    if(userModel::islogged("Admin")==true){      
	   if (isset($_GET['id'])&&!empty($_GET['id'])&&isset($_GET['rank'])&&!empty($_GET['rank'])&&isset($_GET['op'])&&!empty($_GET['op'])) {  
	   		//start rss
	   			if($_GET['op']=="rss"&&$_GET['rank']==1){ 
	   				v5comments::republish_rss_comments($_GET['id']);  
					echo "<script> window.location.replace('a_rss_comments_deleted.php?n=1');</script>";  
			    }else if($_GET['op']=="rss"&&$_GET['rank']==2){  
	   				v5comments::republish_rss_replies($_GET['id']); 
	   				echo "<script> window.location.replace('a_rss_comments_deleted.php?n=1');</script>";  
	   			}  
	   		//end rss  
	   		//start news  
	   			if($_GET['op']=="news"&&$_GET['rank']==1){ 
	   			  v5comments::republish_comments($_GET['id']);  
				  echo "<script> window.location.replace('a_news_comments_deleted.php?n=1');</script>";  
			    }else if($_GET['op']=="news"&&$_GET['rank']==2){  
	   			  v5comments::republish_replies($_GET['id']); 
	   			  echo "<script> window.location.replace('a_news_comments_deleted.php?n=1');</script>";  
	   			} 
	   		//end rss 
	   		//start ads
	   			if($_GET['op']=="ads"&&$_GET['rank']==1){  
	   				v5comments::republish_ads_comments($_GET['id']);  
					echo "<script> window.location.replace('a_ads_comments_deleted.php?n=1');</script>";  
			    }else if($_GET['op']=="ads"&&$_GET['rank']==2){  
	   				v5comments::republish_ads_replies($_GET['id']); 
	   				echo "<script> window.location.replace('a_ads_comments_deleted.php?n=1');</script>";  
	   			}   
			  
    } else{ echo "<script> window.location.replace('index.php'); </script>";  }  
    }else{ echo "<script> window.location.replace('index.php');</script>"; } ?>  