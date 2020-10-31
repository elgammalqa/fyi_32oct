<?php 
session_start();   ob_start();    
include '../../models/utilisateurs.model.php';
include '../models/user.model.php';
if (userModel::islogged("Admin")) { 
  include '../../models/reports.model.php'; 

   if (isset($_GET['id_comment'])&&!empty($_GET['id_comment'])) {  
	     if (reportModel::delete_Comments_ad($_GET['id_comment'])) {  ?>
			<script type="text/javascript">
				window.location.replace('reports_rss.php');
			</script>
			<?php  	}}  


	   // reply
	    if (isset($_GET['id_reply'])&&!empty($_GET['id_reply'])) { 
	   	if (reportModel::delete_replies_ad($_GET['id_reply'])) { ?>
				<script type="text/javascript">
					window.location.replace('reports_rss.php');
				</script>
		<?php  	}}   


	     // report
	    if (isset($_GET['id_r'])&&!empty($_GET['id_r'])) { 
	   	if (reportModel::delete_Reports($_GET['id_r'])) { ?>
				<script type="text/javascript">
					window.location.replace('reports_rss.php');
				</script>
		<?php  }}


		   // user abuse cr
	    if (isset($_GET['id_cr'])&&!empty($_GET['id_cr'])) { 
	   	if (utilisateursModel::delete_user_And_His_comments($_GET['id_cr'])) { ?>
				<script type="text/javascript">
					window.location.replace('reports_rss.php');
				</script>
		<?php  }}



		   // user abuse cr
	    if (isset($_GET['id_v'])&&!empty($_GET['id_v'])) { 
	   	if (utilisateursModel::delete_user_And_His_comments($_GET['id_v'])) { ?>
				<script type="text/javascript">
					window.location.replace('reports_rss.php');
				</script>
		<?php  }}

       }// logged
		 ?> 
	<script type="text/javascript">
		window.location.replace('reports_rss.php');
	</script>
 
