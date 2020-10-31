<?php 
session_start();   ob_start();    
require_once('models/utilisateurs.model.php'); 
function nb_messages_today($email){
	include 'fyipanel/views/connect.php';
	$sql = $con->prepare("SELECT count(*) FROM `messages` 
		WHERE `email`='$email' and Date(date)=Date(now()) "); 
    $sql->execute(); 
    $nb = $sql->fetchColumn();  
    return $nb;
} 
function add_message($email,$name,$subject,$message,$phone){
try{
	include 'fyipanel/views/connect.php';
 if($con->exec("INSERT INTO `messages` (`id`, `email`, `name`, `subject`, `message`, `phone`) VALUES
  (NULL, '".$email."','".$name."','".$subject."','".$message."','".$phone."')" ))
    return true; 
    else return false;
 } catch (PDOException $e) { 
   return false;  
 }
}
if(utilisateursModel::islogged())
$log=true; 
else $log=false;

if($log){
if(isset($_COOKIE['fyiuser_email'])){
	$cmail=$_COOKIE['fyiuser_email'];
	$cname=utilisateursModel::getUserName($cmail);
}else{
	$cmail=$_SESSION['user_auth']['user_email'];
	$cname=utilisateursModel::getUserName($cmail);
}
}
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
		<script src="../scripts/sweetalert/dist/sweetalert.min.js"></script>
		<!-- Custom style -->
		<link rel="stylesheet" href="../css/style.css">
		<link rel="stylesheet" href="../css/style2.css">
		<link rel="stylesheet" href="../css/skins/all.css">
		<link rel="stylesheet" href="../css/demo.css">   
		<style type="text/css">
			div .row{
				padding-bottom: 15px;
			}
			.fcontact{ 
				    font-size: 26px; 
				    font-weight: 800; 
				    text-transform: uppercase;
				    margin-bottom: 20px;
				    text-decoration: underline;
			}
			 .fullname{
				 font-size: 18px; 
				    font-weight: 600; 
			} 
		</style> 
		 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>

	<body  class="skin-orange" onLoad="document.myf.name.focus();" lang="ar" dir="rtl" >
		  <?php require_once('header.php'); ?>
		<section class="category" style="margin-bottom: 2%; padding: 10px;" style="float: right;" >
			<div class="container"> 
			<h3 class="fcontact" >  تواصل معنا </h3>
			<form method="post" name="myf"  id="myf"  >
				<div class="row" >
					<div class="col-md-8 col-md-offset-4  col-xs-12 col-sm-12"> 
	                    <label class="fullname">إسمك * : </label>
	                    <?php if($log){ ?>
	                    <input autocomplete="off" value="<?php echo $cname; ?>" required class="form-control fullname" name="name" />
	                    <?php }else{ ?>
	                    <input autocomplete="off"  required class="form-control fullname" name="name" />
	                    <?php } ?>
                	</div>
				</div> 
				<div class="row" >
					<div class="col-md-8 col-md-offset-4 col-xs-12 col-sm-12"> 
	                    <label class="fullname">البريد الالكتروني * : </label>
	                    <?php if($log){ ?>
	                    <input autocomplete="off" type="email" value="<?php echo $cmail; ?>" required class="form-control fullname" name="email" />
	                    <?php }else{ ?>
	                    <input autocomplete="off" type="email"  required class="form-control fullname" name="email" />
	                    <?php } ?>
                	</div>
				</div> 
				<div class="row" >
					<div class="col-md-8 col-md-offset-4 col-xs-12 col-sm-12"> 
	                    <label class="fullname"> رقم الهاتف  : </label>
	                    <input autocomplete="off" class="form-control fullname" name="phone" />
                	</div>
				</div>  
				<div class="row" >
					<div class="col-md-8 col-md-offset-4 col-xs-12 col-sm-12"> 
	                    <label class="fullname">الموضوع * : </label>
	                    <input autocomplete="off"  required class="form-control fullname" name="subject" />
                	</div>
				</div>  
				<div class="row" >
					<div class="col-md-8 col-md-offset-4 col-xs-12 col-sm-12"> 
	                    <label class="fullname">الرسالة * : </label>
	                    <textarea maxlength="1500" autocomplete="off" name="message" required class="form-control fullname" cols="10" rows="10" ></textarea> 
                	</div>
				</div>
				<div class="g-recaptcha" 
      				data-sitekey="6LcEi64UAAAAANSvJaw0hI8qDMHpU_OrxB4OU0AA">
      			 </div>

				<div class="row" >
					<div  class="col-md-2 col-md-offset-4 col-xs-12 col-sm-12">  
	                    <button id="button" type="submit" name="send" class="btn btn-success"  >
	                     <span class="fullname" >   إرسال   </span>
	                    </button> 
	                </div>  
                </div> 

                </form>
			</div>   
			<?php if (isset($_POST['send'])) {
    	if(isset($_POST['g-recaptcha-response'])){
    		$secret="6LcEi64UAAAAACMzXM6hzjWIorfsYPxbxsisMXWJ";
			$response=$_POST['g-recaptcha-response'];
			$ip=$_SERVER['REMOTE_ADDR'];
			$verify=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
			$resp=json_decode($verify,true); 

		if ($resp['success']) { //recap ok 
    	$email=addslashes(strip_tags($_POST['email']));
    	$name=addslashes(strip_tags($_POST['name']));
    	$subject=addslashes(strip_tags($_POST['subject']));
    	$message=addslashes(strip_tags($_POST['message']));
    	if(isset($_POST['phone'])) $phone=addslashes(strip_tags($_POST['phone']));
    	else $phone=' '; 
    	if(nb_messages_today($email)>1){ 
    		echo '<script>swal("الرسالة","لا يمكنك إرسال أكثر من رسالتين يوميًا", "warning");</script>'; 
    	}else{  
    		if(add_message($email,$name,$subject,$message,$phone)){
    		echo '<script>swal("الرسالة","تم إرسال الرسالة بنجاح", "success");</script>';
    		}else{
    		echo '<script>swal("الرسالة","لم يتم إرسال الرسالة بنجاح", "warning");</script>';  
    		}
    	} 
   		 }else{//recap not ok
   		 	echo '<script>swal("روبوت","تحقق من أنا لست روبوت", "warning");</script>';
   		 }
	    }else{//not checked 
	      echo '<script>swal("روبوت","تحقق من أنا لست روبوت", "warning");</script>';
	    } 
      } ?>
 
 
		</section>

		<?php require_once ('footer.php') ?>

		<!-- JS -->
		<script src="../js/jquery.js"></script>
		<script src="../js/jquery.migrate.js"></script>
		<script src="../scripts/bootstrap/bootstrap.min.js"></script>
		<script>var $target_end=$(".best-of-the-week");</script>
		<script src="../scripts/jquery-number/jquery.number.min.js"></script>
		<script src="../scripts/owlcarousel/dist/owl.carousel.min.js"></script>
		<script src="../scripts/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
		<script src="../scripts/easescroll/jquery.easeScroll.js"></script>
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