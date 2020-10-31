<?php 
session_start();   ob_start(); 
ob_start();
include '../models/user.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{  
       if (count($_COOKIE)>0)  setcookie('fyiplien','alluser.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="alluser.php"; 
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
 

    <!-- Bootstrap -->
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <style type="text/css">
      @media only screen and (min-width: 600px) {
    .profile_view{
      width: 100%;
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
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>All Employee Informations</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                
                    <?php 
                   
                    $user = new userModel();
                      $query=$user->users();
                        foreach($query as $Employee){
                    ?>  
                      <div class="col-md-6 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i><?php echo $Employee["Function"]; ?></i></h4>
                            <div class="left col-xs-7">
                              <h2><span class="fa fa-user"></span> <?php echo $Employee["First_name"]. ' '. $Employee["Last_name"]; ?></h2>
                              <p><strong><span class="fa fa-transgender fa-1x"></span>  <?php echo $Employee["Gender"]; ?></strong> </p>
                              <ul class="list-unstyled">
                                <li><i class="fa fa-envelope"></i>  <?php echo $Employee["Email"]; ?> </li>
                              </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                            <?php 
                                       $dir="../views/img/";
                                        //open dir
                                        if($opendir = opendir($dir)){
                                        //read dir
                                        while(($file=readdir($opendir))!==FALSE){
                                        if($file==$Employee["Photo"]){
                                            echo "<img   class='img-circle img-responsive' style='width: 100px; height: 100px;' alt='user'  src='$dir/$file'>";
                                        }  
                                        } 
                                        }
                                        ?> 

                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-6 emphasis">
                            </div>
                            <div class="col-xs-12 col-sm-6 emphasis"> 
                               <a  class="btn btn-success btn-xs" href="view_news.php?id=<?php echo $Employee['Email']; ?>" > <i class="fa fa-user "> </i> View Articles </a>  
                               <a  class="btn btn-primary btn-xs" 
                               href="edit_user.php?id=<?php echo $Employee['Email']; ?> " > <i class="fa fa-user"> </i> Edit Profile</a>
                            </div>
                          </div>
                        </div>
                      </div>

                    <?php    } ?>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
      
        <!-- /footer content -->
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

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

      <?php require_once('a_script.php'); ?>
  </body>
</html>
<?php } }else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>
