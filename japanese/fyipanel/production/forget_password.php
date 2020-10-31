<?php   
require_once('../models/user.model.php');  
include '../../models/utilisateurs.model.php';  
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
    <title> Authentification </title> 
    <!-- Bootstrap core CSS -->
    <link href="../../../asset/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="../../../asset/font-awesome/css/font-awesome.css" rel="stylesheet" /> 
    <!-- Custom styles for this template -->
    <link href="../../../asset/css/style.css" rel="stylesheet">
    <link href="../../../asset/css/style-responsive.css" rel="stylesheet"> 
    <script src="js/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="css/sweetalert.css"/> 
    <style type="text/css">
      img{
        width : 1000px;
      }
    </style> 
  </head> 
    <body > <br /><br /> <br /><br /> 
      <div id="login-page">
        <div class="container">
            <form class="form-login"  method="post">
              <h2 class="form-login-heading">sign in now</h2>
              <div class="login-wrap"> 
                <div class="input-group margin-bottom-sm">
                  <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                  <input type="email" required="required" name="logg" type="text" class="form-control" placeholder="Email" autofocus autocomplete="off">
                </div>  <br> 
                  <button class="btn btn-theme btn-block" type="submit" name="go"> Reset Password</button>
              </div> 
            </form>    
        </div>
      </div>     
        <?php 
                $user=new userModel();  
                if(isset($_POST['go'])){    
                $email=strip_tags($_POST['logg']);  
                if(userModel::acount_exist($email)){      
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
                    $mail->Subject="FYI press Reset your password ";
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
             In order to reset your password,<br>
               please click on the link below : <br> <br> <span style='padding-left: 100px;' ></span>
              <a style='text-decoration: none;' target='_blank' href='$link/a_reset_pass.php?email=$email&token=$token'>
                 <span 
                 style='font-family: Avenir,Helvetica,sans-serif;box-sizing: border-box;
                               border-radius: 3px; color: #fff;display: inline-block;
                               text-decoration: none; background-color: #2ab27b; border-top: 10px solid #2ab27b;
                               border-right: 18px solid #2ab27b; border-bottom: 10px solid #2ab27b;
                               border-left: 18px solid #2ab27b;  ' > 
                            Reset your password 
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
    </table>";  
                            if ($mail->send()){
                                echo '<script> swal("Password !","Please Check Your Email Inbox!","success");</script>';  
                               userModel::update_token($email,$token);
                            }else{
                                echo '<script> swal("Password !","Something wrong happened! Please try again!","warning");</script>';  
                                }  
                    
                } else{ ?>
                      <script> swal("Access denied!","You are not subscribed!","warning");</script>
                  <?php  }
                }
            ?>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../../../asset/js/jquery.js"></script>
    <script src="../../../asset/js/bootstrap.min.js"></script> 
    <script type="text/javascript" src="../../../asset/js/jquery.backstretch.min.js"></script>
     <script>
        $.backstretch("../../../asset/img/a.jpeg", {speed: 500});
    </script>


  </body>
</html>
