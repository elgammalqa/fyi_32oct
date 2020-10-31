<?php  
session_start();   ob_start();  
include '../models/user.model.php';   
    if(userModel::islogged("Head of Branch")==true){ 
	   if (isset($_GET['id_del'])&&!empty($_GET['id_del'])) {
		   	include '../models/news_published.model.php';
		    $article_del=new news_publishedModel();  
		    $target_dir = "../views/image_news/";
	        $mediaa=news_publishedModel::get_media_by_id($_GET["id_del"]); 
			    if ($mediaa!='') {
			    	 unlink($target_dir."".$mediaa);//delete old image 
			    }  
		        $article_del->delete_news_published($_GET["id_del"]); ?>
				<script>
				window.location.replace('h_dnp.php');
				</script>
 <?php  }
    }else{?>  
            <script>
				window.location.replace('index.php');
			</script>
<?php  } ?>  