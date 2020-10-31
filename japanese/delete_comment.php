<?php 
session_start();   ob_start(); 
$cc=0;
include 'models/utilisateurs.model.php';
if (utilisateursModel::islogged()) { 
  include 'models/comments.model.php';
  
   if (isset($_GET['id_c'])&&!empty($_GET['id_c'])&&isset($_GET['id_n'])&&!empty($_GET['id_n'])&&isset($_GET['id'])&&!empty($_GET['id'])&&commentsModel::HisComment($_GET['id_c'],$_GET['id'])==true) { 

	     if (commentsModel::delete_ReportsAndrepliesAndComments($_GET['id_c'])) { ?>
			<script type="text/javascript">
				window.location.replace('detail.php?id=<?php echo $_GET["id_n"]; ?>');
			</script>
			<?php  }else{ 
			 $cc=404;  
			  }   

	   }{ 
	     $cc=403;
	   }// comments 
   

	    if (isset($_GET['id_n'])&&!empty($_GET['id_n'])&&isset($_GET['id_r'])&&!empty($_GET['id_r'])&&isset($_GET['id'])&&!empty($_GET['id'])&&commentsModel::HisReply($_GET['id_r'],$_GET['id'])==true) {

	   	if (commentsModel::delete_ReportsAndreplies($_GET['id_r'])) { ?>
				<script type="text/javascript">
					window.location.replace('detail.php?id=<?php echo $_GET["id_n"]; ?>');
				</script>
		<?php  	}else{ 	$cc=404;  	}  

	    } else{ 	$cc=403;  }

}else{
$cc=403;
 }// is logged

 

  if($cc==404||$cc==403){ ?>
	<script type="text/javascript">
		window.location.replace('<?php echo $cc; ?>.php');
	</script>
 <?php }   ?> 
