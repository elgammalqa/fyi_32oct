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
							<h4>ログイン</h4>
							<form method="post" >
								<div class="form-group">
									<label>Eメール</label>
									<input placeholder="Enter Your Email" required="required" type="email" name="username" class="form-control">
								</div>
								<div class="form-group">
									<label class="fw">パスワード
									</label>
									<input  placeholder="Enter Your Password" required="required" type="password" name="password" class="form-control">
									<a href="forgot.php" class="pull-right">パスワードをお忘れですか?</a>
									<!-- href="forgot.php" -->
								</div>
								<br>
								<div class="form-group text-right">
									<button name="login" class="btn btn-primary btn-block">ログイン</button>
								</div>
								<div class="form-group text-center">
									<span class="text-muted">アカウントを持っていない?</span> <a href="register.php">一つ作る</a> <br>
									<span class="text-muted">あなたは確認リンクを受け取っていません: <br>
									</span> <a href="link_verification.php">もう一度送ってください</a>
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
                            if (isset($_SESSION['reply_url'])) {
                                ?>
                                <script> window.location = "<?=$_SESSION['reply_url']?>"; </script>
                            <?php
                            }
                            else{
                            ?>
                                <script> window.location.replace('index.php'); </script>
                            <?php
                            }
                            ?>
	                      	  <?php	}
	                      	  else{
                            if (isset($_SESSION['reply_url'])){
                            ?>
                                  <script> window.location = "<?=$_SESSION['reply_url']?>"; </script>
                              <?php
                              }
                              else{
                              $_SESSION['user_auth'] = array('user_pass' => $user->getpassword(), 'user_email' => $logg);
                              $user->active_status($logg);
                              ?>
                                  <script> window.location.replace('index.php'); </script>
                                  <?php
                              }
	                      	 } //cookies
	                      	 }else{
	                      	 	echo '<script> swal("アクセスが拒否されました!","あなたのメールアドレスを確認してください - 確認メッセージを送信しましたか、もう一度お試しください","warning");</script>';
	                      	 }

                    }else{ ?>
                      <script> swal("アクセスが拒否されました!","電子メールまたはパスワードが間違っている！再試行する","warning");</script>
             <?php  }
            }else{ ?>
                  <script> swal("アクセスが拒否されました!","電子メールまたはパスワードが間違っている！再試行する","warning");</script>
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
		<script src="../js/e-magz.js"></script>
		<script type="text/javascript">
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
