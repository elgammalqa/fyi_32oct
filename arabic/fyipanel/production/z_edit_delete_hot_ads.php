<?php 
session_start();   ob_start();   
include '../models/user.model.php'; 
include '../models/news.model.php'; 
include '../models/news_published.model.php'; 
include '../models/ads.model.php';  
include '../../timee.php'; 
  if(userModel::islogged("Ads")==true){ 
    
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

  </head>

  <body class="nav-md" style="background: #F7F7F7;" >
    <div class="container body">
      <div class="main_container"> 
            <div class="col-md-3 left_col" style="position: fixed; " style="background:#2A3F54; position: fixed;   " >
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
        <div class="right_col" role="main"  >
        <!--        Table              -->
        <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Hot Ads : </h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
 
                <div class="x_content"> 
                  <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <tr class="headings">    
                                <th >Title</th>   
                                <th >Link</th> 
                                <th >Media</th>
                                <th >Preview</th>
                                <th >Date</th>
                                <th >NB Rep</th>
                                <th >Time remain</th> 
                                <th >Add Time</th>
                                <th >Edit</th> 
                                <th >Delete</th>
                                <th >Views</th>
                                <th >Repeat</th>
                                <th >Rep History</th>
                              </tr>
                            </thead> 
                             <tbody> 
                      <?php     
                        $query=adsModel::get_data('../views/connect.php','hot_ads');
                        date_default_timezone_set('GMT'); 
                        foreach($query as $news){   
                        $rest=($news['finDate'])-(time() - strtotime($news['pubDate']));
                        $days=floor($rest/86400);  
                        $days_=floor($rest/86400);  
                        if($news['status']==0 || $days_ < 0){ 
                          $days=$hours=$minutes=0;
                         }else{
                           $hours=floor($rest/3600)-($days*24);
                           $minutes=floor($rest/60)-(($days*24*60)+($hours*60)); 
                         } 

                        if($news['status']==0 || $days_ < 0){  ?>  
                            <tr style="background-color: red;" >  
                            <?php }else{ ?> 
                            <tr>
                            <?php } ?>
                            <td> <?php echo $news['description']; ?></td>
                            <td>
                              <?php if($news['link']!=null){ ?>
                                <a target="_blank" href="<?php echo $news['link']; ?>">Link</a>
                              <?php } ?>
                            </td>
                            <td>
                                <a target="_blank" href="z_show.php?id=<?php echo $news['media']; ?>&op=hot_media"> 
                                  <button  class="flat btn btn-default"> Show </button>
                                </a>  
                            </td>
                             <td >
                              <?php if($news['thumbnail']!=null){ ?> 
                                  <a target="_blank" href="z_show.php?id=<?php echo $news['thumbnail']; ?>&op=hot_thumbnail"><button  class="flat btn btn-default">Show</button>
                                  </a>  
                              <?php } ?>
                            </td>   
                            <td ><?php echo $news['pubDate']; ?></td>
                            <td ><?php echo $news['nb_rep']; ?></td>
                       
                            <td ><?php echo $days.' d '.$hours.' h '.$minutes.' m'; ?></td> 
                            <td>
                              <?php  if($news['status']==0 || $days_ < 0){  ?> 
                                   <button disabled class="flat btn btn-success">Time</button>
                              <?php } else{?> 
                                <a target="_blank" href="z_add_time_hot_ads.php?id=<?php echo $news['id']; ?>"> 
                                  <button  class="flat btn btn-success">Time</button>
                                </a> 
                              <?php } ?>
                            </td> 
                          <form  method="POST">   
                            <td>
                            <input type="hidden" name="id_ad" value="<?php echo $news['id']; ?>"/> 
                            <button  class="flat btn btn-primary" name="edit_hot_ads">Edit</button>
                            </td>
                           </form>
                          <form  method="POST">   
                            <td>
                            <input type="hidden" name="id_del" value="<?php echo $news['id']; ?>"/> 
                            <button  class="flat btn btn-danger" name="delete_hot_ads">Delete</button>
                            </td> 
                           </form> 
                            <td>
                                <a target="_blank" href="z_hot_ads_views.php?id=<?php echo $news['id']; ?>"> 
                                  <button  class="flat btn btn-success">Views</button>
                                </a>   
                            </td> 
                          <form  method="POST">   
                            <td>
                            <input type="hidden" name="id_rep" value="<?php echo $news['id']; ?>"/> 
                             <?php  if($days_ < 0 || $news['status']==0 ){  ?> 
                              <button  class="flat btn btn-primary" name="rep_hot_ads">Repeat</button>
                            <?php }else { ?>
                               <button disabled class="flat btn btn-primary" name="rep_hot_ads">Repeat</button>
                            <?php } ?>
                            </td>
                           </form>  
                            <td>
                                <a target="_blank" href="z_repetitions.php?id=<?php echo $news['id']; ?>"> 
                                  <button  class="flat btn btn-success">Rep</button>
                                </a>   
                            </td>  
                              </tr>
                            <?php }  ?>  
                      </tbody> 
                    </table>     
                  </div>  
              </div>
            </div> 
          <!--        /Table             -->
          </div> 
        <!-- /page content -->
        
         
      <?php   

 
      if(isset($_POST['edit_hot_ads'])){ ?>
        <script>window.location = 'z_edit_hot_ads.php?id=<?php echo $_POST['id_ad'];?>';</script>
     <?php }

      if(isset($_POST['delete_hot_ads'])){      ?>  
        <script>
            swal({
                    title: "Are you sure ?",
                    text: "we can not get this Ads Again!",
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
                        window.location = 'z_delete_hot_ads.php?id_del=<?php echo $_POST['id_del'];?>';
                    } else {
                        swal("Cancellation successfully", "your Ads is out of risk", "info");
                    }
                });

    </script>
        <?php } 


        if(isset($_POST['rep_hot_ads'])){      ?>  
        <script>
            swal({
                    title: "Are you sure to repeat this ad ?",
                    text: "Are you sure to repeat this ad !",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "Yes, Repeat!",
                    cancelButtonText: "No, Cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, 
                function(isConfirm) {
                    if (isConfirm) {
                        swal({
                            type: "success",
                            title: "ad has been successfully repeated",
                            text: "closing in 1 second",
                            timer: 1000,
                            showConfirmButton: false });
                        window.location = 'z_repeat_hot_ads.php?id_rep=<?php echo $_POST['id_rep'];?>';
                    } else {
                        swal("Cancellation successfully", "your Ads is out of risk", "info");
                    }
                });

    </script>
        <?php }  ?>


        <!-- footer content -->
         
        <!-- /footer content -->
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
<?php  
       }else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>

