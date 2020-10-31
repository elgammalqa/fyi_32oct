<?php 
session_start();   ob_start();  
ob_start(); 
include '../models/user.model.php'; 
include '../views/connect.php'; 
include '../../models/utilisateurs.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){ 
        header('Location:lock_screen.php');
    }else{    
      if (count($_COOKIE)>0)  setcookie('fyiplien',"a_email_info.php",time()+2592000,"/");
       else   $_SESSION['auth']['lien']="a_email_info.php";  
       
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

    <title>FYI PRESS </title>

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
         <!-- top tiles --> 
          <!-- /top tiles --> 
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Account informations to send email : </h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>  
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />  
                  <form  enctype="multipart/form-data" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                      <label  style="text-align: left" for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                       Email : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12">   
                       <?php  $att='email';  
                         if(utilisateursModel::info2($att)!='') 
                             $email=str_replace(' ', '',utilisateursModel::info2($att));
                         else  $email=''; ?> 
                       <input autocomplete="off" required="required" value="<?php echo $email; ?>"  name="email" for="middle-name" type="email"   class="form-control col-md-5 col-xs-12"> 
                      </div> 
                    </div> 
                      <div class="form-group">
                      <label  style="text-align: left" for="middle-name"class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                      Password : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12">  
                       <?php  $att='password';  
                         if(utilisateursModel::info2($att)!='') 
                             $password=str_replace(' ', '',utilisateursModel::info2($att));
                         else  $password=''; ?>  
                       <input autocomplete="off"  required="required" value="<?php  echo $password;  ?>" name="password" for="middle-name"   class="form-control col-md-5 col-xs-12"> 
                      </div>  
                    </div> 
                    <div class="form-group">
                      <label  style="text-align: left" for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                      Host : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12">  
                         <?php  $att='host';  
                         if(utilisateursModel::info2($att)!='') 
                             $host=str_replace(' ', '',utilisateursModel::info2($att));
                         else  $host=''; ?>  
                       <input autocomplete="off" required="required"  value="<?php echo $host;  ?>"  name="host" for="middle-name"   class="form-control col-md-5 col-xs-12"> 
                      </div>  
                    </div>  
                    <div class="form-group">
                      <label  style="text-align: left" for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                      Port : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12">  
                         <?php  $att='port';  
                         if(utilisateursModel::info2($att)!='') 
                             $port=str_replace(' ', '',utilisateursModel::info2($att));
                         else  $port=''; ?> 
                       <input autocomplete="off" required="required"   value="<?php echo $port;  ?>" name="port" for="middle-name"   class="form-control col-md-5 col-xs-12"> 
                      </div> 
                    </div>  
                    <div class="form-group">
                      <label  style="text-align: left" for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                      SMTP Secure : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12">  
                         <?php  $att='smtpsecure';  
                         if(utilisateursModel::info2($att)!='') 
                             $smtpsecure=str_replace(' ', '',utilisateursModel::info2($att));
                         else  $smtpsecure=''; ?> 
                        <input autocomplete="off" required="required"  value="<?php  echo $smtpsecure; ?>"   name="smtpsecure" for="middle-name"   class="form-control col-md-5 col-xs-12"> 
                      </div> 
                    </div>  
                    <div class="form-group">
                      <label  style="text-align: left" for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                      Web site : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12">  
                        <?php  $att='link';  
                         if(utilisateursModel::info2($att)!='') 
                           $website=str_replace(' ', '',utilisateursModel::info2($att));
                         else  $website=''; ?>
                        <input autocomplete="off" required="required"  value="<?php echo $website; ?>"  placeholder="example http://www.thatsfyi.com" type="text"  name="link" for="middle-name"   class="form-control col-md-5 col-xs-12"> 
                      </div> 
                    </div>  
                    <div class="form-group">
                      <label  style="text-align: left" for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                      Max size media Comment : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12"> 
                      <?php  $att='maxsizecomments';  
                         if(utilisateursModel::info2($att)!='') 
                             $maxsizee=str_replace(' ', '',utilisateursModel::info2($att));
                         else  $maxsizee=''; ?> 
                        <input autocomplete="off" type="Number" required="required"  value="<?php echo $maxsizee; ?>"   
                         name="maxsizecomments" for="middle-name"  class="form-control col-md-5 col-xs-12"> 
                      </div> 
                      <label for="middle-name" class="control-label col-md-1 col-sm-2 col-xs-12">
                      MB </label>
                    </div>  
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5 col-sm-offset-5">
                        <button name="submit" class="btn btn-success">Save informations </button>
                      </div>
                    </div> 
                  </form>
                  <?php     
                  if(isset($_POST['submit'])){  
                      try {  
                        $email=$_POST['email'];
                        $password=$_POST['password'];
                        $host=$_POST['host'];
                        $port=$_POST['port'];
                        $link=$_POST['link'];
                        $smtpsecure=$_POST['smtpsecure'];
                        $maxsizecomments=$_POST['maxsizecomments'];
                        if (substr($link, -1)=="/"){
                          $link=substr($link,0, -1);
                        }
                        if ($maxsizecomments>0) { 
                       $con->exec('UPDATE account  set email="'.$email.'", password="'.$password.'", host="'.$host.'", port='.$port.', maxsizecomments='.$maxsizecomments.', link="'.$link.'", smtpsecure="'.$smtpsecure.'"  where id=1'); ?>
                      <script type="text/javascript">
                        window.location.replace('a_email_info.php');
                      </script> 
                     <?php  }else{ ?> 
                     <script>swal("Max size media comments !","Max size media comments should be at least 1 MB","warning")</script> 
                    <?php } 
                      } catch (PDOException $e) { ?> 
                        <script>swal("Error!","account informations does not changed","warning")</script>
                      <?php }   
                       }  ?> 
                  </div>
              </div>
            </div>
          </div>
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
 }else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>

