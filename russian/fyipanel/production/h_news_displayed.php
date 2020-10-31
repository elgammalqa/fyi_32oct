<?php 
session_start();   ob_start(); 
ob_start();
include '../models/user.model.php'; 
include '../models/news.model.php';  
  if(userModel::islogged("Head of Branch")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{   
        if (count($_COOKIE)>0)  setcookie('fyiplien','h_news_displayed.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="h_news_displayed.php";   

       if (isset($_COOKIE['fyipEmail'])&&!empty($_COOKIE['fyipEmail'])){
          $fyipEmail=$_COOKIE['fyipEmail'];  
        } else {  
          $fyipEmail=$_SESSION['auth']['Email'];  
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
              <a href="head.php" class="site_title"><img style="width: 40px; height: 40px; margin-left: 5px; " class="img-circle" src="images/fyi.jpeg" ><span> FYI PRESS </span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
             <?php require_once('h_menu_profile.php'); ?>
            <!-- /menu profile quick info --> 
                   <?php require_once('h_menu.php'); ?>
             <?php require_once('h_footer.php'); ?> 
          </div>
        </div>

        <!-- top navigation -->
             <?php require_once('h_top_navigation.php'); ?> 
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
         <!-- top tiles --> 
          <?php require_once('h_toptiles.php'); ?>
          <!-- /top tiles -->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Change number of news diplayed : </h2>
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
                      <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Number of news diplayed : &nbsp;&nbsp; </label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <label  for="middle-name"   class="form-control col-md-3 col-xs-12" > 
                        <?php   include '../views/connect.php';
                            $requete = $con->prepare('select numberofs from settings where id=1');
                            $requete->execute();
                            $name = $requete->fetchColumn();
                            echo $name;  
                         ?>    
                        </label>  
                      </div> 
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12">Number of news diplayed : <span class="required">*</span></label>
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <select required="required" class="form-control" name="news">
                      <?php 
                      if($name==0) echo '<option selected="true"  value="0">0</option>';
                         else echo '<option  value="0">0</option>'; 
                      if($name==1) echo '<option selected="true"  value="1">1</option>';
                         else echo '<option  value="1">1</option>'; 
                      if($name==2) echo '<option selected="true"  value="2">2</option>';
                         else echo '<option  value="2">2</option>'; 
                      if($name==3) echo '<option selected="true"  value="3">3</option>';
                         else echo '<option  value="3">3</option>'; 
                      if($name==4) echo '<option selected="true"  value="4">4</option>';
                         else echo '<option  value="4">4</option>'; 
                      if($name==5) echo '<option selected="true"  value="5">5</option>';
                         else echo '<option  value="5">5</option>'; 
                      if($name==6) echo '<option selected="true"  value="6">6</option>';
                         else echo '<option  value="6">6</option>'; 
                      if($name==7) echo '<option selected="true"  value="7">7</option>';
                         else echo '<option  value="7">7</option>'; 
                      if($name==8) echo '<option selected="true"  value="8">8</option>';
                         else echo '<option  value="8">8</option>'; 
                      if($name==9) echo '<option selected="true"  value="9">9</option>';
                         else echo '<option  value="9">9</option>'; 
                      if($name==10) echo '<option selected="true"  value="10">10</option>';
                         else echo '<option  value="10">10</option>'; 
                       ?>  
                        </select>
                      </div>
                    </div>  
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button name="add_user" class="btn btn-success">Change </button>
                      </div>
                    </div> 
                  </form>
                  <?php     
                  if(isset($_POST['add_user'])){ 
                    $n=$_POST['news']; 
                      try {   $con->exec('UPDATE settings  set numberofs='.$n.' where id=1'); ?>
                      <script type="text/javascript">
                        window.location.replace('h_news_displayed.php');
                      </script>
                        
                     <?php } catch (PDOException $e) { ?> 
                        <script>swal("Error!","Number does not changed","warning")</script>
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

