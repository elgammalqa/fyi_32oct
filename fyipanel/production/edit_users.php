<?php 
session_start();   ob_start(); 
ob_start();
include '../models/user.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{  
      if (count($_COOKIE)>0)  setcookie('fyiplien',"edit_users.php",time()+2592000,"/");
       else   $_SESSION['auth']['lien']="edit_users.php"; 


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
  </head>

  <body class="nav-md" >
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
        <!--        Table              -->
        <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Employees</h2>
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
                          <th class="column-title">Email </th>
                          <th class="column-title">First name </th>
                          <th class="column-title">Last name </th>
                          <th class="column-title">Gender</th> 
                          <th class="column-title">Function </th>
                          <th class="column-title">Edit </th>
                          <th class="column-title">Delete </th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php  
                      $user = new userModel();
                        $query=$user->users(); 
                        foreach($query as $userr){
                          ?>     
                            <tr class="even pointer">
                            <td ><?php echo $userr['Email']; ?></td>
                            <td ><?php echo $userr['First_name']; ?></td>
                            <td ><?php echo $userr['Last_name']; ?></td>
                            <td ><?php echo $userr['Gender']; ?></td> 
                            <td ><?php echo $userr['Function']; ?></td>
                           <form  method="POST">
                           <td class="a-center ">
                            <input type="hidden" name="mail_update" value="<?php echo $userr['Email']; ?>"/> 
                            <button type="submit" class="flat btn btn-primary" name="update_user">Edit</button>
                            </td>
                          </form>
                           <form    method="POST">
                           <td class="a-center ">
                            <input type="hidden" name="mail" value="<?php echo $userr['Email']; ?>"/> 
                            <?php if ($userr['Email']!="code@chatsrun.com"&&$userr['Email']!=$fyipEmail) { ?>
                              <button  class="flat btn btn-danger" name="delete_user">Delete</button>
                          <?php   }else{ ?>
                              <button  disabled="disabled" class="flat btn btn-danger" name="delete_user">Delete</button>
                          <?php   }  ?>
                           
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
        <?php if(isset($_POST['delete_user'])){      ?>
        <script>
            swal({
                    title: "Are you sure?",
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
                        window.location = 'deleteEmployee.php?id=<?php echo $_POST['mail'];?>';
                    } else {
                        swal("Cancellation successfully", "your registration is out of risk", "info");
                    }
                });

    </script>
        <?php }   if(isset($_POST['update_user'])){ ?>
       <script> 
       window.location = 'edit_user.php?id=<?php echo $_POST['mail_update'];?>';
       </script>
       <?php  }   ?>


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

