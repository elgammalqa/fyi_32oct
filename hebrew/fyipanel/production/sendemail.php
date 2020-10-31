<?php 
session_start();   ob_start();  
 $GLOBALS['nb_media']=0;
 $GLOBALS['nb_media_ok']=0;  
 $GLOBALS['nb_users_sent']=0;  
include '../models/user.model.php';  
include '../../models/utilisateurs.model.php'; 
include '../../../fyipanel/models/v5.comments.php'; 
require('../../../PHPMailer-master/PHPMailerAutoload.php'); 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){ 
        header('Location:lock_screen.php');
    }else{    
      if (count($_COOKIE)>0)  setcookie('fyiplien',"sendemail.php",time()+2592000,"/");
       else   $_SESSION['auth']['lien']="sendemail.php"; 
       function delete_all_files(){
        $folder = '../../attachment';  
      $files = glob($folder . '/*');  
      foreach($files as $file){ 
          if(is_file($file)){  
            unlink($file);  
            } 
            }
       } 
       function  emails($to,$name_user,$name_web_site,$subject,$body,$email_sender,$password_sender,$host,$port,$smtpsecure,$link){   
        $body2="<table border='0; cellspacing='0; cellpadding='0; width='80%' bgcolor='FFFFFF' style='background-color:#ffffff; direction:rtl;'>
        <tbody>  
            <tr style='width:80%' >
              <td style='font-size: 19px;  font-family: Helvetica; line-height: 150%; text-align: right;padding:20px;' >
               $body
          </td> 
      </tr>             
        </tbody>
    </table>";
         
                $mail=new PHPMailer();     
                $mail->IsSmtp();
                $mail->SMTPDebug=0;
                $mail->SMTPAuth=true;
                $mail->SMTPSecure=$smtpsecure;
                $mail->Host=$host; //ftpupload.net
                $mail->Port=$port; //or 587 
                $mail->IsHTML(true);
                $mail->CharSet = 'UTF-8'; 
                $mail->Username=$email_sender;
                $mail->Password=$password_sender; 
                $mail->SetFrom($email_sender,$name_web_site);
                $mail->Subject=$subject;
                $mail->AddAddress($to,$name_user);
                $mail->Body = $body2;  
                $folder = '../../attachment';  
                $files = glob($folder . '/*');  
                foreach($files as $file){ 
                    if(is_file($file)){  
                      $f=$folder.'/'.basename($file);
                      $mail->addAttachment($f);  
                      }
                      }
                if($mail->send()) return true;
                else return false;
              }//funct 
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
              <a href="admin.php" class="site_title"><img style=" width: 45px; height: 45px; margin-left: 5px; " class="img-circle" src="images/fyi.jpeg" ><span style="margin-left: 15px;" > FYI PRESS </span></a>
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
                  <h2>All : <?php echo v5comments::nb_emails(); ?> 
                 Selected : <?php echo v5comments::nb_emails_selected(); ?></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>  
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">  
           <form method="POST" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left" 
           action="<?php echo $_SERVER['PHP_SELF']; ?>" > 
                    <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-1 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" 
                      for="first-name" >Name : <span class="required">*</span>
                      </label>
                      <div class="col-md-9 col-sm-6 col-xs-12">
                        <input style="direction: rtl;" required type="text" placeholder="fyi press , chatsrun ... " name="title" id="first-name"   class="form-control col-md-7 col-xs-12">
                      </div> 
                    </div> 
                    <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-1 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="last-name">
                      Subject : <span class="required">*</span>
                      </label>
                      <div class="col-md-9 col-sm-6 col-xs-12">
                        <input style="direction: rtl;" required type="text" id="last-name" name="subject"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>   
                    <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-1 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="last-name">
                      Body : <span class="required">*</span>
                      </label>
                      <div class="col-md-9 col-sm-6 col-xs-12">
                        <textarea style="direction: rtl;" rows="10" required name="body" class="form-control col-md-7 col-xs-12" ></textarea> 
                      </div>
                    </div>  
                     <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-1 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">Media :  
                      </label>
                      <div class="col-md-9 col-sm-6 col-xs-12">
                        <input multiple type="file"  accept="audio/*|video/*|image/*" id="first-name" name="files[]"  class="form-control col-md-7 col-xs-12 ">
                      </div>
                    </div>   
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-1 col-sm-6 col-xs-12 col-md-offset-6"> 
                        <button  name="submit" class="btn btn-success">Send Emails</button>
                      </div>
                    </div> 
                  </form> 
  <?php if (isset($_POST['submit'])) { 
        $failed=array();   
     if (!empty($_FILES['files']['name'][0])) {
        $files=$_FILES['files']; 
        foreach ($files['name'] as $pos => $file_name) {
          $GLOBALS['nb_media']++; 
          $tmp_file=$files['tmp_name'][$pos];
          $size_file=$files['size'][$pos];
          $error_file=$files['error'][$pos]; 
          $ext_file = pathinfo($file_name, PATHINFO_EXTENSION);  
          $size=ceil($size_file/1048576);
          if($size<=25){  
            $des='../../attachment/'.$file_name;
            if (move_uploaded_file($tmp_file,$des)) {
              $GLOBALS['nb_media_ok']++;
            }
          }else{
            array_push($failed, $file_name); 
          } 
        } 
     }else{
       $GLOBALS['nb_media']++;
         $GLOBALS['nb_media_ok']++;
     }
 
     if($GLOBALS['nb_media']==$GLOBALS['nb_media_ok']&&$GLOBALS['nb_media']!=0){
      $name_web_site=$_POST['title']; $subject=$_POST['subject']; $body=$_POST['body'];
      $smtpsecure=v5comments::info("smtpsecure"); 
      $email_sender=v5comments::info("email");  
      $password_sender=v5comments::info("password"); 
      $host=v5comments::info("host"); 
      $port=v5comments::info("port");   
        $link=v5comments::info("link");    
      $smtpsecure = str_replace(' ', '', $smtpsecure);
      $email_sender = str_replace(' ', '', $email_sender);
      $password_sender = str_replace(' ', '', $password_sender);
      $host = str_replace(' ', '', $host);
      $port = str_replace(' ', '', $port); 
        $link = str_replace(' ', '', $link);
      $qry=v5comments::emails_selected();
      //sent message
      foreach ($qry as $key ) {
        $to=$key['email'];  $name_user=$key['name'];
        if( emails($to,$name_user,$name_web_site,$subject,$body,$email_sender,$password_sender,$host,$port,$smtpsecure,$link)) {
           $GLOBALS['nb_users_sent']++; 
        }else echo 'failed sent to '.$to.'<br>'; 
      } //foreach
      if($GLOBALS['nb_users_sent']==v5comments::nb_emails_selected()){
       echo '<script>swal("Sent"," Message sent successfully to all selected users","success");</script>'; 
            }else{  
               echo '<script>swal("Error","Message not sent successfully to all selected users","warning");</script>'; 
            }
            delete_all_files();
     }else{ 
      delete_all_files();
            if(count($failed)>0){
              $f='';
              foreach ($failed as $key => $value) {
               $f=$f.$value.'\n';
             }
            echo '<script>swal("File Size","'.$f .' is too Large (Max Size 25MB) Files not uploaded","warning");</script>'; 
            }else{
               echo '<script>swal("Error","Files not uploaded","warning");</script>'; 
            }
     }  
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

