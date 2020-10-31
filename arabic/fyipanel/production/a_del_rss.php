<?php   
session_start();   ob_start();   
require_once ('../models/news_published.model.php');  
include '../models/user.model.php';    
    if(userModel::islogged("Admin")==true){   
	   if (isset($_GET['id_del'])&&!empty($_GET['id_del'])) { 
	   $id=$_GET['id_del'];   
			 news_publishedModel::delete_rss($id);    ?>
				<script>
				window.location.replace('a_delete_rss.php?n=1');
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