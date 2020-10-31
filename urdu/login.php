<?php 
session_start();   ob_start();    
ob_start();
require_once('models/utilisateurs.model.php');
if(utilisateursModel::islogged())
$log=true;
else $log=false;
 ?>
<!DOCTYPE html>
<html>
	<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		    <link rel="icon"   href="images/fyipress.ico">
		<!-- Bootstrap -->
		<link rel="stylesheet" href="../scripts/bootstrap/bootstrap.min.css">
		<!-- IonIcons -->
		<link rel="stylesheet" href="../scripts/ionicons/css/ionicons.min.css">
		<!-- Toast -->
		<link rel="stylesheet" href="../scripts/toast/jquery.toast.min.css">
		<!-- OwlCarousel -->
		<link rel="stylesheet" href="../scripts/owlcarousel/dist/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="../scripts/owlcarousel/dist/assets/owl.theme.default.min.css">
		<!-- Magnific Popup -->
		<link rel="stylesheet" href="../scripts/magnific-popup/dist/magnific-popup.css">
		<link rel="stylesheet" href="../scripts/sweetalert/dist/sweetalert.css">
		<!-- Custom style -->
		<link rel="stylesheet" href="../css/style.css">
		<link rel="stylesheet" href="../css/style2.css">
		<link rel="stylesheet" href="../css/skins/all.css">
		<link rel="stylesheet" href="../css/demo.css">
		<link rel="stylesheet" href="fyipanel/production/css/sweetalert.css">
	 
		<script type="text/javascript" src="fyipanel/production/js/sweetalert-dev.js" ></script>
		<style type="text/css">
			.float_right{
				text-align: right  ! important ;
			}
		</style>
	</head>

	<body class="skin-orange">
		 <?php require_once ("header.php"); ?> 
		<section class="login first grey">
			<div class="container">
				<div class="box-wrapper">				
					<div class="box box-border">
						<div class="box-body">
							<h4 style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" class="float_right">تسجيل الدخول</h4>
							<form method="post" >
								<div style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" class="form-group float_right">
									<label >: ای میل</label>
									<input style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; text-align: center;" placeholder="أدخل بريدك الالكتروني" required="required" type="email" name="username" class="form-control float_right">
								</div>
								<div style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" class="form-group float_right"> 
									<label >: پاس ورڈ</label>
									<input style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; text-align: center;" placeholder="أدخل كلمة المرور" required="required" 
									type="password" name="password" class="form-control float_right">
									<a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="forgot.php"  >نسيت كلمة المرور</a>
									<!-- href="forgot.php" -->
								</div>
								<br>
								<div class="form-group ">
									<button style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; text-align: center;" style="" name="login" class="btn btn-primary btn-block">دخول</button>
								</div>
								<div style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; text-align: center;" class="form-group "  >
									<span  class="text-muted ">آپ کے پاس اکاؤنٹ نہیں ہے ؟</span><a href="register.php">أنشئ حساب</a><br>
									<span class="text-muted">لنک نہیں مل سکا<br>
									</span> <a href="link_verification.php">دوبارہ بھیجیں</a>
								</div>  
							</form>  
          <?php $user=new utilisateursModel();     
  if(isset($_POST['login'])){    
                $password=strip_tags($_POST['password']);
                $logg=strip_tags($_POST['username']);  
            if($user->Function_userexist2($logg)!=null){
                    if (password_verify($password,$user->getpassword())) {
                    if (utilisateursModel::acount_is_confirmed($_POST['username'])) {  
	                      	  if (count($_COOKIE)>0) { 
	                      	  setcookie('fyiuser_pass',$user->getpassword(),time()+31104000,"/");
	                      	  setcookie('fyiuser_email',$logg,time()+31104000,"/");// 1 year     
	                      	  $user->active_status($logg);

                                    if(isset($_SESSION['reply_url'])){
                                        ?>
                                        <script> window.location = "<?=$_SESSION['reply_url']?>"; </script>
                                    <?php
                                    }
                                    else{
                                    ?>
                                        <script> window.location.replace('index.php'); </script>
                                    <?php
                                    }

	                      	 	}
	                      	  else{
                                    if(isset($_SESSION['reply_url'])){
                                    ?>
                                  <script> window.location = "<?=$_SESSION['reply_url']?>"; </script>
                              <?php
                              }
                              else{
                              $_SESSION['user_auth']=array('user_pass'=>$user->getpassword(),'user_email'=>$logg);
                              $user->active_status($logg);
                              ?>
                                  <script> window.location.replace('index.php'); </script>
                                  <?php
                              }
	                      	 } //cookies
	                      	 }else{
								   echo '<script> swal(" ردعمل! "،" براہ مہربانی اپنا ای میل چیک کریں، ہم نے ایک توثیقی پیغام بھیجا ہے یا آپ کو بھیجنے کے لئے بھیجا گیا ہے  
								   ","warning");</script>';
	                      	 }  

                    }else{ ?>
                      <script> swal("Access denied!","ای میل یا پاس ورڈ غلطی، دوبارہ کوشش کریں","warning");</script>
             <?php  }
            }else{ ?>
                  <script> swal("ای میل یا پاس ورڈ غلطی، دوبارہ کوشش کریں","warning");</script>
      <?php }  
    } ?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Start footer -->
		<?php require_once ('footer.php') ?>
		<!-- End Footer -->
		<!-- JS -->
		<script src="../js/jquery.js"></script>
		<script src="../js/jquery.migrate.js"></script>
		<script src="../scripts/bootstrap/bootstrap.min.js"></script>
		<script>var $target_end=$(".best-of-the-week");</script>
		<script src="../scripts/jquery-number/jquery.number.min.js"></script>
		<script src="../scripts/owlcarousel/dist/owl.carousel.min.js"></script>
		<script src="../scripts/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
		<script src="../scripts/easescroll/jquery.easeScroll.js"></script>
		<script src="../scripts/sweetalert/dist/sweetalert.min.js"></script>
		<script src="../scripts/toast/jquery.toast.min.js"></script>
		<!-- <script src="js/demo.js"></script> -->
		<script src="../js/e-magz.js"></script>
		<script  >
			$(document).ready(function(){
				$('.backk').click(function(){   
			$(".nav-list").removeClass("active");
			$(".nav-list").removeClass("active");
				$(".nav-list .dropdown-menu").removeClass("active");
				$(".nav-title a").text("Menu");
				$(".nav-title .back").remove();
				$("body").css({
					overflow: "auto"
				});
				backdrop.hide();
				 
				});	 
			});
			 
		</script>
	</body>
</html>