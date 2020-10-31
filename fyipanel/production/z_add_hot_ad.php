<?php 
session_start();   ob_start();    
include '../models/user.model.php';  
include '../models/ads.model.php'; 
  if(userModel::islogged("Ads")==true){ 
      
        if (isset($_COOKIE['fyipEmail'])&&!empty($_COOKIE['fyipEmail']))
            $fyipEmail=$_COOKIE['fyipEmail']; 
        else $fyipEmail=$_SESSION['auth']['Email'];  
          

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
              <a href="z_ads.php" class="site_title"><img style="width: 45px; height: 45px; margin-left: 5px; " class="img-circle" src="images/fyi.jpeg" ><span style="margin-left: 15px;" > FYI PRESS </span></a>
            </div>

            <div class="clearfix"></div> 
            <!-- menu profile quick info -->
             <?php require_once('a_menu_profile.php'); ?> 
            <!-- /menu profile quick info -->
             <?php require_once('z_menu.php'); ?>
          </div>
        </div> 

         <!-- top navigation -->
             <?php require_once('z_top_navigation.php'); ?> 
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Add Hot Ad</h2>
                  <ul class="nav navbar-right panel_toolbox">
                      
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div> 
                <div class="x_content">    
               <form method="POST"  enctype="multipart/form-data" data-parsley-validate 
               class="form-horizontal form-label-left"> 
                     <div class="form-group">
                       <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">Image Or Video * :  
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input required type="file"  accept="video/*|image/*" id="first-name" name="image"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div> 
 
                    <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">Link :
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  type="text" name="link" id="first-name"   class="form-control col-md-7 col-xs-12">
                      </div> 
                    </div>  
 
                    <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">Description :
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input name="description" id="first-name"   class="form-control col-md-7 col-xs-12">
                      </div> 
                    </div>  
 
                     <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">
                        Preview image to video :  
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="file"  accept="image/*" id="first-name" name="thumbnail"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>  

                    <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">
                       Stretch Image :  
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                         <select required class="form-control" name="fit">
                          <option value="fill" >Fill</option>
                          <option value="contain" >Contain</option>
                         </select> 
                      </div>
                    </div>   
                     
                     <div class="form-group"> 
                      <label style="text-align: left;" class="control-label col-md-1 col-sm-1 col-xs-12 col-md-offset-3 col-sm-offset-4" for="first-name">Days 
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
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button onclick="location.href='z_ads.php'" class="btn btn-primary" type="button">Cancel</button> 
                        <button  name="submit" class="btn btn-success">Save</button>
                      </div>
                    </div> 
                  </form> 
                       <?php     
                          if(isset($_POST['submit'])){ 
                           $id = adsModel::lastid_hot_ads()+1;
                           $file_status=false; $failed='';$is_video=false;
                            if( isset($_FILES['image'])&& !empty($_FILES['image']['name'])){  
                            $allowed=array('jpg','png','jpeg','mp4','webm','flv','mkv','mpeg','gif');
                             $video=array('mp4','webm','flv','mkv','mpeg');
                             $file_name=$_FILES['image']['name'];
                             $file_tmp=$_FILES['image']['tmp_name'];
                             $file_size=$_FILES['image']['size'];
                             $file_error=$_FILES['image']['error'];
                             $file_ext= explode('.',$file_name); 
                             $file_ext=strtolower(end($file_ext));
                             if(in_array($file_ext,$allowed)){
                              if($file_error===0){ 
                                $filesize = round($file_size / 1024 / 1024, 1);// megabytes with 1 digit 
                                if($filesize<=30){ 
                                  $file_name_new= $id.'_media_'.rand(1,1000).'.'.$file_ext;
                                  $file_destination='../../hot_ads/media/'.$file_name_new;
                                  if(move_uploaded_file($file_tmp, $file_destination)){ 
                                    $file_status=true;
                                    $id_photo=$file_name_new;
                                    if(in_array($file_ext, $video)){
                                      $is_video=true;
                                    }
                                  }else{
                                    //failed
                                    $failed.="[{$file_name}] failed to upload ";
                                  }
                                }else{ 
                                  $failed.="[$file_name] is too large. max = 30MB ,file size=[$file_size]";
                                }
                              }else{
                                $failed.="[$file_name] failed to upload. code error {$file_error}";
                              } 
                             }else{
                              $failed.="[{$file_name}] file extension '{$file_ext}' is not allowed ";
                             }  
                        }
 



                            $file_status2=false; $failed2=''; $id_photo2=''; 
                            if($file_status && $is_video){ //media ok
                            if( isset($_FILES['thumbnail'])&& !empty($_FILES['thumbnail']['name'])){  
                             $allowed2=array('jpg','png','jpeg'); 
                             $file_name2=$_FILES['thumbnail']['name'];
                             $file_tmp2=$_FILES['thumbnail']['tmp_name'];
                             $file_size2=$_FILES['thumbnail']['size'];
                             $file_error2=$_FILES['thumbnail']['error'];
                             $file_ext2= explode('.',$file_name2); 
                             $file_ext2=strtolower(end($file_ext2));
                             if(in_array($file_ext2,$allowed2)){
                              if($file_error2===0){
                                $filesize2 = round($file_size2 / 1024 / 1024, 1);// megabytes with 1 digit 
                                if($filesize2<=20){
                                  $file_name_new2= $id.'_thumbnail_'.rand(1,1000).'.'.$file_ext2;
                                  $file_destination2='../../hot_ads/thumbnail/'.$file_name_new2;
                                  if(move_uploaded_file($file_tmp2, $file_destination2)){ 
                                    $file_status2=true;
                                    $id_photo2=$file_name_new2;
                                  }else{
                                    //failed
                                    $failed2.="[{$file_name2}] failed to upload ";
                                  }
                                }else{ 
                                  $failed2.="[$file_name2] is too large. max = 20MB ,file size=[$file_size2]";
                                }
                              }else{
                                $failed2.="[$file_name2] failed to upload. code error {$file_error2}";
                              } 
                             }else{
                              $failed2.="[{$file_name2}] file extension '{$file_ext2}' is not allowed ";
                             }  
                        }else{
                          $file_status2=true; 
                        }
                      }else if($file_status && !$is_video){
                        $file_status2=true;
                      }   //th ok
   
                     if($file_status&&$file_status2){ 
                        $link=$_POST['link'];   
                        $fit=$_POST['fit']; 
                        $description=$_POST['description']; 
                        if($is_video) $link='';
                        $findate=($_POST['days']*86400)+($_POST['hours']*3600)+($_POST['minutes']*60); 
                        date_default_timezone_set('GMT'); 
                        $pubDate=date("Y-m-d H:i:s");
                        if(adsModel::add_hot_ad($id_photo,$id_photo2,$link,$findate,$fyipEmail,$pubDate,$fit,$description)){
                          echo '<script>swal("Adding!","Ad has been successfully Added","success");</script> ';  
                        }else{ 
                          echo '<script>swal("Attention!","Ad does not added !","warning"); </script> '; 
                        }
                     }else{ 
                          if($file_status){  
                             if (file_exists('../../hot_ads/media/'.$id_photo)) {  
                                unlink('../../hot_ads/media/'.$id_photo);
                             }   
                          if($file_status && $is_video ){
                              if($file_status2){
                                if (file_exists('../../hot_ads/thumbnail/'.$id_photo2)) { 
                                  unlink('../../hot_ads/thumbnail/'.$id_photo2);
                                } 
                              }else{?>
                                <script> swal("Thumbnail!","<?php echo $failed2;?>","warning")  </script>
                       <?php  }
                          }//video 
                           } else {// media not uploaded ?>
                                <script> swal("Media!","<?php echo $failed;?>","warning")  </script>
                          <?php  } 
                    }//not ok    
                  }  
 
                  ?>  

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
<?php 
}else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>

