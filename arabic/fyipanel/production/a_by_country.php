<?php 
session_start();   ob_start();   
ob_start(); 
include '../models/user.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{  
      if (count($_COOKIE)>0)  setcookie('fyiplien','a_by_country.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="a_by_country.php"; 

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
    <link rel="icon" href="images/fyi.jpeg" type="image/ico" />

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

    <!-- <country> -->
    <script src="http://www.marghoobsuleman.com/misc/jquery.js"></script>
<!-- <msdropdown> -->
<link rel="stylesheet" type="text/css" href="country/css/msdropdown/dd.css" />
<script src="country/js/msdropdown/jquery.dd.min.js"></script>
<!-- </msdropdown> -->
<link rel="stylesheet" type="text/css" href="country/css/msdropdown/flags.css" />


    <script src="js/sweetalert-dev.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../js-datepicker/jquery-ui.css">
    <style type="text/css"> 
       @media (max-width: 991.98px) {
        #mobile{
          margin-top: 20px; 
        }
      }
    </style>
 </head>

  <body class="nav-md" style="background: #F7F7F7;">
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
        <div class="right_col" role="main"   >  
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 " >
              <div class="x_panel" >

                    <div class="x_title"> 
                      <h2> Traffic By Country : </h2>
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>  
                      </ul>
                      <div class="clearfix"></div>
                    </div>  
            <form method="post" >
                    <div class="form-group" style="margin-top: 20px; " >  
                      <label  id="mobile"  class="control-label col-md-2 col-sm-12 col-xs-12 col-md-offset-1 "> Country : </label> 
                      <div id="mobile" class="col-md-3   col-sm-12 col-xs-12 "> 
                        <select  name="countries" id="countries"  required="" class="form-control"  >
                        <?php $user=new userModel();
                             $req=$user->countries(); 
                              echo '<option value="Select"> Select Country</option>';
                             foreach ($req as $key) { 
                              $country=$key['country']; 
                              $getcode=userModel::getgeoplugin_countryCode($country); 
                               echo '<option value="'.$country.'" data-image="country/images/msdropdown/icons/blank.gif" data-imagecss="flag '.strtolower ($getcode).'" data-title="'.$country.'">'.$country.'</option>';
                             } 
                         ?> 
                        </select> 
                      </div>   
                     </div>  
                     <button id="mobile" name="search" class="btn btn-success col-md-1 col-sm-12 col-xs-12 col-md-offset-1"> Search </button>
               </form>
                </div> 
            </div> 
       <?php   
       if(isset($_POST['search'])){
          if (isset($_POST['countries'])) {  
            if ($_POST['countries']!="Select") { 
              $countryyy=$_POST['countries'];
              $nb_visitors=userModel::traffic_By_country($countryyy);
              if ($nb_visitors!=null) {    ?>  
           <div style="margin-top: 2%" class="col-md-6 col-sm-12 col-xs-12 col-md-offset-2">
                 <table class="table table-striped jambo_table bulk_action">
                      <thead>
                        <tr class="headings"> 
                          <th class="column-title">Date </th>
                          <th class="column-title"> Visitors </th> 
                        </tr>
                      </thead> 
                      <tbody>
                      <?php  
                      $user = new userModel();
                        $query=$user->visitorsByDayincoutry($countryyy); 
                        foreach($query as $visitor){  ?>     
                            <tr class="even pointer">
                            <td ><?php echo $visitor['date']; ?></td>
                            <td ><?php echo $visitor['nb']; ?></td> 
                            </tr>
                            <?php }  ?>  
                      </tbody>
                      <thead style="" >
                        <tr class="headings"> 
                          <th class="column-title">Total visitors</th>
                          <th class="column-title"><?php echo  $nb_visitors; ?> </th> 
                        </tr>
                      </thead>
                    </table>   
            </div>  
        <?php  
         }else{  echo '<script>swal("No Visitor!","There is No Visitors From '.$countryyy.' ","warning")</script>'; }
         }else{ echo '<script>swal("Select Country!","Select Country ","warning")</script>';  } 
          }   }   ?>   
          </div> 
       </div>
     </div>
  </div> 
    <!-- Custom Theme Scripts --> 
   <script>
$(document).ready(function() {
  $("#countries").msDropdown();
})
</script> 
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
    
  <?php require_once('a_script.php'); ?> 
  </body>
</html>
<?php }
}else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>
