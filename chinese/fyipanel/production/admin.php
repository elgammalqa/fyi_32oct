<?php 
session_start();   ob_start();     
ob_start(); 
include '../models/user.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){
        header('Location:lock_screen.php');
    }else{  
      if (count($_COOKIE)>0)  setcookie('fyiplien','admin.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="admin.php"; 

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



    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'> 
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script>
    jQuery(document).ready(function( $ ) {
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    });
  </script>
 <style type="text/css">
   
   h4{
    margin-left: 10px;
    margin-top: 10px !important;
   }

  div .count{
     font-size: 26px !important;
         font-weight: 10 !important;
  } 
 
   .tile-stats .icon i { 
    font-size: 40px;  
  }
  .tile-stats .icon {
    top:5px !important; 
    right:20px !important;
    width:15px !important;
  }

   .fsize{
     font-size: 16px !important;
   }
   div .animated{
   padding-top: 7px;
   }
    .icon .fa {
    font-size: 25px !important;
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
        <div class="right_col" role="main"  >
          <!-- top tiles --> 
            <div class="row">
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-user"></i>
                          </div>
                          <div class="count counter">  
                            <?php  if (userModel::total_users()!=0) {
                              echo userModel::total_users();
                            }else{
                              echo "0";
                            }?> 
                          </div>
                          <h4>Total Employees</h4> 
                        </div>
                      </div>


                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-users"></i>
                          </div>
                          <div class="count counter"> 
                           <?php  if (userModel::total_utilisateurs()!=0) {
                              echo userModel::total_utilisateurs();
                            }else{
                              echo "0";
                            }?>   
                          </div> 
                          <h4>Total Users</h4> 
                        </div>
                      </div>
 

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-rss"></i>
                          </div>
                          <div class="count counter" > 
                            <?php  if (userModel::totl_rss()!=0) {
                              echo userModel::totl_rss();
                            }else{
                              echo "0";
                            }?> 
                          </div> 
                          <h4>Total Rss News</h4> 
                        </div>
                      </div>


                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-newspaper-o"></i>
                          </div>
                          <div class="count counter">
                            <?php  if (userModel::totl_news_published()!=0) {
                                echo userModel::totl_news_published();
                              }else{   echo "0";   }?> 
                          </div> 
                          <h4>Total News published</h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-low-vision"></i>
                          </div>
                          <div class="count counter">
                           <?php  if (userModel::totl_news_not_published()!=0) {
                              echo userModel::totl_news_not_published();
                            }else{   echo "0";   }?>
                          </div>
                          <h4>news not published</h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-list"></i>
                          </div>
                          <div class="count counter"> 
                            <?php  if (userModel::getTotalNewsPublishedByEmployee($fyipEmail)!=0) {
                                echo userModel::getTotalNewsPublishedByEmployee($fyipEmail);
                              }else{   echo "0";   }?> 
                          </div>
                          <h4>My news published</h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-paper-plane"></i>
                          </div>
                          <div class="count counter">
                            <?php  if (userModel::getTotalNewsSent($fyipEmail)!=0) {
                              echo userModel::getTotalNewsSent($fyipEmail);
                            }else{   echo "0";   }?> 
                          </div>
                          <h4>My news sent</h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-check"></i>
                          </div>
                          <div class="count counter">
                           <?php  if (userModel::newsipublished($fyipEmail)!=0) {
                              echo userModel::newsipublished($fyipEmail);
                            }else{   echo "0";   }?>              
                            </div>
                          <h4>News i published</h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-laptop"></i>
                          </div>
                          <div class="count counter">
                             <?php  date_default_timezone_set('GMT');
                               $current_time=time();  $timeout=$current_time-(300);  
                                $timeout=date("Y-m-d h:i", $timeout);
                              if (userModel::to_online($timeout)!=0) {
                                echo userModel::to_online($timeout);
                              }else{
                                echo "0";
                              }?>  
                          </div>
                          <h4>Traffic Now</h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-line-chart"></i>
                          </div>
                          <div class="count counter">
                          <?php date_default_timezone_set('GMT');
                              $today=date("Y-m-d"); 
                         if (userModel::nb_total_visitors_by_date($today)!=null) {
                           echo userModel::nb_total_visitors_by_date($today);
                          }else{
                            echo "0";
                          } ?> 
                          </div>
                          <h4> Traffic today</h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-sitemap"></i>
                          </div>
                          <div class="count counter">
                            <?php if (userModel::nb_total_visitors_today()!=0) {
                              echo userModel::nb_total_visitors_today();
                            }else{
                              echo 0;
                            } ?>
                          </div>
                          <h4>Website's Traffic</h4> 
                        </div>
                      </div>
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-bar-chart"></i>
                          </div>
                          <div class="count counter">
                            <?php  
                               if (userModel::nb_total_dates()==0)   echo "0";
                                else   echo round(userModel::nb_total_visitors()/userModel::nb_total_dates());
                              ?>
                          </div>
                          <h4>  Average visitors per day </h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-globe"></i>
                          </div>
                          <div class="count">
                            <?php
                            if (userModel::max_country_traffic()!=null) { 
                             echo userModel::max_country_traffic();
                             }else{
                              echo "No Country" ; 
                             } ?>
                          </div>
                          <h4> Max Country traffic </h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-globe"></i>
                          </div>
                          <div class="count">
                                <?php  date_default_timezone_set('GMT');  $today=date("Y-m-d"); 
                                if (userModel::max_country_traffic_today($today)!=null) {
                                 echo userModel::max_country_traffic_today($today);
                                }else{
                                  echo "No Country" ; 
                                }
                               ?>
                          </div>
                          <h4>Max Country traffic Today</h4> 
                        </div>
                      </div> 

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-calendar-check-o"></i>
                          </div>
                          <div class="count">
                             <?php 
                              if (userModel::max_day_traffic()!=null) { 
                              echo userModel::max_day_traffic();
                               }else{
                                  echo "No Date" ;  
                                } ?>
                          </div>
                          <h4>Max day traffic </h4> 
                        </div>
                      </div>


                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-calendar-check-o"></i>
                          </div>
                          <div class="count fsize">
                             <a class="count  fsize"   href="a_two_dates.php"> Two dates</a>
                          </div>
                          <h4> Traffic Between two dates </h4> 
                        </div>
                      </div>
 
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-globe"></i>
                          </div>
                          <div class="count fsize">
                             <a class="count  fsize"    href="a_by_country.php">
                             By Country</a>  
                            </div> 
                          <h4>Traffic By Country</h4> 
                        </div>
                      </div> 

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-calendar-check-o"></i>
                          </div>
                          <div class="count fsize">
                            <a class="count fsize" href="a_by_date.php"> By Date</a>
                         </div> 
                          <h4>Traffic By Date</h4> 
                        </div>
                      </div> 
 
                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats"> 
                          <div class="count fsize"> 
                            <a class="count  fsize"   href="a_by_date_and_country.php">
                                Date & Country</a> 
                          </div> 
                          <h4>Traffic  By Date and Country</h4> 
                        </div>
                      </div>

                      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats"> 
                          <div class="count fsize"> 
                            <a class="count  fsize"   href="a_country_two_dates.php">
                                 Country & 2 dates</a> 
                          </div> 
                          <h4>T By Country & two dates </h4> 
                        </div>
                      </div> 
                    </div>
          </div>
          <!-- /top tiles -->   
      </div>
    </div>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <script src="Counter-Up-master/jquery.counterup.min.js"></script>
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
<?php }
}else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>
