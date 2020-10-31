<?php     
session_start();   ob_start();      
require_once ('../../../fyipanel/models/v5.comments.php'); 
require_once ('../../models/utilisateurs.model.php'); 
require_once ('../models/user.model.php');   
    if(userModel::islogged("Admin")==true){      
    	 
	   if (isset($_GET['id_del'])&&!empty($_GET['id_del'])&&isset($_GET['rank'])&&!empty($_GET['rank'])&&isset($_GET['op'])&&!empty($_GET['op'])) {  
	   		//start ads
	   			if($_GET['op']=="ads"&&$_GET['rank']==1){
	   				v5comments::copy_ads_comments_replies($_GET['id_del']);
	   				if (v5comments::delete_Comments_ad($_GET['id_del'])) {  ?>
						<script type="text/javascript">
							window.location.replace('a_delete_ads_comments.php?n=1');
						</script>
			<?php  	}
	   			}else if($_GET['op']=="ads"&&$_GET['rank']==2){  
	   				v5comments::copy_ads_replies($_GET['id_del']);
	   				if (v5comments::delete_replies_ad($_GET['id_del'])) {  ?>
						<script type="text/javascript">
							window.location.replace('a_delete_ads_comments.php?n=1');
						</script>  
			<?php  	}
	   			}else if($_GET['op']=="ads"&&$_GET['rank']==3){
	   				if (utilisateursModel::delete_user_And_His_comments($_GET['id_del'])) {  ?>
						<script type="text/javascript">
							window.location.replace('a_delete_ads_comments.php?n=1');
						</script>
			<?php  	}
	   			}
	   		//end ads 

  
	   		//start news
	   			if($_GET['op']=="news"&&$_GET['rank']==1){
	   				v5comments::copy_comments_replies($_GET['id_del']);
	   				if (v5comments::delete_Comments_news($_GET['id_del'])) {  ?>
						<script type="text/javascript">
							window.location.replace('a_delete_news_comments.php?n=1');
						</script>
			<?php  	}
	   			}else if($_GET['op']=="news"&&$_GET['rank']==2){
	   				v5comments::copy_replies($_GET['id_del']);
	   				if (v5comments::delete_replies_news($_GET['id_del'])) {  ?>
						<script type="text/javascript">
							window.location.replace('a_delete_news_comments.php?n=1');
						</script> 
			<?php  	}
	   			}else if($_GET['op']=="news"&&$_GET['rank']==3){
	   				if (utilisateursModel::delete_user_And_His_comments($_GET['id_del'])) {  ?>
						<script type="text/javascript">
							window.location.replace('a_delete_news_comments.php?n=1');
						</script>
			<?php  	}
	   			}
	   		//end news 
 

	   		//start rss
	   			if($_GET['op']=="rss"&&$_GET['rank']==1){ 
	   				v5comments::copy_rss_comments_replies($_GET['id_del']);
	   				if (v5comments::delete_Comments_rss($_GET['id_del'])) {  ?>
						  <script type="text/javascript">
							window.location.replace('a_delete_rss_comments.php?n=1');
						</script>  
			<?php  	}
	   			}else if($_GET['op']=="rss"&&$_GET['rank']==2){  
	   				v5comments::copy_rss_replies($_GET['id_del']);
	   				if (v5comments::delete_replies_rss($_GET['id_del'])) {  ?>
						<script type="text/javascript">
							window.location.replace('a_delete_rss_comments.php?n=1');
						</script> 
			<?php  	}
	   			}else if($_GET['op']=="rss"&&$_GET['rank']==3){
	   				if (utilisateursModel::delete_user_And_His_comments($_GET['id_del'])) {  ?>
						<script type="text/javascript">
							window.location.replace('a_delete_rss_comments.php?n=1');
						</script>
			<?php  	}
	   			}
	   		//end rss  
			  
      } else{?>  
            <script>
				window.location.replace('index.php');
			</script>
<?php  }  
    }else{?>  
            <script>
				window.location.replace('index.php');
			</script>
<?php  } ?>    
  