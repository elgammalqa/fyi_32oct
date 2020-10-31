<?php  
session_start();   ob_start(); 
ob_start();
include '../models/user.model.php'; 
include '../../models/utilisateurs.model.php';  
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{  
      if (count($_COOKIE)>0)  setcookie('fyiplien','a_news_displayed.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="a_news_displayed.php";  
     
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

    <title>FYI press </title>

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
    <style type="text/css">
    @media (max-width: 1199.98px) {   
    	#pt{
    		margin-top: 15px;
    	}}
    </style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col" style="position: fixed;">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0; margin-top: 10px;margin-bottom: 10px;">
              <a href="admin.php" class="site_title"><img style="width: 40px; height: 40px; margin-left: 5px; " class="img-circle" src="images/fyi.jpeg" ><span> FYI press </span></a>
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
                  <h2>Send verification link : </h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
                  <form    method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                      <span id="pt"  class="control-label col-md-2 col-sm-12 col-xs-12">
                      Email :   </span>
                      <div class="col-md-4 col-sm-12 col-xs-12">  
                           <input id="pt" for="middle-name"   required="" name="logg" type="email" class="form-control" placeholder="Email" autofocus autocomplete="off"  > 
                      </div> 
                       <div class="col-md-2 col-sm-12 col-xs-12  ">
                        <button id="pt" name="go" class="btn btn-success">Send verification link </button>
                      </div>
                    </div>    
                  </form>
                   <?php
          require_once("../models/user.model.php");
                $user=new userModel();  
                if(isset($_POST['go'])){     
                $email=strip_tags($_POST['logg']);  
                if(userModel::acount_exist($email)){   
                  if(userModel::acount_is_non_confirmed($email)){ 
                    $token= userModel::generateNewString();  
                    $name=userModel::getname($email);

                    $smtpsecure=utilisateursModel::info2("smtpsecure"); 
                    $email_sender=utilisateursModel::info2("email");  
                    $password_sender=utilisateursModel::info2("password"); 
                    $host=utilisateursModel::info2("host"); 
                    $port=utilisateursModel::info2("port");    
                    $link=utilisateursModel::info2("link");   
                    $smtpsecure = str_replace(' ', '', $smtpsecure);
                    $email_sender = str_replace(' ', '', $email_sender);
                    $password_sender = str_replace(' ', '', $password_sender);
                    $host = str_replace(' ', '', $host);
                    $port = str_replace(' ', '', $port);
                    $link = str_replace(' ', '', $link);
 
                    require('../../PHPMailer-master/PHPMailerAutoload.php');
                    $mail=new PHPMailer();
                    $mail->IsSmtp();
                    $mail->SMTPDebug=0;
                    $mail->SMTPAuth=true; 
                    $mail->SMTPSecure=$smtpsecure;
                    $mail->Host=$host;   
                    $mail->Port=$port; //or 587
                    $mail->IsHTML(true);
                    $mail->Username=$email_sender;
                    $mail->Password=$password_sender; 
                    $mail->SetFrom($email_sender,"FYI press");
                    $mail->Subject="FYI press Confirm your e-mail address";
                     $mail->AddAddress($email,$name);
                     $mail->Body = "   
    <table border='0' cellpadding='0' cellspacing='0' >
        <tbody> 
          <tr>
            <td ><a>
            <img src='$link/images/fyipress.png' style='padding:20px; width: 350px; height: 70px; ' ></a>
              </td>
          </tr>
            <tr>
              <td style='font-size: 19px; padding: 20px;  font-family: Helvetica; line-height: 150%; text-align: left;' >
              Hi $name , <br> <br> Welcome to FYI press .  <br><br>
              To activate your account and verify your email address,<br>
               please click on the link below : <br> <br> <span style='padding-left: 100px;' ></span>
              <a style='text-decoration: none;' target='_blank' href='$link/account_pass.php?email=$email&token=$token'>
                 <span 
                 style='font-family: Avenir,Helvetica,sans-serif;box-sizing: border-box;
                               border-radius: 3px; color: #fff;display: inline-block;
                               text-decoration: none; background-color: #2ab27b; border-top: 10px solid #2ab27b;
                               border-right: 18px solid #2ab27b; border-bottom: 10px solid #2ab27b;
                               border-left: 18px solid #2ab27b;  ' > 
                            Confirm your e-mail address 
                        </span>
              </a><br><br> 
              FYI press Support
          </td>
      </tr> 
            <tr>  
              <td>
                    <a target='_blank' href='$link' style='font-size: 19px; padding: 20px;  font-family: Helvetica; line-height: 150%; text-align: left;' >
                       visit our website 
                    </a><br><br>
                    <span style='font-size: 19px; padding: 20px;  font-family: Helvetica; line-height: 150%; text-align: left; color: #505050;' >   Copyright © FYI press, All rights reserved.  </span> 
                </td>
            </tr> 
                            
        </tbody>  
    </table>     "; 
                        if ($mail->send()){
                           userModel::update_token($email,$token);
                            echo '<script> swal("Password !","You have been registered! Please verify your email!","success");</script>'; 
                        }else{
                            echo '<script> swal("Password !","Something wrong happened! Please try again!","warning");</script>';  
                          }
                    }else{ // email confirmed 
                           echo '<script> swal("Email !","Email address is already verified!","warning");</script>'; 
                }

                } else{ ?>
                      <script> swal("Access denied!","You are not subscribed!","warning");</script>
                  <?php  }
                }
            ?>
                




 



                   
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

