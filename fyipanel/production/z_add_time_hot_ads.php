<?php 
session_start();   ob_start();  
include '../models/user.model.php'; 
include '../models/ads.model.php';  
include '../models/news_published.model.php'; 
  if(userModel::islogged("Ads")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{   

      if (count($_COOKIE)>0)  setcookie('fyiplien',"z_add_time_hot_ads.php",time()+2592000,"/");
       else   $_SESSION['auth']['lien']="z_add_time_hot_ads.php"; 
 
 
       if (isset($_COOKIE['fyipEmail'])&&!empty($_COOKIE['fyipEmail'])){
          $fyipEmail=$_COOKIE['fyipEmail'];  
        } else {  
          $fyipEmail=$_SESSION['auth']['Email'];  
        }  

        if(!isset($_GET["id"])||empty($_GET["id"])){
          echo " <script>  window.location.replace('z_edit_delete_hot_ads.php'); </script>";
        }
        $id=$_GET["id"];

        if(!adsModel::check_exist('../views/connect.php','hot_ads','id',$id)){
           echo " <script>  window.location.replace('z_edit_delete_hot_ads.php'); </script>";
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
 

    <!-- Bootstrap -->
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <script src="js/sweetalert-dev.js"></script>
	  <link rel="stylesheet" href="css/sweetalert.css"/> 

    <style type="text/css">
      .red_bold{
        color: red; font-weight: bold;
      }
    </style>

  </head>

  <body class="nav-md" >
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col" style="position: fixed;">
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
                  <h2>Add New Time  -- </h2>
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
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12 " for="first-name">
                        From :  
                      </label>
                      <div class="col-md-2 col-sm-2 col-xs-12"> 
                        <input type="time" required="required" name="from"  class="form-control col-md-2 col-xs-12">
                      </div>
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">
                        To :   
                      </label>
                      <div class="col-md-2 col-sm-2 col-xs-12"> 
                        <input type="time" required="required" name="to"  class="form-control col-md-2 col-xs-12">
                      </div> 
                      <button  name="submit" class="btn btn-success">Add</button> 
                      
                       <a href="z_edit_delete_hot_ads.php"> <button type="button" name="back" class="btn btn-primary">Back  </button></a>
                    </div>   
                  </form> 
                  <?php
 
                   if(isset($_POST['submit'])){
                            $ad_from=$_POST['from'];
                            $ad_to=$_POST['to'];
                            $link='../views/connect.php';
                            date_default_timezone_set('GMT'); 
                            $pubDate = date("Y-m-d H:i:s");
                            if(adsModel::check_time_exist('../views/connect.php',$ad_from,$ad_to)){
                             echo '<script> swal("the time is already taken !","the time is already taken ","warning");</script>';
                            }else{
                                if($ad_from<$ad_to){
                                  if(adsModel::add_times_hot_ads($link,$id,$ad_from,$ad_to,$pubDate,$fyipEmail)){
                                     echo '<script> swal("Time !","The time has been successfully Added ","success");</script>';
                                  }else{
                                    echo '<script> swal("Time !","The time does not added","warning");</script>';
                                  }
                                }else{
                                  echo '<script> swal("Time !","the time (To) should be after The Time (From)","warning");</script>';
                                }
                            } 
                  } ?>
                </div>
              </div>
            </div>
          </div>
        <!--        Table              -->
        <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>All Times</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div> 
                <div class="x_content">
                  <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                      <thead>
                        <tr class="headings"> 
                          <th class="column-title">ID </th>
                          <th class="column-title">Description</th>
                          <th class="column-title">From</th>
                          <th class="column-title">To</th> 
                          <th class="column-title">Employee</th>
                          <th class="column-title">Delete </th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php     
                        //$query=adsModel::get_data('../views/connect.php','times_hot_ads'); 
                        include('../views/connect.php');  
                        $query=$con->query('select *,t.id as time_id from times_hot_ads t,hot_ads h where t.id_add=h.id');
                        while ($value = $query->fetch()){ 
                          $e=news_publishedModel::nameReporter($value['employee']);
                         ?>     
                            <tr class="even pointer"> 
                            <?php if($value['id_add']==$id){ ?>
                              <td class="red_bold" ><?php echo $value['id_add']; ?></td> 
                              <td class="red_bold" ><?php echo $value['description']; ?></td> 
                              <td class="red_bold" ><?php echo $value['ad_from']; ?></td> 
                              <td class="red_bold" ><?php echo $value['ad_to']; ?></td> 
                              <td class="red_bold" ><?php echo $e; ?></td>  
                            <?php }else{ ?>
                              <td ><?php echo $value['id_add']; ?></td> 
                              <td ><?php echo $value['ad_from']; ?></td> 
                              <td ><?php echo $value['ad_to']; ?></td> 
                              <td ><?php echo $e; ?></td> 
                            <?php } ?>
                           <form    method="POST">
                           <td class="a-center ">
                            <input type="hidden" name="id" value="<?php echo $value['time_id']; ?>"/>  
                              <button class="flat btn btn-danger" name="delete_time">Delete</button> 
                            </td> 
                           </form>
                            </tr>
                            <?php }  ?>  
                      </tbody>
                    </table> 
                  </div> 
                </div>
              </div>
            </div>
          <!--        /Table             -->
          </div>
        </div> 
        <!-- /page content -->
        <?php if(isset($_POST['delete_time'])){      ?>
        <script>
            swal({
                    title: "Are you sure? To delete This Time",
                    text: "we can not get this recording Again!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Delete!",
                    cancelButtonText: "No, Cancel!", 
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        swal({
                            type: "success",
                            title: " Successfully deleted",
                            text: "closing in 1 second",
                            timer: 1000,
                            showConfirmButton: false });
                        window.location = 'z_delete_time.php?id_time=<?php echo $_POST["id"];?>&id=<?php echo $_GET["id"];?>';
                    } else {
                        swal("Cancellation successfully", "your registration is out of risk", "info");
                    }
                });

    </script>
        <?php }   ?>  
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
    <!-- jQuery Sparklines -->
    <script src="../../vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
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

