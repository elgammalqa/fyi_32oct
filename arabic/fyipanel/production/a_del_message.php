<?php    
session_start();   ob_start();     
require_once ('../../../fyipanel/models/v5.comments.php');  
require_once ('../models/user.model.php');   
    if(userModel::islogged("Admin")==true){  
	   if (isset($_GET['id_del'])&&!empty($_GET['id_del'])&&isset($_GET['op'])&&!empty($_GET['op'])) { 
	   		//start ads
	   			if($_GET['op']=="message"){
	   				if (v5comments::delete_message($_GET['id_del'])) {  ?>
						<script type="text/javascript">
							window.location.replace('a_messages.php?n=1');
						</script>
			<?php  	}
	   			}    
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