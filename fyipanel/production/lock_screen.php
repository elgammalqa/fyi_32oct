<?php 
session_start();   ob_start(); 
ob_start();
include '../models/user.model.php';
if (isset($_COOKIE['fyipFunction'])&&!empty($_COOKIE['fyipFunction'])) {
   $f=$_COOKIE['fyipFunction'];
 }else if (isset($_SESSION['auth']['Function'])&&!empty($_SESSION['auth']['Function'])) {
    $f=$_SESSION['auth']['Function'];
 }  
  if(userModel::islogged($f)==true){ 
    if (count($_COOKIE)>0) setcookie('fyiplock',1,time()+2592000,"/");
      else   $_SESSION['auth']['lock']=1;   

      if (isset($_COOKIE['fyipPhoto'])&&!empty($_COOKIE['fyipPhoto']))
          $fyipPhoto=$_COOKIE['fyipPhoto']; 
           else   $fyipPhoto=$_SESSION['auth']['Photo'];    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
 

    <!-- Bootstrap core CSS -->
    <link href="../../asset/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="../../asset/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="../../asset/css/style.css" rel="stylesheet">
    <link href="../../asset/css/style-responsive.css" rel="stylesheet"> 
  </head> 
  <body onload="getTime()"> 
	  	<div class="container">
	  	<form method="post">
	  		<div id="showtime"></div>
	  			<div class="col-lg-4 col-lg-offset-4">
	  				<div class="lock-screen">
		  				<h2><a data-toggle="modal" href="#myModal"><i class="fa fa-lock"></i></a></h2>
		  				<p>UNLOCK</p> 
				          <!-- Modal -->
				          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
				              <div class="modal-dialog">
				                  <div class="modal-content">
				                      <div class="modal-header">
				                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				                          <h4 class="modal-title">Welcome Back</h4>
				                      </div>
				                      <div class="modal-body"> 
				                         
                                        <?php     try{ ?>
                                             <p class="centered">
                                             <img class="img-circle" width="100"  src="../views/img/<?php echo $fyipPhoto; ?>" >
                                         </p>
                                             <?php }catch(Exception $e){ ?>
                                              <p class="centered">
                                             <img class="img-circle" width="100"  src="images/fyi.jpeg" >
                                         </p>
                                       <?php  } ?>
                                          
				                          <input required="" type="password" name="passwordd" placeholder="Password" autocomplete="off" class="form-control placeholder-no-fix"> 
				                      </div>
				                      <div class="modal-footer centered">
				                          <button data-dismiss="modal" class="btn btn-theme04" type="button">Cancel</button>
				                         <input  class="btn btn-theme03" type="submit" name="ok"  value="Login"/> 
				                      </div>
				                  </div>
				              </div>
				          </div>
				          <!-- modal --> 
	  				</div><!--/lock-screen -->
	  			</div><!-- /col-lg-4 --> 
	  	</form>
        <?php   
       if(isset($_POST["ok"])){ 

        if (isset($_COOKIE['fyipPassword'])&&!empty($_COOKIE['fyipPassword']))
          $pss=$_COOKIE['fyipPassword']; 
           else   $pss=$_SESSION['auth']['Password']; 


            if(isset($pss)&&password_verify($_POST["passwordd"],$pss)){
           if (count($_COOKIE)>0) setcookie('fyiplock',0,time()+2592000,"/");
              else   $_SESSION['auth']['lock']=0; 

              if (isset($_COOKIE['fyiplien'])&&!empty($_COOKIE['fyiplien'])) {
                  header('Location:'.$_COOKIE["fyiplien"]); 
               }else if (isset($_SESSION['auth']['lien'])&&!empty($_SESSION['auth']['lien'])) {
               header('Location:'.$_SESSION["auth"]["lien"]); 
                  }     
        } 
        }
        ?>  
	  	</div><!-- /container --> 
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../../asset/js/jquery.js"></script>
    <script src="../../asset/js/bootstrap.min.js"></script>  
    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="../../asset/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("../../asset/img/login-bg.jpg", {speed: 500});
    </script>

    <script>
        function getTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
            document.getElementById('showtime').innerHTML=h+":"+m+":"+s;
            t=setTimeout(function(){getTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }
    </script>

  </body>
</html>
<?php }else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>