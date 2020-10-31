<?php 
session_start();   ob_start(); 
include '../models/user.model.php'; 
include '../../models/utilisateurs.model.php';  
  if(userModel::islogged("Admin")==true){  
    $user_del=new utilisateursModel();  
   if ($user_del->delete_user_And_His_comments($_GET["id"])) {?>
    <script>
window.location.replace('delete_users.php');
</script>
  <?php }else{ ?> 
  	 <script>
window.location.replace('../../404.php');
</script>
<?php }} ?> 

 <script>
window.location.replace('../../404.php');
</script>
