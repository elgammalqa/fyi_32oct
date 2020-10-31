<?php 
session_start();   ob_start();   
require_once('models/utilisateurs.model.php');
require_once('fyipanel/models/user.model.php'); 
 ?>
 <style type="text/css">
@media (min-width: 992px) { 
	#pl1{
		padding-left: 20% ;
	} 
} 
</style>
<?php
	function redirect() {
		header('Location: fyipanel/production/index.php');
		exit();
	} 
	if (!isset($_GET['email']) || !isset($_GET['token'])) {
		redirect();
	} else {  
		$email = strip_tags($_GET['email']);
		$token = strip_tags($_GET['token']);     
		if (userModel::email_token_exist($email,$token)) {  
			$newPassword = userModel::generateNewString();
			$pass = password_hash($newPassword, PASSWORD_DEFAULT);  
			utilisateursModel::update_token_pass_user($email,$pass); ?>
	  <br><br><br><br>  
	  <span id="pl1" style="font-size: 30px; " > 您的电子邮件已经过验证！ 你的密码是 
	  	<span style="color: green" >
	  		<input style="font-size: 25px; " value="<?php echo $newPassword; ?>"> </span> 
	  </span>
	   <br><br> 
	   <span  style="font-size: 30px ; padding-left: 30%">
	         <a target="_blank" href="fyipanel/production/index.php">点击此处登录</a>
	   </span>  
	<?php	} else{
			redirect();
		}
	}
?>
