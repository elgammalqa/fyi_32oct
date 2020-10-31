<?php  session_start();   ob_start();  
include '../models/user.model.php';
require_once ('../../../fyipanel/models/v5.comments.php'); 
	function mediaa($media,$table){  	 
		$typee=v5comments::typeOfMedia($media); ?> 
		<div class="row" >
            <div class="col-md-8 col-sm-12 col-xs-12">  
		<?php if ($typee=="image"){ ?> 
		    <img style="width: 100%" src="<?php echo '../../images/'.$table.'/'.$media; ?>">	
				<?php }else if($typee=="video"){ ?>
				    <video style="width: 100%" controls >
						<source src="<?php echo '../../images/'.$table.'/'.$media; ?>"  >
					</video>
					<?php }else if($typee=="audio"){ ?>
					<audio style="width: 100%"   controls  >
					    <source src="<?php echo '../../images/'.$table.'/'.$media; ?>"  >
					</audio> 
				<?php }  ?> 
			</div>
			</div> 
	<?php } 
	function mediaa_ads($media,$table){  	
		$typee=v5comments::typeOfMedia($media); ?> 
		<div class="row" >
            <div class="col-md-8 col-sm-12 col-xs-12">  
		<?php if ($typee=="image"){ ?> 
		    <img style="width: 100%" src="<?php echo '../../ads/'.$table.'/'.$media; ?>">	
				<?php }else if($typee=="video"){ ?>
				    <video style="width: 100%" controls >
						<source src="<?php echo '../../ads/'.$table.'/'.$media; ?>"  >
					</video>
					<?php }else if($typee=="audio"){ ?>
					<audio style="width: 100%"   controls  >
					    <source src="<?php echo '../../ads/'.$table.'/'.$media; ?>"  >
					</audio> 
				<?php }  ?> 
			</div>
			</div> 
	<?php } 
if (isset($_GET['id'])&&!empty($_GET['id'])&&isset($_GET['op'])&&!empty($_GET['op'])){  
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){ 
        header('Location:lock_screen.php');
    }else{ 
        if (count($_COOKIE)>0)  setcookie('fyiplien','a_time_to_continue.php',time()+2592000,"/");
        else $_SESSION['auth']['lien']="a_time_to_continue.php";     
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="images/favicon.ico" type="image/ico" />
 

    <!-- Bootstrap -->
    <link href="../../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  
    <!-- bootstrap-progressbar -->
    <link href="../../../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../../../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../../../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sweetalert.css"/> 
    
    <script src="js/sweetalert-dev.js"></script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col" style="position: fixed;">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0; margin-top: 10px;margin-bottom: 10px;">
              <a href="admin.php" class="site_title"><img style="width: 45px; height: 45px; margin-left: 5px; " class="img-circle" src="images/fyi.jpeg" ><span style="margin-left: 15px;" > FYI PRESS </span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
             <?php require_once('a_menu_profile.php'); ?> 
            <!-- /menu profile quick info --> 
                   <?php require_once('a_menu.php'); ?>
             <?php require_once('a_footer.php'); ?> 
          </div>
        </div>

        <!-- top navigation -->
             <?php require_once('a_top_navigation.php'); ?> 
        <!-- /top navigation --> 

        <!-- page content --> 
        <div class="right_col" role="main">  
                <?php 
                	//rss
			   		if($_GET['op']=="rss_comments"){ 
			   		  mediaa($_GET['id'],'rss_comments');
			   		}else if($_GET['op']=="rss_replies"){ 
			   		  mediaa($_GET['id'],'rss_replies');
			   		} else if($_GET['op']=="comments"){ 
			   		  mediaa($_GET['id'],'comments');
			   		}else if($_GET['op']=="replies"){ 
			   		  mediaa($_GET['id'],'replies');
			   		} else if($_GET['op']=="adscomments"){ 
			   		  mediaa_ads($_GET['id'],'comments');
			   		}else if($_GET['op']=="adsreplies"){ 
			   		  mediaa_ads($_GET['id'],'replies');
			   		}  
                ?>  
        </div>
        <!-- /page content -->
 
      </div>
    </div>

    <!-- jQuery -->
    <script src="../../../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../../../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../../../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../../../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../../../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../../../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../../../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../../../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../../../vendors/Flot/jquery.flot.js"></script>
    <script src="../../../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../../../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../../../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../../../vendors/Flot/jquery.flot.resize.js"></script> 
    <!-- Flot plugins -->
    <script src="../../../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../../../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../../../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../../../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../../../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../../../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../../../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../../../vendors/moment/min/moment.min.js"></script>
    <script src="../../../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
     <?php require_once('a_script.php'); ?>
  </body>
</html>
<?php  }
 } else{ echo "<script> window.location.replace('index.php'); </script>"; }
 } else{ echo "<script> window.location.replace('index.php'); </script>"; }
 ?>    