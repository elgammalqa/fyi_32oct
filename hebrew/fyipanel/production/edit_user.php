<?php 
session_start();   ob_start();   
ob_start();
include '../models/user.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{  
      if(isset($_GET["id"])&&!empty($_GET["id"])){

    if (count($_COOKIE)>0)  setcookie('fyiplien',"edit_user.php?id=".$_GET["id"],time()+2592000,"/");
       else   $_SESSION['auth']['lien']="edit_user.php?id=".$_GET["id"];
     
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
    
    <script src="js/sweetalert-dev.js"></script>
	  <link rel="stylesheet" href="css/sweetalert.css"/> 
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col" style="position: fixed;">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0; margin-top: 10px;margin-bottom: 10px;">
              <a href="admin.php" class="site_title"><img style="width: 40px; height: 40px; margin-left: 5px; " class="img-circle" src="images/fyi.jpeg" ><span> FYI PRESS </span></a>
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
          <!-- /top tiles -->

            <!-- top tiles -->


         <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit Employee</h2>
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
                            <?php if(isset($_GET["id"])&&!empty($_GET["id"])){
                              $email_user=$_GET["id"]; 
                                $user = new userModel();
                                  $user->getuser($_GET["id"]);
                                    if($user->getEmail()==$_GET["id"]){
                                    $id=$_GET["id"];
                                ?>
                                <label class="control-label col-md-3 col-sm-6 col-xs-12" for="first-name"></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">  
                                <label class="control-label col-md-3 col-sm-3 col-xs-9" for="first-name"> </label>  
                              <?php 
                                       $dir="../views/img/";
                                        //open dir
                                        if($opendir = opendir($dir)){
                                        //read dir
                                        while(($file=readdir($opendir))!==FALSE){
                                        if($file==$user->getPhoto()){
                                            echo "<img  class='img-circle' alt='avatar'  style='width: 190px; height: 190px;' src='$dir/$file'>";
                                        }  
                                        } 
                                        }
                                        ?>   
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">  
                                 <input id="middle-name" class="form-control col-md-7 col-xs-12" type="file" name="image"  multiple accept="image/*">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input readonly id="middle-name" value="<?php echo $user->getEmail(); ?>" class="form-control col-md-7 col-xs-12" type="Email" name="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="First_name" value="<?php echo $user->getFirst_name(); ?>" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="last-name" value="<?php echo $user->getLast_name(); ?>" name="Last_name" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="Gender">
                                    <?php if($user->getGender()=="Male"){ ?>
                                    <option selected value="Male">Male</option>
                                    <option  value="Female">Female</option>
                                    <?php }else{ ?>
                                    <option  value="Male">Male</option>
                                    <option selected value="Female">Female</option> 
                                  <?php  }?>
                                    </select>
                                </div>
                             </div>   
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <a class="btn btn-primary glyphicon glyphicon-step-backward" href="edit_users.php" ></a>
                                    <button name="save" class="btn btn-success glyphicon glyphicon-floppy-saved"></button>
                                  <a class="btn btn-danger glyphicon glyphicon-remove" href="edit_users.php"></a>
                                </div>
                            </div> 
                                    <?php }} ?>
                        </form>
                                
                </div>

            <!-- /top tiles -->

                  <?php    
           if(isset($_POST['save'])){ 
                            $user = new userModel();
                          $user->getuser($email_user);
                        $user->getEmail();  
                                      // user exist in db
                                              $id_mail=$_GET["id"]; 
                                                        if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
                                                          $photo=$user->getPhoto();
                                                            $state_logo=0;   
                                                            }else  {  
                                                                $state_logo=1;
                                                                $checkimage=0;
                                                                $checkexistedeja=0;
                                                                $typeimage=0;
                                                                $res=0;
                                                                $fin=0;
                                                                $target_dir = "../views/img/";
                                                                $target_file = $target_dir . basename($_FILES["image"]["name"]); 
                                                                $uploadOk = 1;
                                                                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                                                                // Check CFE image file is a actual image or fake image
                                                                $check = getimagesize($_FILES["image"]["tmp_name"]);
                                                                    if($check !== false) {   $uploadOk = 1;   } else   {  $checkimage =1;   $uploadOk = 0;} 
                                                                    // Check CFE file already exists
                                                                    if (file_exists($target_file)) {    $checkexistedeja=1;  $uploadOk = 0;   }
                                                                        // Allow certain file formats
                                                                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"   && $imageFileType != "if" ) {  $typeimage = 1;    $uploadOk = 0;  }
                                                                       
     if ($uploadOk == 0) {    $res= 1; 
                          }else{ 
                         $lastdot=strrpos($user->getPhoto(),".");//1 
                        $ImageName=substr ($user->getPhoto(),0,$lastdot); 
                         $target_file = $target_dir . basename($_FILES["image"]["name"]);

             if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
              //ur
                    unlink($target_dir."".$user->getPhoto());
                    $target_file2= $target_dir . basename($ImageName.".".$imageFileType);
                    rename($target_file,$target_file2);
                    $nomlogo=$ImageName.".".$imageFileType; 
                    //en  
                    $target_dir_ar = "../../../fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar);   
                    //ar 
                    $target_dir_ar = "../../../arabic/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar); 
                    //es 
                    $target_dir_ar = "../../../spanish/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar); 
                    //tr 
                    $target_dir_ar = "../../../turkish/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar); 
                    //chinese 
                    $target_dir_ar = "../../../chinese/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar); 
                    //russian 
                    $target_dir_ar = "../../../russian/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar);
                    
                    $target_dir_ar = "../../../french/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar); 
                    
                    $target_dir_ar = "../../../japanese/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar); 
                    
                    $target_dir_ar = "../../../german/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar); 
                    
                    $target_dir_ar = "../../../indian/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar); 
                    
                    $target_dir_ar = "../../../urdu/fyipanel/views/img/";
                    unlink($target_dir_ar."".$user->getPhoto());
                    $target_file_ar= $target_dir_ar . basename($ImageName.".".$imageFileType); 
                    copy($target_file2,$target_file_ar); 

                    } else {
                        $fin=1;
                         $uploadOk = 0;
                  }
                }
             } // 
                                                            $user = new userModel(); 
                                                            $user->setFirst_name(strip_tags($_POST['First_name']));
                                                            $user->setLast_name(strip_tags($_POST['Last_name']));
                                                            $user->setGender(strip_tags($_POST['Gender']));
                                                                  if($state_logo==1){ 
                                                                          if($uploadOk==1){
                                                                              $user->setPhoto($nomlogo);
                                                                              $user->update_user($id_mail);
                                                                              ?>
                                                                              <script>
                                                                                    swal("Updating!","User has been successfully updated","success");
                                                                                  </script>  
                                                                              <?php
                                                                          
                                                                            }else{ 
                                                                                  $msg=null;
                                                                                  if($checkimage==1) $msg.='File is not an image\n'; 
                                                                                  if($checkexistedeja==1) $msg.='Image Already Exist, Please Change Image Name And Try Again\n';
                                                                                  if($typeimage==1) $msg.='Sorry, Just Accept JPG, JPEG, PNG & Gif Format\n';
                                                                                  if($res==1) $msg.='Image Not Added To Database.\n';
                                                                                  if($fin==1) $msg.='Sorry, Error While Uploading Image.\n'; 
                                                                                  $msg.="User Not Added";  
                                                                                  ?>
                                                                                  <script> 
                                                                                      swal("Attention!","<?php echo $msg;?>","warning")
                                                                                  </script> 
                                                                              <?php 
                                                                         }
                                                                              }else{
                                                                                  $user->setPhoto($photo);
                                                                                  $user->update_user($id_mail);
                                                                                  ?>
                                                                                  <script> 
                                                                                      swal("Updating!","User has been successfully updated","success");
                                                                                  </script>  
                                                                          <?php
                                                                         
                                                                        }  // state logo 1   

              } // end button save clicked           ?>
 

        <!-- footer content -->
        
        <!-- /footer content -->
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
<?php }}}else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>


