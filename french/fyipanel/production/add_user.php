<?php 
session_start();   ob_start();  
ob_start();
include '../models/user.model.php';
include '../../models/utilisateurs.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){  
        header('Location:lock_screen.php');
    }else{  
       if (count($_COOKIE)>0)  setcookie('fyiplien','add_user.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="add_user.php";  
  
       function send_link($email, $name,$token){
         $email_send_status=false;
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
                $mail->Host=$host; //ftpupload.net
                $mail->Port=$port; //or 587
                $mail->IsHTML(true); 
                $mail->Username=$email_sender;
                $mail->Password=$password_sender;
                $mail->SetFrom($email_sender,"FYI press");
                $mail->Subject="FYI press Confirm your e-mail address";
                $mail->AddAddress($email, $name);
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
    </table>  
                       "; 
                      if ($mail->send()){
                            echo '<script> swal("Password !","You have been registered! Please verify your email!","success");</script>'; 
                            $email_send_status=true;
                        }else{
                            echo '<script> swal("Password !","Something wrong happened! Please try again!","warning");</script>'; 
                          }
                          return $email_send_status;
       }
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
  </head>

  <body class="nav-md" style="background: #F7F7F7;">
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
                  <h2>Add Employee</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content"> 
                  <br />
                  <form action="#" enctype="multipart/form-data" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                  <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="middle-name" class="form-control col-md-7 col-xs-12" type="Email" name="Email">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="First_name" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="last-name" name="Last_name" required="required" class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="Gender">
                          <option value="Male">Male</option>
                          <option value="Female">Female</option> 
                        </select>
                      </div>
                    </div> 
                     <div class="form-group">
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Photo </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="middle-name" class="form-control col-md-7 col-xs-12" type="file" name="image" accept="image/*">
                      </div>
                    </div>  
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Type of the job <span class="required">*</span></label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <select required="" class="form-control" name="Function">
                          <option value="Admin" >Admin</option> 
                          <option value="Head of Branch">Head of Branch</option>
                          <option value="Reporter">Reporter</option>
                          <option value="Ads">Ads</option>
                        </select>
                      </div>
                    </div> 
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
                        <button name="add_user" class="btn btn-success">Add Employee</button>
                      </div>
                    </div> 
                  </form> 
                  <?php     
    if(isset($_POST['add_user'])){ 
      $user = new userModel(); 
      if($user->userexist(strip_tags($_POST['Email']))!=null){ ?>
      <script>swal("Employee Exist!","Employee Already Exist ","warning")</script>
     <?php
      }else{ 
        if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
            $state_logo=0;   
            }else   {  
                $state_logo=1;
                $checkimage=0; 
                $typeimage=0;
                $checkexistedeja=0; 
                $fin=0;
                $target_dir = "../views/img/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]); 
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                // Check CFE image file is a actual image or fake image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                    } else  {
                    $checkimage =1;
                    $uploadOk = 0;
                    }  
                     if (file_exists($target_file)) {    $checkexistedeja=1;  $uploadOk = 0;   }
                        // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"  
                     && $imageFileType != "if" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG"  
                     && $imageFileType != "IF" ) {
                        $typeimage = 1;    $uploadOk = 0;
                        }
                        // Check CFE $uploadOk is set to 0 by an error
                        if ($uploadOk == 1) { 
                              $u=new userModel();   
                              $ImageName=(string)$u->controle_counter()+1;   
                                $target_file = $target_dir . basename($_FILES["image"]["name"]);  
                          if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) { 
                            //fr
                                   $ImageNamee=$ImageName."-".rand(1,100);
                                $target_file2= $target_dir . basename($ImageNamee.".".$imageFileType); 
                                   rename($target_file,$target_file2);
                                    $nomlogo=$ImageNamee.".".$imageFileType;  
                                //en  
                                $target_dir_ar = "../../../fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar);   
                                 //ar  
                                $target_dir_ar = "../../../arabic/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar);  
                                 //es  
                                $target_dir_ar = "../../../spanish/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar);  
                                 //tr  
                                $target_dir_ar = "../../../turkish/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar);  
                                 //chinese  
                                $target_dir_ar = "../../../chinese/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar); 
                                //russian  
                                $target_dir_ar = "../../../russian/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar); 
                                
                                $target_dir_ar = "../../../indian/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar); 
                                
                                $target_dir_ar = "../../../urdu/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar);
                                
                                $target_dir_ar = "../../../hebrew/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar); 
                                
                                $target_dir_ar = "../../../german/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar); 
                                
                                $target_dir_ar = "../../../japanese/fyipanel/views/img/";
                                $target_file_ar= $target_dir_ar . basename($ImageNamee.".".$imageFileType); 
                                copy($target_file2,$target_file_ar); 

                                } else {
                                    $fin=1;
                                    $uploadOk = 0;
                                } 
                            }// if 
                            }// upload image  
                            $email=$_POST['Email'];
                            $name=$_POST['First_name']." ".$_POST['Last_name'];
                            $token= userModel::generateNewString();  
                            $user = new userModel(); 
                            $user->setEmail($_POST['Email']);
                            $user->setFirst_name(strip_tags($_POST['First_name']));
                            $user->setLast_name(strip_tags($_POST['Last_name']));
                            $user->setGender(strip_tags($_POST['Gender']));
                            $user->setPassword('');  
                            $user->setFunction(strip_tags($_POST['Function']));
                            $user->setisEmailConfirmed(0);
                            $user->settoken(strip_tags($token)); 
                            if($state_logo==1){ 
                                if($uploadOk==1){ 
                                         $user->setPhoto($nomlogo);    
                                        if(send_link($email, $name,$token)){
                                           //$user->add_admin();
                                           if(!$user->add_user()){ 
                                             echo '<script> swal("User !","User Not Added !","warning");</script>';
                                           }
                                         }
                                    }else{ 
                                            $msg=null;
                                            if($checkimage==1) $msg.='File is not an image\n'; 
                                             if($checkexistedeja==1) $msg.='Image Already Exist, Please Change Image Name And Try Again\n'; 
                                            if($typeimage==1) $msg.='Sorry, Just Accept JPG, JPEG, PNG & Gif Format\n'; 
                                            if($fin==1) $msg.='Sorry, Error While Uploading Image.\n'; 
                                            $msg.="User Not Added";  
                                            ?>
                                            <script>
                                                 swal("Attention!","<?php echo $msg;?>","warning")
                                            </script> 
                                        <?php  
                                            }
                                        }else{    
                                         $user->setPhoto('profil.png');    
                                        if(send_link($email, $name,$token)){
                                           //$user->add_admin();
                                           if(!$user->add_user()){ 
                                             echo '<script> swal("User !","User Not Added !","warning");</script>';
                                           }
                                         }
                                          } //state logo  
                                            }
                                     }   ?> 
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

