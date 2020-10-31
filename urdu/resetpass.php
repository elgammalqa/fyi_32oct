<?php 
session_start();   ob_start(); 
ob_start(); 
if(isset($_COOKIE['fyiuser_email'])){
 	$user_email=$_COOKIE['fyiuser_email'];
}else if(isset($_SESSION['user_auth']['user_email'])){
	$user_email=$_SESSION['user_auth']['user_email'];
}
require_once('models/utilisateurs.model.php');
if(utilisateursModel::islogged())
$log=true;
else $log=false;
if ($log==true) { 
 ?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
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
	</head>

	<body class="skin-orange">
		 <?php require_once ("header.php"); ?> 

		<section class="login first grey">
			<div class="container">
				<div class="box-wrapper">				
					<div class="box box-border">
						<div class="box-body">
							<h4 style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; text-align: right;">اپنا پاس ورڈ تبدیل کریں</h4>
							<form method="post" > 
								<div style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; text-align: right;" class="form-group">
									<label>پرانا پاس ورڈ</label>
									<input required="required" type="password" name="oldpass" class="form-control">
								</div>
								<div style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; text-align: right;" class="form-group">
									<label class="fw">نیا پاس ورڈ</label>
									<input required="required" type="password" name="password" class="form-control">
								</div>
								<div style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; text-align: right;" class="form-group">
									<label class="fw">اپنا پاس ورڈ کی تصدیق کریں</label>
									<input required="required" type="password" name="confirm_password" class="form-control">
								</div> 
								<div style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; text-align: center;" class="form-group text-right">
									<button name="change" class="btn btn-primary btn-block">تبدیل کریں</button>
								</div>
							</form> 
							<?php if(isset($_POST['change'])){ 
							      $user = new utilisateursModel();  
							       if (password_verify($_POST['oldpass'],
							       	$user->get_current_pass($user_email))){
							       	$text=$_POST['password'];
		                            $CountOfNumbers= count(array_filter(str_split($text),'is_numeric'));
		                            $NumbresOfCaracteres=strlen($text);
		                            $msgg="";
		                            $tr=true;
		                            if ($NumbresOfCaracteres<6) { 
		                                 $tr=false;
		                            }else{
		                            if ($CountOfNumbers>=1) { 
		                            if ($NumbresOfCaracteres-$CountOfNumbers<=0)  {
		                            	   $tr=false; 
		                             }
		                             }else {
		                             	 $tr=false;  
		                             }
		                             }
		                             if($tr==true){ 
							      	if($_POST['password']==$_POST['confirm_password']){ 
							      	$ps=password_hash($text, PASSWORD_DEFAULT); 
							           $user->update_pass($user_email, $ps); 
							           if(isset($_COOKIE['fyiuser_pass'])){
                      	                 setcookie('fyiuser_pass',$ps,time()+31104000,"/");
										}else if(isset($_SESSION['user_auth']['user_pass'])){
											 $_SESSION['user_auth']['user_pass']= $ps;
										}
							          
							            ?>
							          <script>swal("Password!","Password has been changed successfully","success")</script> 
							         <?php }else{  ?>
					  <script>swal("غلط پاس ورڈ!","پاس ورڈ ایک ہی نہیں ہیں","warning")</script>
							         <?php 
							         }//confirm  
							     }else{// 5 numbers and 1 letter 
							     	  $msgg='پاس ورڈ میں کم سے کم چھ حروف بھی شامل ہیں (ایک کردار یا ایک خط) اور ایک نمبر';
							     	?>
							      <script>
						          	swal("پاس ورڈ !","<?php echo $msgg; ?>","warning")
						          </script>
							  <?php   }


							          }else{  
							          ?>
							           <script>swal("پاس ورڈ میچ نہیں کرتا!","موجودہ پاس ورڈ غلط ہے","warning")</script>
							         <?php
							          }//current

							        } //submit
                                   ?> 

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
<?php }else{ ?>
        <script>
          window.location.replace('404.php');
        </script> 
  <?php  } ?>