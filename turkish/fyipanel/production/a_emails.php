<?php    
session_start();   ob_start();    
include '../models/user.model.php';   
include '../../../fyipanel/models/v5.comments.php';     
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){ 
        header('Location:lock_screen.php');
    }else{  
    if (count($_COOKIE)>0)  setcookie('fyiplien','a_emails.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="a_emails.php";    ?> 
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
    <link href="../../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../../../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
     <script src="js/sweetalert-dev.js"></script>  
    <link rel="stylesheet" href="css/sweetalert.css"/>  
  <link rel="stylesheet" href="bootstrap/css/dataTables.bootstrap.css" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="../../../vendors/tables.css">
  </head>

  <body class="nav-md" style="background: #F7F7F7;" >
    <?php 
                  if (isset($_POST['deselect'])) {   
                   v5comments::select_deselect(0); 
                  } 
                  if(isset($_POST['select'])) {  
                   v5comments::select_deselect(1); 
                  }
                  if(isset($_POST['send'])) {   
                      echo "<script>window.location ='sendemail.php';</script>";   
                  }
                  if(isset($_POST['submit'])) { 
                      if(isset($_POST['users'])) { 
                         v5comments::select_deselect(0); 
                          foreach ($_POST['users'] as $email ) {
                              v5comments::update_users_status(1,$email);
                          }  
                      }else{ 
                          echo '<script> swal("Error!","You Should Select At least one user ","warning");</script>';  
                      }
                  }
    ?>
    <div class="container body">
      <div class="main_container"> 
            <div class="col-md-3 left_col"  style="background:#2A3F54; position: fixed;   " >
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
        <div class="right_col" role="main"  >
        <form method="POST" action="a_emails.php" >  
                <div class="col-md-6 col-md-offset-6 col-sm-12  col-xs-12   form-group " style="margin-top: 20px;">
                  <div class="input-group">
                      <?php  if(v5comments::nb_emails()>0){ ?>
                    <button type="Submit"  class="flat btn btn-success" name="select"> Select All </button> 
                    <button type="Submit" class="flat btn btn-danger" name="deselect"> Deselect All </button>
                    <button type="Submit" class="flat btn btn-default" name="submit"> submit selected </button>
                  <?php }else{ ?>
                    <button disabled type="Submit"  class="flat btn btn-success" name="select"> Select All </button> 
                    <button  disabled type="Submit" class="flat btn btn-danger" name="deselect"> Deselect All </button>
                    <button disabled type="Submit" class="flat btn btn-default" name="submit"> submit selected </button>
                  <?php }?>
                    <?php  if(v5comments::nb_emails_selected()>0){ ?>
                    <button type="Submit" class="flat btn btn-primary" name="send">Send Emails</button> 
                    <?php }else{ ?> 
                    <button disabled type="Submit" class="flat btn btn-primary" name="send">Send Emails</button> 
                    <?php } ?> 
                  </div>  
                  </div> 
           
        <!--        Table              -->
        <div class="col-md-12 col-sm-12 col-xs-12"> 
              <div class="x_panel"> 
                <div class="x_title">  
                   <h2>All : <?php echo v5comments::nb_emails(); ?> 
                 Selected : <?php echo v5comments::nb_emails_selected(); ?></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>  
                  </ul>
                  <div class="clearfix"></div>
                </div> 
                <div class="x_content">  
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings"> 
                            <th class="column-title">Name</th> 
                            <th class="column-title">Email</th> 
                            <th class="column-title">Select</th>    
                          </tr>
                        </thead>  
                        <tbody>  
           <?php $req=v5comments::all_emails();
                  foreach($req as $news){  ?>      
                            <tr class="odd pointer"> 
                              <td><?php echo $news['name']; ?></td> 
                              <td><?php echo $news['email']; ?></td> 
                              <?php if ($news['status']==1){ ?>  
                               <td>
                                <input checked type="checkbox" name="users[]" value="<?php echo $news["email"]; ?>" /></td>
                                 <?php }else{ ?>
                               <td><input type="checkbox" name="users[]" value="<?php echo $news["email"]; ?>" /></td>
                                 <?php } ?>
                            </tr>
                            <?php } ?>     
                        </tbody>
                      </table>   
                    </div> 
                  </div>  <!-- xcontent -->  
              </div>
            </div>
          </form>   
          <!--  /Table -->
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
    <!-- jQuery Sparklines -->
    <script src="../../../vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
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
    <!-- bootstrap-daterangepicker -->
    <script src="../../../vendors/moment/min/moment.min.js"></script>
    <script src="../../../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script> 


  <!-- <script src="../../../asset/js/jquery.js"></script> -->
  <script src="../../../asset/js/jquery-1.8.3.min.js"></script>
  <script src="../../../asset/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="../../../asset/js/jquery.dcjqaccordion.2.7.js"></script>
  <script src="../../../asset/js/jquery.scrollTo.min.js"></script>
  <script src="../../../asset/js/jquery.sparkline.js"></script>


  <!--common script for all pages-->
  <script src="../../../asset/js/common-scripts.js"></script>

  <script type="text/javascript" src="../../../asset/js/gritter/js/jquery.gritter.js"></script>
  <script type="text/javascript" src="../../../asset/js/gritter-conf.js"></script>

  <!--script for this page-->
  <script src="../../../asset/js/sparkline-chart.js"></script>
  <script src="../../../asset/js/zabuto_calendar.js"></script>
  <script src="bootstrap/js/jquery.dataTables.min.js" ></script>

  <script src="bootstrap/js/dataTables.bootstrap.js" ></script>
  <script type="text/javascript">
      $(document).ready(function() {
          $('#example').dataTable();
      } );
  </script>    
  <?php require_once('a_script.php'); ?>   
  </body>
</html>
<?php  }
       }else{  echo "<script> window.location.replace('index.php'); </script>";   } ?>

