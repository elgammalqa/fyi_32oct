<?php 
session_start();   ob_start();   
ob_start();
include '../models/user.model.php';
if (isset($_COOKIE['fyipFunction'])&&!empty($_COOKIE['fyipFunction'])){
	$f=$_COOKIE['fyipFunction'];
}else if(isset($_SESSION['auth']['Function'])&&!empty($_SESSION['auth']['Function'])){
   $f=$_SESSION['auth']['Function'];	
}

if(userModel::islogged($f)){
$user=new userModel();
if (isset($_COOKIE['fyipEmail'])&&!empty($_COOKIE['fyipEmail'])){
	$user->disactive_status($_COOKIE['fyipEmail']);
	setcookie('fyipPassword',"a",time()-3600,"/");
    setcookie('fyipEmail',"a",time()-3600,"/");    
    setcookie('fyipFunction',"a",time()-3600,"/");    
    setcookie('fyipPhoto',"a",time()-3600,"/");    
    setcookie('fyipFirst_name',"a",time()-3600,"/");
    setcookie('fyipLast_name',"a",time()-3600,"/");
    setcookie('fyiplien',"a",time()-3600,"/");
    setcookie('fyiplock',"a",time()-3600,"/");
     
	}else if(isset($_SESSION['auth']['Email'])&&!empty($_SESSION['auth']['Email'])){
		$user->disactive_status($_SESSION['auth']['Email']);
         unset($_SESSION['auth']);
	}

}  
?>
 <script>
          window.location.replace('index.php');
</script> 