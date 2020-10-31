<?php  
require_once('models/utilisateurs.model.php');
require_once('fyipanel/models/user.model.php');
 ?> 
 <style type="text/css">
@media (min-width: 992px) { 
	#pl1{
		padding-left: 30% ; 
	} 
}
</style>
<?php 
	function redirect() {
		header('Location: fyipanel/production/forget_password.php');
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
			utilisateursModel::update_token_pass_whitout_conf_user($email,$pass); ?>
	  <br><br><br><br> 
	  <span id="pl1" style="font-size: 30px; " >  Your New Password Is 
	  	<span style="color: green" >
	  		<input style="font-size: 25px; " value="<?php echo $newPassword; ?>">
	  	</span> 
	  </span>
	   <br><br> 
	   <span id="pl1"style="font-size: 30px; ">
	         <a target="_blank" href="fyipanel/production/index.php">Click Here To Log In</a>
	   </span>  
	<?php	} else{
			redirect();
		} } 
?>
