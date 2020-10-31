<?php 
session_start();   ob_start();  
ob_start();
include '../models/user.model.php'; 
include '../models/news.model.php'; 
  if(userModel::islogged("Reporter")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{  
       if(isset($_GET["art"])&&!empty($_GET["art"])){ 
       if (count($_COOKIE)>0)  setcookie('fyiplien',"edit_article_r.php?art=".$_GET["art"],time()+2592000,"/");
       else   $_SESSION['auth']['lien']="edit_article_r.php?art=".$_GET["art"];   

        $media_update_msg_error=0; $photo_msg_error=0; 
            $thumbnail_update_msg_error=0; $thumbnail_msg_error=0;  
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
    <style type="text/css">
      @media screen and (min-width: 0px) { 
        .imgg{
          width: 100%;
          height: 40%
        }
         
}
 @media screen and (min-width: 765px) { 
        .tinyy{
          
        }
         
}

    </style>
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
             <?php require_once('r_menu_profile.php'); ?>
            <!-- /menu profile quick info -->

            <br />
            <!-- sidebar menu -->
             <?php require_once('r_menu.php'); ?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
             <?php require_once('r_footer.php'); ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

         <!-- top navigation -->
             <?php require_once('r_top_navigation.php'); ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>View Article</h2>
                  <ul class="nav navbar-right panel_toolbox"> 
                      <li><a style="color: green; font-weight: bold;" target="_blank" href="r_thumbnail_content.php">
                      Add preview image to video</a></li> 
                       <li><a></a></li>  
                    <li><a style="color: red; font-weight: bold;" target="_blank" href="link.php">
                      Add media </a></li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <br />
            
                 <form method="POST" id="demo-form2" enctype="multipart/form-data" data-parsley-validate 
                      class="form-horizontal form-label-left"> 
                           <?php if(isset($_GET["art"])&&!empty($_GET["art"])){ 
                                $news = new newsModel(); 
                                    if($news->findnews($_GET["art"])!=null){
                                      $img=0;
                                      $imgthumbnail=0;
                                      $video=0;
                                      $nomlogo="";
                                    $art=$_GET["art"]; ?>
                    <div class="form-group"> 
                     <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" 
                      for="first-name" >Title 
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" value="<?php echo $news->gettitle();  ?>" name="title" id="first-name"   class="form-control col-md-7 col-xs-12">
                      </div>
                    </div>
                    <div class="form-group">
                       <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="last-name">Description 
                      </label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="last-name" value="<?php echo $news->getdescription();  ?>" name="description"  class="form-control col-md-7 col-xs-12">
                      </div>
                    </div> 

                   <div class="form-group"> 
                    <label  style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" >
                                  Type of the news <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" name="type">
                                    <?php if($news->gettype()=="News"){ ?>
                                    <option selected value="News" >News</option>
                                    <option  value="Arts" >Arts</option>
                                    <option  value="Sports">Sports</option>
                                    <option  value="Technology">Technology</option>
                                    <option  value="General Culture">General Culture</option> 
                                    <?php }else if($news->gettype()=="Arts"){ ?>
                                    <option  value="News" >News</option>
                                    <option selected value="Arts" >Arts</option>
                                    <option  value="Sports">Sports</option>
                                    <option  value="Technology">Technology</option>
                                    <option  value="General Culture">General Culture</option> 
                                    <?php }else if($news->gettype()=="Sports"){ ?>
                                    <option  value="News" >News</option>
                                    <option  value="Arts" >Arts</option>
                                    <option selected value="Sports">Sports</option>
                                    <option  value="Technology">Technology</option>
                                    <option  value="General Culture">General Culture</option> 
                                    <?php }else if($news->gettype()=="Technology"){ ?>
                                    <option  value="News" >News</option>
                                    <option  value="Arts" >Arts</option>
                                    <option  value="Sports">Sports</option>
                                    <option selected value="Technology">Technology</option>
                                    <option  value="General Culture">General Culture</option>
                                    <?php }else if($news->gettype()=="General Culture"){ ?>
                                    <option  value="News" >News</option>
                                    <option  value="Arts" >Arts</option>
                                    <option  value="Sports">Sports</option>
                                    <option  value="Technology">Technology</option>
                                    <option selected value="General Culture">General Culture</option>
                                    <?php  }?>
                                    </select>
                                </div>
                            </div>


                        <?php if ($news->getmedia()!=""){  $img=1;  ?> 
                     <div class="form-group">
                     <label class="control-label col-md-3 col-xs-12" for="first-name"></label>
                                <div class="col-md-6 col-sm-12 col-xs-12">  
                                <label class="control-label col-md-3 col-sm-3 col-xs-9" for="first-name">
                                 </label>  
                              <?php 
                              $typeofmedia =newsModel::typeOfMedia($news->getmedia()); 
                              if ($typeofmedia=="video"||$typeofmedia=="audio") { $video=1; ?>
                                <video class="imgg" controls
                                <?php if ($news->getthumbnail()!=""){ 
                                $imgthumbnail=1; 
                                 $v= str_replace("fyipanel/views/thumbnails/","../views/thumbnails/",$news->getthumbnail());   echo 'poster="'.$v.'"';   }
                                ?>  >
                                  <source src="../views/image_news/<?php echo $news->getmedia(); ?>" type="video/mp4" >
                                </video> 
                          <?php     }else  if ($typeofmedia=="pdf") {?>
                              <img src="../../images/img/pdf.jpg" alt="pdf" >
                           <?php   }else  if ($typeofmedia=="image"){
                                  $dir="../views/image_news/";
                                        //open dir
                                        if($opendir = opendir($dir)){
                                        //read dir
                                        while(($file=readdir($opendir))!==FALSE){
                                        if($file==$news->getmedia()){
                                            echo "<img class='imgg'    alt='avatar' src='$dir/$file'>";
                                            $nomlogo=$news->getmedia();
                                        }  
                                        } 
                                        }
                              }     ?>   
                                </div>
                            </div>
                              
                           <div class="form-group">
                            <label class="control-label col-md-3  col-xs-12" for="first-name"> </label>
                                <div class="col-md-3 col-sm-6 col-xs-12">  
                                  <label class="radio-inline">
                                  <input  type="radio" name="optradio" value="radio_update"  id="type2" onclick="toggleTextbox(this);" >Update Media
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="optradio" value="radio_delete"  id="type1" onclick="toggleTextbox(this);" >Delete Media
                                </label>
                                </div>
                            </div>  
                            <script type="text/javascript">
                                 function toggleTextbox(rdo) { 
                                  if (document.getElementById("type1").checked) {
                                    document.getElementById("name1").disabled=true; 
                                  }else{
                                    document.getElementById("name1").disabled=false;
                                  }

                                   if (document.getElementById("type2").checked) {
                                    document.getElementById("name1").disabled=false; 
                                  }else{
                                    document.getElementById("name1").disabled=true;
                                  }
                               }
                              </script> 
                            <div class="form-group">
                            <label class="control-label col-md-3  col-xs-12" for="first-name"> </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">  
                                 <input disabled="disabled" id="name1" class="form-control col-md-3 col-sm-3 col-xs-9" type="file" name="image"   accept="audio/*|video/*|image/*" >
                                </div>
                            </div>  
                              <?php }else{ ?>  
                           <div class="form-group"> 
                            <label style="text-align: left" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1" for="first-name">Media :  
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="file"  accept="audio/*|video/*|image/*" id="first-name" 
                                  name="photo"  class="form-control col-md-7 col-xs-12">
                                </div>
                              </div> 
                              <?php } 

 
                          if ($imgthumbnail==1&&$video==1) { ?>
                            <div class="form-group">
                              <label class="control-label col-md-3  col-xs-12" for="first-name">
                              </label>
                              <div class="col-md-6 col-sm-12 col-xs-12">  
                                <label class="control-label col-md-3 col-sm-3 col-xs-9" for="first-name">
                                 </label> 
                                 <?php 
                                  $v= str_replace("fyipanel/views/thumbnails/","../views/thumbnails/",
                                    $news->getthumbnail());
                                  echo "<img class='imgg' alt='avatar' src='$v' >";
                                            $nomlogothumbnail=$news->getthumbnail(); ?>
                                   </div>
                              </div>  
                              <div class="form-group">
                            <label class="control-label col-md-3 col-sm-12 col-xs-12" for="first-name"> 
                            </label>
                                <div class="col-md-6 col-sm-12 col-xs-12">  
                                  <label class="radio-inline">
                                  <input  type="radio" name="optradiothumbnail" value="radio_updatethumbnail"  id="type2thumbnail" onclick="toggleTextboxthumbnail(this);" >
                                  Update Preview Image
                                </label>
                                <label class="radio-inline">
                                  <input type="radio" name="optradiothumbnail" value="radio_deletethumbnail"  id="type1thumbnail" onclick="toggleTextboxthumbnail(this);" >Delete Preview Image
                                </label>
                                </div>
                            </div>  
                            <script type="text/javascript">
                                 function toggleTextboxthumbnail(rdo) { 
                                  if (document.getElementById("type1thumbnail").checked) {
                                    document.getElementById("name1thumbnail").disabled=true; 
                                  }else{
                                    document.getElementById("name1thumbnail").disabled=false;
                                  }

                                   if (document.getElementById("type2thumbnail").checked) {
                                    document.getElementById("name1thumbnail").disabled=false; 
                                  }else{
                                    document.getElementById("name1thumbnail").disabled=true;
                                  }
                               }
                              </script> 
                            <div class="form-group">
                            <label class="control-label col-md-3  col-xs-12" for="first-name"> 
                            </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">  
                                 <input disabled="disabled" id="name1thumbnail" class="form-control col-md-3 col-sm-3 col-xs-9" type="file" name="imagethumbnail"  
                                  accept="image/*" >
                                </div>
                            </div>  
                              <?php  }else { ?> 
                              <div class="form-group">
                                <span class="control-label col-md-1   col-xs-12" > </span>
                                <label style="text-align: left" class="control-label col-md-2 col-sm-12 col-xs-12" for="first-name">Preview Image : </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <input type="file"  accept="image/*" id="first-name" 
                                  name="photothumbnail"  class="form-control col-md-7 col-xs-12">
                                </div>
                              </div> 
                              <?php } ?> 
                              <br>
                              <div class="form-group"> 
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-12">  
                                    <textarea class="tinymce tinyy" name="contentx"  >
                                      <?php echo $news->getcontent(); ?></textarea>  
                                </div>
                                </div>
                              </div>
                              <div class="ln_solid"></div>
                              <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <button href="articles_not_sent.php" class="btn btn-primary" type="button">Cancel</button> 
                                  <button  name="update" class="btn btn-success">Update</button>
                                </div>
                              </div>  
                            </form>   
               <?php   
               if(isset($_POST['update'])){
               $nothing=0;   $nothingthumbnail=0; 
                $n = new newsModel(); 
                $n->settitle(htmlentities($_POST['title']));
                $n->setdescription(htmlentities($_POST['description']));
                $n->settype( $_POST['type']);    
                $n->setcontent(htmlentities( $_POST['contentx']));  
 
            if ($img==1){
             if (isset($_POST['optradio'])&&$_POST['optradio']=="radio_update") { 
               if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
            $state_logo=0;   
            }else {  
                $state_logo=1; 
                $typeimage=0;
                $checkexistedeja=0; 
                $fin=0;
                $target_dir = "../views/image_news/";
                $target_dir_tmp = "../views/image_tmp/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]); 
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); 
                $check = getimagesize($_FILES["image"]["tmp_name"]); 

                     if (file_exists($target_file)) {    $checkexistedeja=1;  $uploadOk = 0;   } 
                    if($imageFileType != "jpg" &&$imageFileType != "JPG" && $imageFileType != "png"&& $imageFileType != "PNG" && $imageFileType != "jpeg"&& $imageFileType != "JPEG"  
                     && $imageFileType != "AC-3" && $imageFileType != "ac-3"&& $imageFileType != "mp4"&& $imageFileType != "MP4"&& $imageFileType != "mp3"&& $imageFileType != "MP3"&& $imageFileType != "webm"&& $imageFileType != "WEBM" && $imageFileType != "flv" && $imageFileType != "FLV"&& $imageFileType != "mkv"&& $imageFileType != "MKV"&& $imageFileType != "mpeg"&& $imageFileType != "MPEG" && $imageFileType != "gif"&& $imageFileType != "GIF" && $imageFileType != "PDF"&& $imageFileType != "pdf") {
                        $typeimage = 1;    $uploadOk = 0;
                        } 
 
                        if ($uploadOk == 1) {  
                              $target_file_tmp = $target_dir_tmp . basename($_FILES["image"]["name"]); //tmp file 
                                move_uploaded_file($_FILES["image"]["tmp_name"], $target_file_tmp);//upload to image_tmp file
                                unlink($target_dir."".$news->getmedia());//delete old image
                                $existe=true;
                                while($existe==true){
                                $lastimageName= $news->getmedia();//234.jpg  
                                $lastdot=strrpos($lastimageName,".");//2 
                                $imageName=substr ($lastimageName,0,$lastdot);//234
                                $random=$imageName."-".rand(1,100).".".$imageFileType;//234-50 
                                $target_file2_tmp= $target_dir_tmp . basename( $random);
                                $target_file2= $target_dir . basename( $random);  
                                 if (file_exists($target_file2_tmp)==false&&file_exists($target_file2)==false) {
                                rename($target_file_tmp,$target_file2_tmp); 
                                copy($target_file2_tmp,$target_file2);
                                    unlink( $target_file2_tmp); 
                                    $nomlogo= $random;  
                                     $existe=false;  
                                    }
                                    } //while  
                            }

 
                              if($state_logo==1){ 
                                  if($uploadOk==1){  
                                     $nothing=1;  $n->setmedia($nomlogo);  
                                  }else{  
                                   $nothing=1;   $media_update_msg_error=1;
                                  }
                              }  

                              if ($media_update_msg_error==1) {
                                            $msg=null; 
                                             if($checkexistedeja==1) $msg.='File Already Exist, Please Change File Name And Try Again\n'; 
                                            if($typeimage==1) $msg.='Sorry, Just Accept jpg, jpeg, png,gif, ac-3,mp3,mp4,flk,mkv,mpeg , webm & pdf Format\n';  
                                            if($fin==1) $msg.='Sorry, Error While Uploading file.\n'; 
                                            $msg.="Article Not updated";  ?> 
                                            
                                            <script>
                                                 swal("Update media Error!","<?php echo $msg;?>","warning")
                                            </script>  
                           <?php    }
  
                            } //imageee 
                          }//radio  update
 

                          //media deleted
                          if (isset($_POST['optradio'])&&$_POST['optradio']=="radio_delete") {
                            $nothing=1;
                              try{
                                 unlink("../views/image_news/".$news->getmedia()); 
                                  $nomlogo="";
                                  $n->setmedia($nomlogo);  
                              }catch(Exception $e){  }  
                          }  

                          //media not changed
                          if($nothing==0){   $n->setmedia($news->getmedia()); }   
                              
                }else{// no image  
                $noimage=0;
           if(!isset($_FILES['photo']) || $_FILES['photo']['error'] == UPLOAD_ERR_NO_FILE) {
            $state_logo=0;   
            }else  {  
                $state_logo=1; 
                $typeimage=0;
                $checkexistedeja=0; 
                $fin=0;
                $target_dir = "../views/image_news/";
                $target_dir_tmp = "../views/image_tmp/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]); 
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); 
                $check = getimagesize($_FILES["photo"]["tmp_name"]); 

                     if (file_exists($target_file)) {    $checkexistedeja=1;  $uploadOk = 0;   } 
                     if($imageFileType != "jpg" &&$imageFileType != "JPG" && $imageFileType != "png"&& $imageFileType != "PNG" && $imageFileType != "jpeg"&& $imageFileType != "JPEG"  
                     && $imageFileType != "AC-3" && $imageFileType != "ac-3"&& $imageFileType != "mp4"&& $imageFileType != "MP4"&& $imageFileType != "mp3"&& $imageFileType != "MP3"&& $imageFileType != "webm"&& $imageFileType != "WEBM" && $imageFileType != "flv" && $imageFileType != "FLV"&& $imageFileType != "mkv"&& $imageFileType != "MKV"&& $imageFileType != "mpeg"&& $imageFileType != "MPEG" && $imageFileType != "gif"&& $imageFileType != "GIF" && $imageFileType != "PDF"&& $imageFileType != "pdf") {
                        $typeimage = 1;    $uploadOk = 0;
                        } 
 
                        if ($uploadOk == 1) {    
                                 $target_file_tmp = $target_dir_tmp . basename($_FILES["photo"]["name"]);
                                  //tmp file 
                                move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file_tmp);
                                //upload to image_tmp file 
                                $existe=true;
                                while($existe==true){
                               $imageName=(string)newsModel::nbr_news_with_images()+1;     
                              $random=$imageName."-".rand(101,200).".".$imageFileType;
                                $target_file2_tmp= $target_dir_tmp . basename( $random);
                                $target_file2= $target_dir . basename( $random);  
                                 if (file_exists($target_file2_tmp)==false&&file_exists($target_file2)==false) {
                                rename($target_file_tmp,$target_file2_tmp); 
                                copy($target_file2_tmp,$target_file2);
                                    unlink( $target_file2_tmp); 
                                    $nomphoto= $random;  
                                     $existe=false;  
                                      $noimage=1; 
                                    }
                                    } //while   
                                }

                                if($state_logo==1){ 
                                      if($uploadOk==1){ 
                                         $noimage=1;  $n->setmedia($nomphoto);  
                                      }else{ 
                                             $noimage=1;  $photo_msg_error=1;
                                      }
                                } 

                                 if ($photo_msg_error==1) {
                                   $msg=null; 
                                             if($checkexistedeja==1) $msg.='File Already Exist, Please Change File Name And Try Again\n'; 
                                            if($typeimage==1) $msg.='Sorry, Just Accept jpg, jpeg, png,gif, ac-3,mp3,mp4,flk,mkv,mpeg, webm & pdf Format\n';  
                                            if($fin==1) $msg.='Sorry, Error While Uploading File.\n'; 
                                            $msg.="Article Not Updated";  ?>
                                             <script>
                                                 swal("Add media Error !","<?php echo $msg;?>","warning")
                                            </script>    
                               <?php   } 

                            } //save
                                    
                            if($noimage==0){   $nomphoto="";   $n->setmedia($nomphoto);  }   

                   } // no image  




 

           if($imgthumbnail==1&&$video==1) {
             if (isset($_POST['optradiothumbnail'])&&$_POST['optradiothumbnail']=="radio_updatethumbnail"){ 
               if(!isset($_FILES['imagethumbnail']) || $_FILES['imagethumbnail']['error'] == UPLOAD_ERR_NO_FILE) {
            $state_logothumbnail=0;   
            }else {  
                $state_logothumbnail=1; 
                $typeimagethumbnail=0;
                $checkexistedejathumbnail=0; 
                $finthumbnail=0;
                $target_dirthumbnail = "../views/thumbnails/";
                $target_dir_tmpthumbnail = "../views/image_tmp/";
                $target_filethumbnail = $target_dirthumbnail . basename($_FILES["imagethumbnail"]["name"]); 
                $uploadOkthumbnail = 1;
                $imageFileTypethumbnail = pathinfo($target_filethumbnail,PATHINFO_EXTENSION); 
                $checkthumbnail = getimagesize($_FILES["imagethumbnail"]["tmp_name"]); 

                     if (file_exists($target_filethumbnail)) {    $checkexistedejathumbnail=1; 
                      $uploadOkthumbnail = 0;   } 
                    if($imageFileTypethumbnail != "jpg" &&$imageFileTypethumbnail != "JPG" 
                      && $imageFileTypethumbnail != "png"&& $imageFileTypethumbnail != "PNG"
                       && $imageFileTypethumbnail != "jpeg"&& $imageFileTypethumbnail != "JPEG" 
                      && $imageFileTypethumbnail != "gif"&& $imageFileTypethumbnail != "GIF" ) {
                        $typeimagethumbnail = 1;    $uploadOkthumbnail = 0;
                        } 
 
                        if ($uploadOkthumbnail == 1) {  
                              $target_file_tmpthumbnail = $target_dir_tmpthumbnail .
                               basename($_FILES["imagethumbnail"]["name"]); //tmp file 
                                move_uploaded_file($_FILES["imagethumbnail"]["tmp_name"], $target_file_tmpthumbnail);//upload to image_tmp file
                                $v= str_replace("fyipanel/views/thumbnails/","../views/thumbnails/",
                                $news->getthumbnail());
                                unlink($v);//delete old thumbnail  xxxxx
                                $existethumbnail=true;
                                while($existethumbnail==true){
                                $lastimageNamethumbnail= $news->getthumbnail();
                                //fyipanel/views/thumbnails/234.jpg  
                                $lastdotthumbnail=strrpos($lastimageNamethumbnail,".");//2 
                                $imageNamethumbnail=substr ($lastimageNamethumbnail,0,$lastdotthumbnail);
                                //234
                                $randomthumbnail=$imageNamethumbnail."-".rand(1,100).".".
                                $imageFileTypethumbnail;//234-50 
                                $target_file2_tmpthumbnail= $target_dir_tmpthumbnail .
                                 basename($randomthumbnail);
                                $target_file2thumbnail= $target_dirthumbnail . basename( $randomthumbnail);  
                                 if (file_exists($target_file2_tmpthumbnail)==false&&file_exists($target_file2thumbnail)==false) {
                                rename($target_file_tmpthumbnail,$target_file2_tmpthumbnail); 
                                copy($target_file2_tmpthumbnail,$target_file2thumbnail);
                                    unlink( $target_file2_tmpthumbnail); 
                                    $nomlogothumbnail= $randomthumbnail;  
                                     $existethumbnail=false;  
                                    }
                                    } //while  
                            }

 
                              if($state_logothumbnail==1){ 
                                  if($uploadOkthumbnail==1){  
                                     $nothingthumbnail=1;  $n->setthumbnail($nomlogothumbnail);  
                                  }else{  
                                   $nothingthumbnail=1;   $thumbnail_update_msg_error=1; 
                                  }
                              }  

                              if ($thumbnail_update_msg_error==1) {
                                $msg=null; 
                                             if($checkexistedejathumbnail==1) $msg.='File Already Exist, Please Change File Name And Try Again\n'; 
                                            if($typeimagethumbnail==1) $msg.='Sorry, Just Accept jpg, jpeg, png & gif  Format\n';  
                                            if($finthumbnail==1) $msg.='Sorry, Error While Uploading file.\n'; 
                                            $msg.="Article Not updated"; ?> 
                                            <script>
                                                 swal("update Preview image!","<?php echo $msg;?>","warning")
                                            </script> 
                            <?php   } 
                            } //imageee 
                          }//radio  update
 

                          //media deleted
                          if (isset($_POST['optradiothumbnail'])&&$_POST['optradiothumbnail']=="radio_deletethumbnail") {  
                                $nothingthumbnail=1;
                              try{
                                $v= str_replace("fyipanel/views/thumbnails/","../views/thumbnails/",
                                $news->getthumbnail()); 
                                unlink($v);//delete thumbnail 
                                  $nomlogothumbnail="";
                                  $n->setthumbnail($nomlogothumbnail);  
                              }catch(Exception $e){  }  
                          }  

                          //media not changed
                          if($nothingthumbnail==0){  
                           $n->setthumbnail($news->getthumbnail()); }  

  
    }else {// no thumbnail  
           $noimagethumbnail=0;
           if(!isset($_FILES['photothumbnail']) || $_FILES['photothumbnail']['error'] == UPLOAD_ERR_NO_FILE) {
            $state_logothumbnail=0;   
            }else  {  
                $state_logothumbnail=1; 
                $typeimagethumbnail=0;
                $checkexistedejathumbnail=0; 
                $finthumbnail=0;
                $target_dirthumbnail = "../views/thumbnails/";
                $target_dir_tmpthumbnail = "../views/image_tmp/";
                $target_filethumbnail = $target_dirthumbnail . basename($_FILES["photothumbnail"]["name"]); 
                $uploadOkthumbnail = 1;
                $imageFileTypethumbnail = pathinfo($target_filethumbnail,PATHINFO_EXTENSION); 
                $checkthumbnail = getimagesize($_FILES["photothumbnail"]["tmp_name"]); 

                     if (file_exists($target_filethumbnail)) {    $checkexistedejathumbnail=1;  $uploadOkthumbnail = 0;   } 
                     if($imageFileTypethumbnail != "jpg" &&$imageFileTypethumbnail != "JPG" 
                      && $imageFileTypethumbnail != "png"&& $imageFileTypethumbnail != "PNG" 
                      && $imageFileTypethumbnail != "jpeg"&& $imageFileTypethumbnail != "JPEG"  
                      && $imageFileTypethumbnail != "gif"&& $imageFileTypethumbnail != "GIF" ) {
                        $typeimagethumbnail = 1;    $uploadOkthumbnail = 0;
                        } 
 
                        if ($uploadOkthumbnail == 1) {    
                                 $target_file_tmpthumbnail = $target_dir_tmpthumbnail . basename($_FILES["photothumbnail"]["name"]);
                                  //tmp file 
                                move_uploaded_file($_FILES["photothumbnail"]["tmp_name"], $target_file_tmpthumbnail);
                                //upload to image_tmp file 
                                $existethumbnail=true;
                                while($existethumbnail==true){
                               $imageNamethumbnail=(string)newsModel::nbr_news_with_imagesthumbnail()+1;     
                              $randomthumbnail=$imageNamethumbnail."-".rand(101,200).".".$imageFileTypethumbnail;//2-13.jpg
                                $target_file2_tmpthumbnail= $target_dir_tmpthumbnail . basename( $randomthumbnail);//../views/image_tmp/2-13.jpg
                                $target_file2thumbnail= $target_dirthumbnail . basename( $randomthumbnail); 
                                //../views/thumbnails/2-13.jpg 
                                 if (file_exists($target_file2_tmpthumbnail)==false&&file_exists($target_file2thumbnail)==false) {
                                rename($target_file_tmpthumbnail,$target_file2_tmpthumbnail); 
                                copy($target_file2_tmpthumbnail,$target_file2thumbnail);
                                    unlink( $target_file2_tmpthumbnail); 
                                    $nomphotothumbnail= 'fyipanel/views/thumbnails/'.$randomthumbnail;  
                                     $existethumbnail=false;  
                                      $noimagethumbnail=1; 
                                    }
                                    } //while   
                                }

                                if($state_logothumbnail==1){ 
                                      if($uploadOkthumbnail==1){ 
                                         $noimagethumbnail=1;  $n->setthumbnail($nomphotothumbnail);  
                                      }else{ 
                                             $noimagethumbnail=1;  $thumbnail_msg_error=1;
                                      }
                                } 

                                if ($thumbnail_msg_error==1) {
                                   $msg=null; 
                                             if($checkexistedeja==1) $msg.='File Already Exist, Please Change File Name And Try Again\n'; 
                                            if($typeimage==1) $msg.='Sorry, Just Accept jpg, jpeg, png & gif   Format\n';  
                                            if($fin==1) $msg.='Sorry, Error While Uploading File.\n'; 
                                            $msg.="Article Not Updated"; ?>  
                                          <script>
                                                 swal("Add Preview image Error!","<?php echo $msg;?>","warning")
                                            </script> 
                               <?php } 
                            } //save
                                    
                            if($noimagethumbnail==0){  
                             $nomphotothumbnail="";  
                             $n->setthumbnail($nomphotothumbnail);  
                           }   

                   } // no thumbnail  

 

      if ( $media_update_msg_error==0&&$photo_msg_error==0&&
         $thumbnail_update_msg_error==0 &&$thumbnail_msg_error==0) {
          if ($n->update_news($art)){    
             echo '<script type="text/javascript">  window.location.replace("articles_not_sent.php"); </script>'; 
                }else  echo '<script>  swal("Attention!","Article does not added !","warning"); </script> '; 
          } 
  
              }//update 
            }
        } ?>  
        
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
      <?php require_once('a_script.php'); ?>
   
  </body>
</html>
<?php }}
}else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>

