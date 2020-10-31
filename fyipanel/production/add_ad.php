<?php 
session_start();   ob_start(); 
ob_start();
include '../models/user.model.php';  
include '../models/ads.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{   
      if (count($_COOKIE)>0)  setcookie('fyiplien','add_ad.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="add_ad.php"; 

        if (isset($_COOKIE['fyipEmail'])&&!empty($_COOKIE['fyipEmail']))
          $fyipEmail=$_COOKIE['fyipEmail']; 
           else   $fyipEmail=$_SESSION['auth']['Email'];  
               
           $upload_media_msg_error=0; 
           $upload_pdf_msg_error=0; 
             $upload_thumbnail_error=0; 
             $media_will_be_deleted="a";
             $pdf_will_be_deleted="a";
             $thumbnail_will_be_deleted="a";
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
     
    <link href="css/editor.css" type="text/css" rel="stylesheet"/>
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

    <script type="text/javascript" src="tinymce/js/jquery.js"></script>
    <script type="text/javascript" src="tinymce/plugin/tinymce/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce/plugin/tinymce/js/tinymce/init-tinymce.js"></script>  
    <script src="js/sweetalert-dev.js"></script>  

  </head> 
  <body class="nav-md"> 
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col" style="position: fixed;" >
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0; margin-top: 10px;margin-bottom: 10px;">
              <a href="admin.php" class="site_title"><img style="width: 45px; height: 45px; margin-left: 5px; " class="img-circle" src="images/fyi.jpeg" ><span style="margin-left: 15px;" > FYI PRESS </span></a>
            </div>

            <div class="clearfix"></div> 
            <!-- menu profile quick info -->
             <?php require_once('a_menu_profile.php'); ?> 
            <!-- /menu profile quick info -->
             <?php require_once('a_menu.php'); ?>
          </div>
        </div> 

         <!-- top navigation -->
             <?php require_once('a_top_navigation.php'); ?> 
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Add an Ad</h2>
                  <ul class="nav navbar-right panel_toolbox">
                      <li><a style="color: green; font-weight: bold;" target="_blank" href="a_thumbnail_content_add.php">
                      Add preview image to video</a></li> 
                       <li><a></a></li>  
                      <li><a style="color: red; font-weight: bold;" target="_blank" href="linkadmin_ad.php">
                      Add media </a></li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div> 
                <div class="x_content">   
               <form method="POST" id="demo-form2" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left"> 
                    <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">Title <span class="required">*</span>
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required="required" type="text" name="title" id="first-name"   class="form-control col-md-7 col-xs-12">
                      </div> 
                    </div>
                    <div class="form-group">
                     <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">Description 
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  type="text" id="last-name" name="description"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>  
                     <div class="form-group">
                       <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">Media :  
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required="" type="file"  accept="video/*|image/*" id="first-name" name="image"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>

                     <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">
                        Preview image to video :  
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file"  accept="audio/*|video/*|image/*" id="first-name" name="thumbnail"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div> 
                     <div class="form-group"> <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">
                      Pdf :  
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file"  accept="pdf/*" id="first-name" name="pdf"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div> 
                    
                     <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12 col-md-offset-3 col-sm-offset-4" for="first-name">Days 
                      </label>
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12   "
                       for="first-name"> 
                        <input required="required" name="days" size="4"   > 
                      </label> 
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12 " for="first-name">Hours  
                      </label>
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name"> 
                        <input required="required" name="hours" size="4"   > 
                      </label> 
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">Minutes  
                      </label>
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">
                       <input name="minutes" required="required"  size="4"   > 
                      </label> 
                    </div> 
                    <div class="form-group"> 
                      <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="col-lg-12 nopadding">  
                          <textarea  class="tinymce" name="contentx" ></textarea>  
                      </div>
                      </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="button">Cancel</button> 
                        <button  name="submit" class="btn btn-success">Save</button>
                      </div>
                    </div> 
                  </form> 
                       <?php     
    if(isset($_POST['submit'])){   
 
        if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
            $state_logo=0;    
            }else  {  
                $state_logo=1; 
                $typeimage=0;  
                $fin=0;
                $target_dir = "../../ads/image/";
                $target_dir_tmp = "../views/image_tmp/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]); 
                $uploadOk = 1; 
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);  
                        // Allow certain file formats
                    if($imageFileType != "jpg" &&$imageFileType != "JPG" 
                      && $imageFileType != "png"&& $imageFileType != "PNG" 
                      && $imageFileType != "jpeg"&& $imageFileType != "JPEG"  
                    && $imageFileType != "mp4"&& $imageFileType != "MP4"
                    && $imageFileType != "webm"&& $imageFileType != "WEBM" 
                    && $imageFileType != "flv" && $imageFileType != "FLV"
                    && $imageFileType != "mkv"&& $imageFileType != "MKV"
                    && $imageFileType != "mpeg"&& $imageFileType != "MPEG"
                    && $imageFileType != "gif"&& $imageFileType != "GIF" 
                  ) { 
                        $typeimage = 1;    $uploadOk = 0;
                        } 
                        if ($uploadOk == 1) {   
                              $ImageName=(string)adsModel::nbr_ads()+1; 
                                $target_file_tmp = $target_dir_tmp . basename($_FILES["image"]["name"]); 
                                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file_tmp);
                                $existe=true;
                                while($existe==true){
                                   $im=$ImageName."-".rand(1,100).".".$imageFileType;
                                   $target_file2= $target_dir_tmp . basename($im); 
                                   $target_f2= $target_dir.basename($im); 
                                       if (file_exists($target_file2)==false&&file_exists($target_f2)==false) {
                                       rename($target_file_tmp,$target_file2);
                                       copy($target_file2,$target_f2);  
                                       $nomlogo=$im;   
                                       $media_will_be_deleted='../../ads/image/'.$nomlogo;
                                       unlink($target_file2); 
                                       $existe=false;  
                                       } 
                                }// while 
                           } // if
                   }// image loadded 


        if(!isset($_FILES['pdf']) || $_FILES['pdf']['error'] == UPLOAD_ERR_NO_FILE) {
            $state_logopdf=0;
             $uploadOkpdf = 0; 
                 $nomlogopdf="";     
            }else  {  
                $state_logopdf=1;  
                $typeimagepdf=0;  
                 $nomlogopdf=""; 
                $finpdf=0;
                $target_dirpdf = "../../ads/pdf/";
                $target_dir_tmppdf = "../views/image_tmp/";
                $target_filepdf = $target_dirpdf . basename($_FILES["pdf"]["name"]); 
                $uploadOkpdf = 1;
                $imageFileTypepdf = pathinfo($target_filepdf,PATHINFO_EXTENSION);  
                        // Allow certain file formats
                    if($imageFileTypepdf != "pdf"&& $imageFileTypepdf != "PDF") {
                        $typeimagepdf = 1;    $uploadOkpdf = 0;
                        } 
                        if ($uploadOkpdf == 1) {   
                              $ImageNamepdf=(string)adsModel::nbr_ads()+1;    
                                $target_file_tmppdf = $target_dir_tmppdf . basename($_FILES["pdf"]["name"]); 
                                move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file_tmppdf);
                                $existepdf=true;
                                while($existepdf==true){
                                   $impdf=$ImageNamepdf."-".rand(101,200).".".$imageFileTypepdf;
                                   $target_file2pdf= $target_dir_tmppdf . basename($impdf); 
                                   $target_f2pdf= $target_dirpdf.basename($impdf); 
                                       if (file_exists($target_file2pdf)==false&&file_exists($target_f2pdf)==false) {
                                       rename($target_file_tmppdf,$target_file2pdf);
                                       copy($target_file2pdf,$target_f2pdf);  
                                       $nomlogopdf=$impdf;  
                                       $pdf_will_be_deleted='../../ads/pdf/'.$nomlogopdf;
                                       unlink($target_file2pdf); 
                                       $existepdf=false;  
                                       } 
                                }// while 
                           } else{
                            $nomlogopdf=""; 
                           }
                   }// image loadded  
 







        if(!isset($_FILES['thumbnail']) || $_FILES['thumbnail']['error'] == UPLOAD_ERR_NO_FILE) {
            $state_logothumbnail=0;    
            }else  {  
                $state_logothumbnail=1; 
                $typeimagethumbnail=0;  
                $finthumbnail=0;
                $target_dirthumbnail = "../../ads/thumbnails/";
                $target_dir_tmpthumbnail = "../views/image_tmp/";
                $target_filethumbnail = $target_dirthumbnail . basename($_FILES["thumbnail"]["name"]); 
                $uploadOkthumbnail = 1; 
                $imageFileTypethumbnail = pathinfo($target_filethumbnail,PATHINFO_EXTENSION);  
                        // Allow certain file formats
                    if($imageFileTypethumbnail != "jpg" &&$imageFileTypethumbnail != "JPG" 
                      && $imageFileTypethumbnail != "png"&& $imageFileTypethumbnail != "PNG" 
                      && $imageFileTypethumbnail != "jpeg"&& $imageFileTypethumbnail != "JPEG" 
                      && $imageFileTypethumbnail != "gif"&& $imageFileTypethumbnail != "GIF" 
                  ) { 
                        $typeimagethumbnail = 1;    $uploadOkthumbnail = 0;
                        } 
                        if ($uploadOkthumbnail == 1) {   
                              $ImageNamethumbnail=(string)adsModel::nbr_ads_with_thumbnails()+1; 
                                $target_file_tmpthumbnail = $target_dir_tmpthumbnail . basename($_FILES["thumbnail"]["name"]); 
                                move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file_tmpthumbnail);
                                $existethumbnail=true;
                                while($existethumbnail==true){
                                   $imthumbnail=$ImageNamethumbnail."-".rand(1,100).".".$imageFileTypethumbnail;
                                   $target_file2thumbnail= $target_dir_tmpthumbnail . basename($imthumbnail); 
                                   $target_f2thumbnail= $target_dirthumbnail.basename($imthumbnail); 
                                       if (file_exists($target_file2thumbnail)==false&&file_exists($target_f2thumbnail)==false) {
                                       rename($target_file_tmpthumbnail,$target_file2thumbnail);
                                       copy($target_file2thumbnail,$target_f2thumbnail);  
                                       $nomlogothumbnail=$imthumbnail; 
                                     $thumbnail_will_be_deleted='../../ads/thumbnails/'.$nomlogothumbnail;  
                                       unlink($target_file2thumbnail); 
                                       $existethumbnail=false;  
                                       } 
                                }// while 
                           } // if
 
                   }// image loadded 
                     
                            $news = new adsModel(); 
                             $news->settitle(htmlentities( $_POST['title']));
                            $news->setdescription(htmlentities($_POST['description']));
                            $v= str_replace("../../ads/content/","ads/content/",
                              $_POST['contentx']);
                            $contt= str_replace("../../ads/thumbnail_content/","ads/thumbnail_content/",
                              $v);
                            $news->setcontent(htmlentities($contt));
                             date_default_timezone_set('GMT');
                            $news->setpubDate(date("Y-m-d H:i:s"));
                            $findate=($_POST['days']*86400)+($_POST['hours']*3600) 
                            +($_POST['minutes']*60);
                            $news->setfinDate($findate);
                            $news->setemployee($fyipEmail); 
                             

            

                                if($state_logo==1){ 
                                      if($uploadOk==1){ 
                                         $news->setmedia($nomlogo);
                                       }else{
                                          $upload_media_msg_error=1;  
                                       }
                                }else{
                                  $news->setmedia("");
                                }


                              if ($state_logopdf==1) {
                                 if($uploadOkpdf==1){
                                    $news->setpdf($nomlogopdf); 
                                 }else{
                                   $upload_pdf_msg_error=1; 
                                 } 
                              }else{
                                 $news->setpdf(""); 
                              }

                              if ($state_logothumbnail==1) {
                                 if($uploadOkthumbnail==1){
                                   $nomlogothumbnail="ads/thumbnails/".$nomlogothumbnail;
                                    $news->setthumbnail($nomlogothumbnail); 
                                 }else{
                                   $upload_thumbnail_error=1; 
                                 } 
                              }else{
                                 $news->setthumbnail(""); 
                              }


                         if ($upload_pdf_msg_error==0&&$upload_media_msg_error==0&&$upload_thumbnail_error==0) {
                                          $lastid=adsModel::last_id();
                                          $news->add_ad();  
                                           $lastid2=adsModel::last_id();  
                                           if ($lastid!=$lastid2) { 
                                            echo '<script>
                                                 swal("Adding!","Ad has been successfully Added","success");
                                                  </script> ';  
                                           }else echo '<script>
                                                 swal("Attention!","Ad does not added !","warning")
                                                      </script> '; 
                              }else{

                                        if ($upload_pdf_msg_error==1) {
                                          if ($media_will_be_deleted!="a") {
                                           unlink($media_will_be_deleted);
                                          }  
                                          if ($thumbnail_will_be_deleted!="a") {
                                           unlink($thumbnail_will_be_deleted);
                                          }  
                                             $msgpdf=null;  
                                              if($typeimagepdf==1) $msgpdf.='Sorry, Just Accept pdf Format\n'; 
                                              if($finpdf==1) $msgpdf.='Sorry, Error While Uploading File.\n'; 
                                              $msgpdf.="Ad Not Added";   ?>
                                              <script>
                                                   swal("Pdf upload Error!","<?php echo $msgpdf;?>","warning")
                                              </script> 

                                        <?php } 

                                     if ($upload_media_msg_error==1) {
                                      if ($pdf_will_be_deleted!="a") {
                                           unlink($pdf_will_be_deleted);
                                          }  
                                          if ($thumbnail_will_be_deleted!="a") {
                                           unlink($thumbnail_will_be_deleted);
                                          }  
                                           $msg=null;  
                                            if($typeimage==1) $msg.='Sorry, Just Accept jpg, jpeg, png,gif, mp4,flk,mkv,mpeg & webm  Format\n'; 
                                            if($fin==1) $msg.='Sorry, Error While Uploading File.\n'; 
                                            $msg.="Ad Not Added";  
                                            ?>
                                            <script>
                                                 swal("Media upload Error!","<?php echo $msg;?>","warning")
                                            </script> 
                                     <?php   }
                                       if ($upload_thumbnail_error==1) {
                                         if ($media_will_be_deleted!="a") {
                                           unlink($media_will_be_deleted);
                                          }  
                                          if ($pdf_will_be_deleted!="a") {
                                           unlink($pdf_will_be_deleted);
                                          }
                                           $msg=null;  
                                            if($typeimage==1) $msg.='Sorry, Just Accept jpg, jpeg, png & gif Format\n'; 
                                            if($fin==1) $msg.='Sorry, Error While Uploading File.\n'; 
                                            $msg.="Ad Not Added";  
                                            ?>
                                            <script>
                                                 swal("Preview video image Error!","<?php echo $msg;?>","warning")
                                            </script> 
                                     <?php   }

                              }

                          }  ?>  

                </div>
              </div>
            </div>
          </div>
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

    <!-- Custom Theme Scripts --> 
    
    <?php require_once('a_script.php'); ?>
  </body>
</html>
<?php }
}else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>

