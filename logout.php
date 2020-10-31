<?php 
session_start();   ob_start();    
require_once('models/utilisateurs.model.php');
if(utilisateursModel::islogged()){
$user=new utilisateursModel();
 if (isset($_COOKIE['fyiuser_email'])) {
	 $user->disactive_status($_COOKIE['fyiuser_email']);
     setcookie('fyiuser_pass',$user->getpassword(),time()-3600,"/");
     setcookie('fyiuser_email',$user->getemail(),time()-3600,"/"); 
}else{
$user->disactive_status($_SESSION['user_auth']['user_email']);
 unset($_SESSION['user_auth']); 
}
?> 
<?php } ?>
 <script>
          window.location.replace('home.php');
</script> 