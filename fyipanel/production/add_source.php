<?php 
session_start();   ob_start();   
include '../models/user.model.php';  
include '../../models/utilisateurs.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){ 
        header('Location:lock_screen.php');
    }else{    
      if (count($_COOKIE)>0)  setcookie('fyiplien',"add_source.php",time()+2592000,"/");
       else   $_SESSION['auth']['lien']="add_source.php";  
       
       function source_exsite($source,$type,$country){
       	include '../views/connect.php';
       	 $requete = $con->prepare("SELECT id from rss_sources WHERE source ='".$source."' and 
       	  type ='".$type."' and country ='".$country."' ");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
       return  $tbtwodates ;  
       } 
       function max_id_source(){
       	include '../views/connect.php';
       	 $requete = $con->prepare("SELECT max(id) from rss_sources ");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
       return  $tbtwodates ;  
       } 

       function add_source($source,$type,$country, $twitter){
       	include("../views/connect.php");
       	$id=max_id_source()+1;
           $con->exec('INSERT INTO rss_sources VALUES ('.$id.',"'.$source.'","'.$type.'",1,"'.$country.'","'.$twitter.'")');
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
    
    <script src="js/sweetalert-dev.js"></script>
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
         <!-- top tiles --> 
          <!-- /top tiles --> 
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>add rss source : </h2>
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
                      <label  style="text-align: left" for="middle-name" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                       Source : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12">  
                       <input autocomplete="off" required="required"  name="source" for="middle-name"    class="form-control col-md-5 col-xs-12" placeholder="example bbc ,aljazeera,reteurs, cnn" > 
                      </div> 
                    </div>

                      <div class="form-group">
                          <label  style="text-align: left" for="twitter" class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                              Twitter @: &nbsp;(optional) </label>
                          <div class="col-md-7 col-sm-6 col-xs-12">
                              <input autocomplete="off" name="twitter" class="form-control col-md-5 col-xs-12" placeholder="" >
                              <br>
                              In case of adding the source multiple times for different categories, add the twitter account only once in the desired category
                          </div>
                      </div>

                      <div class="form-group">
                      <label  style="text-align: left" for="middle-name"class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                      Type : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12">  
                       <input autocomplete="off"  required="required" name="type" for="middle-name"   
                       class="form-control col-md-5 col-xs-12" placeholder="should be News or Sports or Arts or General Culture or Technology"> 
                      </div>  
                    </div> 
                      <div class="form-group">
                      <label  style="text-align: left" for="middle-name"class="control-label col-md-2 col-sm-3 col-xs-12 col-md-offset-1 col-sm-offset-1">
                      Country : &nbsp;&nbsp; </label>
                      <div class="col-md-7 col-sm-6 col-xs-12">  
                       <input autocomplete="off"  required="required" name="country" for="middle-name"   
                       class="form-control col-md-5 col-xs-12" placeholder="example United Kingdom,egypt " > 
                      </div>  
                    </div>   
                    </div>        
                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5 col-sm-offset-5">
                        <button name="submit" class="btn btn-success">Add Source </button>
                      </div>
                    </div> 
                  </form>
                  <?php      
                  if(isset($_POST['submit'])){  
                      try {  
                        $source=$_POST['source'];
                        $type=$_POST['type'];
                        $country=$_POST['country'];
                          $twitter=$_POST['twitter'];
                          $types = array("News", "Sports","Arts","Technology", "General Culture", "Economy", "Health");
						if(in_array($type, $types)) {
						if (source_exsite($source,$type,$country)==null) {  
                      		add_source($source,$type,$country, $twitter);  ?>
                      		<script>swal("Source !","Source has been successfully added","success")</script>
                        <?php }else{ ?> 
                    		<script>swal("Source !","Source Already exist !","warning")</script> 
                    	<?php }
						}else{ ?>
							 <script>swal("Type !","Type should be News or Sports or Arts or General Culture or Technology","warning")</script>
						<?php }  
                      } catch (PDOException $e) { ?> 
                        <script>swal("Source !","Source does not added","warning")</script>
                      <?php   
                       }  
					}?> 
                  </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
 
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
<?php  }
 }else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>

