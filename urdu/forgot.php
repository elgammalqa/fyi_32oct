<?php 
session_start();   ob_start();    
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
	</head> 
	<body class="skin-orange">
	    <?php require_once ("header.php"); ?>  
		<section class="login first grey">
			<div class="container">
				<div class="box-wrapper">				
					<div class="box box-border">
						<div class="box-body">
							<h4 style="text-align: right;" >
							اپنا پاس ورڈ بھول گئے 
							</h4>
							<form method="post" >
								<div class="form-group" style="text-align: right;" >
									<label style=" font-size: 20px; " > 
									ای میل 
									</label>
									<input style="text-align: right;" placeholder="آپ کا ای میل پتہ" type="email" name="email" class="form-control">
								</div>
								<div class="form-group text-right">
									<button dir="rtl" class="btn btn-primary btn-block" name="reset" >
									اپنا پاس ورڈ تبدیل کریں 
								</button>
								</div>
								<div class="form-group text-center">
									<span class="text-muted">

									 <a href="login.php"> لاگ ان پر واپس جائیں  </a>
									 </span>
								</div> 
							</form>
							<?php 
							 if (isset($_POST['reset'])) {
							 	$email=strip_tags($_POST['email']);
							 	if (utilisateursModel::email_exist($email)) {
							 	    $token= utilisateursModel::generateNewString(); 
							 	    $name=utilisateursModel::getUserName($email);
 
   
							 	$smtpsecure=utilisateursModel::info("smtpsecure"); 
					 	        $email_sender=utilisateursModel::info("email");  
					 	        $password_sender=utilisateursModel::info("password"); 
					 	        $host=utilisateursModel::info("host"); 
					 	        $port=utilisateursModel::info("port");    
					 	        $link=utilisateursModel::info("link");   
					 	        $smtpsecure = str_replace(' ', '', $smtpsecure);
					 	        $email_sender = str_replace(' ', '', $email_sender);
					 	        $password_sender = str_replace(' ', '', $password_sender);
					 	        $host = str_replace(' ', '', $host);
					 	        $port = str_replace(' ', '', $port);
					 	        $link = str_replace(' ', '', $link);

							 	require('PHPMailer-master/PHPMailerAutoload.php');
								$mail=new PHPMailer();
								$mail->IsSmtp();
								$mail->SMTPDebug=0; 
								$mail->SMTPAuth=true;
								$mail->SMTPSecure=$smtpsecure;
								$mail->Host=$host;  
								$mail->Port=$port; //or 587
								$mail->IsHTML(true);
								$mail->CharSet = 'UTF-8';
								$mail->Username=$email_sender;
								$mail->Password=$password_sender;
								$mail->SetFrom($email_sender," صحيفة لعلمك  ");
								$mail->Subject=" تغيير كلمة المرور  ";
								$mail->AddAddress($email, $name);
								$mail->Body = "   
	 <table border='0' cellpadding='0' cellspacing='0'  style='margin-left:17%;' >
        <tbody> 
          <tr>
            <td ><a> 
            <img src='$link/images/fyipress.png' style='padding:20px; width: 350px; height: 70px; ' ></a>
              </td>
          </tr>
            <tr>
              <td style='font-size: 19px; padding: 20px;  font-family: Helvetica; line-height: 150%; text-align: right;' >
                 <span style='float:right;' >
             &nbsp;&nbsp;&nbsp;  ہیلو
             </span>
              <span style='float:right;' >
              $name 
             </span> 
               <br> <br> 
             <span style='float:right;' >
             &nbsp;&nbsp;&nbsp;   میں خوش آمدید
             </span>
              <span style='float:right;' >
              FYIPRESS 
             </span>  <br><br>
              اپنا پاس ورڈ دوبارہ ترتیب دینے کے لئے  <br>
               براہ مہربانی نیچے دیئے گئے لنک پر کلک کریں   <br> <br> <span style='padding-left: 100px;' ></span>
              <a style='text-decoration: none;' target='_blank' href='$link/confirm_forgot.php?email=$email&token=$token'>
                 <span 
                 style='font-family: Avenir,Helvetica,sans-serif;box-sizing: border-box;
                               border-radius: 3px; color: #fff;display: inline-block;
                               text-decoration: none; background-color: #2ab27b; border-top: 10px solid #2ab27b;
                               border-right: 18px solid #2ab27b; border-bottom: 10px solid #2ab27b;
                               border-left: 18px solid #2ab27b;  ' > 
                            آپ کا پاس ورڈ دوبارہ ترتیب دیں
                        </span>
              </a><br><br> 
              FYI Press سپورٹ
          </td>
      </tr> 
            <tr>  
              <td>
                    <a target='_blank' href='$link' style='font-size: 19px; padding: 20px;  font-family: Helvetica; line-height: 150%; text-align: right; float: right; ' >
                       ہماری ویب سائیٹ پر وزٹ کریں
                    </a><br><br>
                    <span style='font-size: 19px; padding: 20px;  font-family: Helvetica; line-height: 150%; text-align: right; color: #505050; float: right; ' > Copyright © FYI Press, جملہ حقوق محفوظ ہیں.  </span> 
                </td>
            </tr>
                            
        </tbody>
    </table>  "; 
				    if ($mail->send()){
				    	 utilisateursModel::update_token($email,$token);
				      echo '<script> swal(" تغيير كلمة المرور  ","  تم ارسال كلمة المرور لبريدك الالكتروني   ","success");</script>'; 
				 }else{
			        echo '<script> swal(" تغيير كلمة المرور  "," حدث خطأ ما  يرجى المحاولة مرة أخرى   ","warning");</script>'; 
			     }

							 	}else{
							 		 echo '<script> swal(" تسجيل  "," لا يوجد حساب بهذا البريد الالكتروني  ","warning");</script>'; 
							 	}
							 }

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
		<!--<script src="js/demo.js"></script>-->
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