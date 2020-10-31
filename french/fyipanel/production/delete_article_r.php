<?php  
session_start();   ob_start();  
include '../models/user.model.php';   
    if(userModel::islogged("Reporter")==true){ 
	   if (isset($_GET['id_del'])&&!empty($_GET['id_del'])) {
	   	include '../models/news.model.php';
	    $article_del=new newsModel();  
	    $target_dir = "../views/image_news/";
	    $mediaa=newsModel::get_media_by_id($_GET["id_del"]); 
		    if ($mediaa!='') {
		    	 unlink($target_dir."".$mediaa);//delete old image 
		    } 
	   $thumbnail=newsModel::get_thumbnail_by_id($_GET["id_del"]);  
	   if ($thumbnail!='') {
	   $th=str_replace("fyipanel/views/thumbnails/", "../views/thumbnails/",$thumbnail);
	   unlink($th);
	   }
	    $article_del->delete_news($_GET["id_del"]);
	    ?> 
    <script> 
		window.location.replace('articles_not_sent.php');
	</script>
 <?php  }

  }else{?> 
 	<script> 
		window.location.replace('index.php');
	</script>
  <?php  } ?> 
