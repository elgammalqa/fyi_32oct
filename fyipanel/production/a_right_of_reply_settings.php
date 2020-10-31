<?php 
session_start();   ob_start(); 
ob_start();
include '../models/user.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){ 
        header('Location:lock_screen.php');
    }else{ 
        if (count($_COOKIE)>0)  setcookie('fyiplien','a_time_to_continue.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="a_time_to_continue.php";     
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
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  
    <!-- bootstrap-progressbar -->
    <link href="../../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

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
          <!-- top tiles -->
          <?php require_once('a_toptiles.php'); ?>
          <!-- /top tiles --> 
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Right of reply settings : </h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                     
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                    <?php
                    include '../views/connect.php';
                    $requete = $con->prepare('select * from right_of_reply_settings where id=2');
                    $requete->execute();
                    $row = $requete->fetch(PDO::FETCH_ASSOC);
                    //print_r($row);
                    ?>
                  <form action="#" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                      <label for="mentor_notify" class="control-label col-md-4 col-sm-3 col-xs-12">Notify mentor of new right of reply every : &nbsp;&nbsp; </label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                          <input type="Number" value="<?php echo $row['mentor_notify']; ?>" name="mentor_notify"  class="form-control col-md-4 col-xs-12" min="1" required>
                      </div>
                       <label for="mentor_notify" class="control-label col-md-1 col-sm-2 col-xs-12">Hours </label>
                    </div>

                    <div class="form-group">
                      <label for="admin_notify" class="control-label col-md-4 col-sm-3 col-xs-12">Notify admin of new right of reply every : &nbsp;&nbsp; </label>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <input type="Number" value="<?php echo $row['admin_notify'];   ?>" name="admin_notify"  class="form-control col-md-4 col-xs-12" min="1" required>
                      </div>
                       <label for="admin_notify" class="control-label col-md-1 col-sm-2 col-xs-12">Hours </label>
                    </div>
                      <div class="form-group">
                          <label for="app_slideshow_interval" class="control-label col-md-4 col-sm-3 col-xs-12">App slideshow interval : &nbsp;&nbsp; </label>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                              <input type="Number" value="<?php echo $row['app_slideshow_interval'];   ?>" name="app_slideshow_interval"  class="form-control col-md-4 col-xs-12" min="1" required>
                          </div>
                          <label for="app_slideshow_interval" class="control-label col-md-1 col-sm-2 col-xs-12">Second </label>
                      </div>
                      <div class="form-group">
                          <label for="admin_phone" class="control-label col-md-4 col-sm-3 col-xs-12">Admin phone : &nbsp;&nbsp; </label>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                              <input type="Number" value="<?php echo $row['admin_phone'];   ?>" name="admin_phone"  class="form-control col-md-4 col-xs-12" min="1" required>
                          </div>
                          <label for="app_slideshow_interval" class="control-label col-md-1 col-sm-2 col-xs-12">Start with country code without 00 or + </label>
                      </div>
                      <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
                        <button name="save" class="btn btn-success">Change </button>
                      </div>
                    </div> 
                  </form>
                  <?php     
                  if(isset($_POST['save'])){
                    $notify_mentor=(int)$_POST['mentor_notify'];
                    $notify_admin=(int)$_POST['admin_notify'];
                    $admin_phone=$_POST['admin_phone'];
                    $app_slideshow_interval=$_POST['app_slideshow_interval'];
                    //echo $admin_phone; exit;

                    $con->exec('UPDATE right_of_reply_settings set mentor_notify='.$notify_mentor.', admin_notify = '.$notify_admin.', admin_phone = '.$admin_phone.', app_slideshow_interval = '.$app_slideshow_interval.' where id=2')
                    ; ?>
                     <script type="text/javascript">
                        window.location.replace('a_right_of_reply_settings.php');
                      </script>  

                      <?php }  ?>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
 
      </div>
    </div>

    <!-- jQuery -->
    <script src="../../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../../vendors/Flot/jquery.flot.js"></script>
    <script src="../../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../../vendors/Flot/jquery.flot.resize.js"></script> 
    <!-- Flot plugins -->
    <script src="../../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../../vendors/moment/min/moment.min.js"></script>
    <script src="../../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
     <?php require_once('a_script.php'); ?>
  </body>
</html>
<?php  }
 }else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>

