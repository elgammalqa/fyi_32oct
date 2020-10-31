<?php  
session_start();   ob_start();    
include '../models/user.model.php'; 
include '../models/news.model.php'; 
include '../models/news_published.model.php'; 
include '../../timee.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){ 
        header('Location:lock_screen.php');
    }else{  
       if (count($_COOKIE)>0)  setcookie('fyiplien','a_delete_rss.php',time()+2592000,"/");
       else   $_SESSION['auth']['lien']="a_delete_rss.php";  
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
  <link rel="stylesheet" href="bootstrap/css/dataTables.bootstrap.css" type="text/css"/>
  <link rel="stylesheet" type="text/css" href="../../vendors/tables.css">
  </head>

  <body class="nav-md" style="background: #F7F7F7;" >
    <div class="container body">
      <div class="main_container"> 
            <div class="col-md-3 left_col" style="position: fixed; " style="background:#2A3F54; position: fixed;   " >
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
            <div class="page-title">
              <div class="title_left">
                <h3>  <small> </small></h3>
              </div> 
              <div class="title_right">
                <div class="col-md-10 col-sm-12 col-xs-12 form-group pull-right top_search">
                 <form method="POST" >
                    <div class="input-group">
                    <input type="text" class="form-control" autocomplete="off" name="txt_search" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" name="btn_search" type="submit">Go!</button>
                    </span>
                  </div>
                 </form>
                </div>
              </div>
            </div>
            <?php if(isset($_POST['btn_search'])&&isset($_POST['txt_search'])&&!empty($_POST['txt_search'])){ ?>
              <script type="text/javascript">
                  window.location = 'a_delete_rss.php?q=<?php echo $_POST['txt_search'];?>&n=1';
              </script> 
            <?php  } ?>
        <!--        Table              -->
        <div class="col-md-12 col-sm-12 col-xs-12"> 
              <div class="x_panel">
                <div class="x_title">
                  <h2>Rss : </h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li> 
                 
                  </ul>
                  <div class="clearfix"></div>
                </div>





        <?php if(isset($_GET['n'])&&!empty($_GET['n'])&&!isset($_GET['q'])){ // id and num page existe     
                $numpage=$_GET['n'];   
                $newspub = new news_publishedModel();
                $nbrfeeds= $newspub->nbrRssTotal();
                $nbrpages=ceil($nbrfeeds/10); 
                if ($numpage>=1&&$numpage<=$nbrpages) {   ?>
                <div class="x_content">  
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings"> 
                            <th class="column-title">Title </th>
                            <th class="column-title">Source</th>
                            <th class="column-title">Type</th>
                            <th class="column-title">Date</th>
                            <th class="column-title">Delete</th>  
                          </tr>
                        </thead> 
 
                        <tbody>  
              <?php $start=$numpage*10-10;//0
                  if ($nbrfeeds-$start>=10) {//25 
                    $req=$newspub->getspecialfeeds($start,10);
                    foreach($req as $news){  
              ?>  
                            <tr class="odd pointer"> 
                            <td ><?php echo $news['title']; ?></td> 
                            <td ><?php echo $news['source']; ?></td>
                            <td ><?php echo $news['type']; ?></td> 
                            <td ><?php echo $news['pubDate'].' GMT '; ?></td>  
                            <td> <form  method="POST">   
                            <input type="hidden" name="id_del" value="<?php echo $news['id']; ?>"/><button  class="flat btn btn-danger" name="delete_rss">Delete 
                            </button>   </form>
                            </td>
                              </tr>
                  <?php }
                  }else{
                  $req=$newspub->getspecialfeeds($start,$nbrfeeds-$start);
                  foreach($req as $news){ ?>
                      <tr class="odd pointer"> 
                            <td ><?php echo $news['title']; ?></td> 
                            <td ><?php echo $news['source']; ?></td>
                            <td ><?php echo $news['type']; ?></td> 
                            <td ><?php echo $news['pubDate'].' GMT '; ?></td>  
                            <td> <form  method="POST">   
                            <input type="hidden" name="id_del" value="<?php echo $news['id']; ?>"/> 
                            <button  class="flat btn btn-danger" name="delete_rss">Delete 
                            </button>   </form>
                            </td>
                              </tr>

                <?php  } } //else ?>

                        </tbody>
                      </table>  
                        <div class="btn-toolbar"> 
                          <div class="btn-group">
                 <?php
                  if($numpage%10==0){
                    $startpage=((floor($numpage/10)-1)*10)+1;
                    }else{
                    $startpage=(floor($numpage/10)*10)+1;
                  }   

                  //before
                  if($numpage<=10){ ?>
                     <a style="display: none;" href="a_delete_rss.php?n=<?php  echo $startpage-1; ?>">
                    <button  class="btn btn-success" type="button"><</button>
                    </a> 
                  <?php }else{ ?>
                     <a href="a_delete_rss.php?n=<?php  echo $startpage-1; ?>">
                    <button  class="btn btn-success" type="button"><</button> 
                  </a>
                  <?php }  
                  $a=floor(($numpage-1)/10)*10;
                  if($nbrpages-$a<=10){
                    $a=ceil($numpage/10)*10;
                    $endpage=$a-($a-$nbrpages); 
                  }else{
                    $endpage=ceil($numpage/10)*10;
                  }

                  //for
                  for ($i=$startpage; $i <=$endpage; $i++) { 
                    if($numpage==$i){ ?> 
                  <a href="a_delete_rss.php?n=<?php  echo $i; ?>">
                    <button class="btn btn-info active" type="button"><?php echo $i; ?></button>
                  </a>
                  <?php }else{ ?>
                  <a href="a_delete_rss.php?n=<?php  echo $i; ?>">
                    <button class="btn btn-info" type="button"><?php echo $i; ?></button>
                  </a>
                  <?php } } 

                  //next
                    if (ceil($nbrpages/10)>ceil($numpage/10)) {  ?> 
                     <a  href="a_delete_rss.php?n=<?php  echo $endpage+1; ?>">
                        <button  class="btn btn-success" type="button">></button>
                      </a>
                    <?php }else{ ?> 
                     <a style="display: none;" href="a_delete_rss.php?n=<?php  echo $endpage+1; ?>">
                      <button  class="btn btn-success" type="button">></button>
                    </a>
                      <?php } 

                      //last page
                       if($nbrpages>10&&$numpage==$nbrpages){ ?>  
                        <a href="a_delete_rss.php?n=<?php  echo $nbrpages; ?>">
                          <button class="btn btn-warning active" type="button">
                         <?php echo $nbrpages; ?> 
                        </button></a>
                      <?php }else{ ?>
                       <a href="a_delete_rss.php?n=<?php  echo $nbrpages; ?>">
                        <button class="btn btn-warning" type="button"> 
                        <?php echo $nbrpages; ?>
                       </button></a>
                   <?php   } ?>
        
                          </div>
                        </div> 
                    </div> 
                  </div>  <!-- xcontent -->


 <?php }}else if(isset($_GET['n'])&&!empty($_GET['n'])&&isset($_GET['q'])&&!empty($_GET['q'])){ //searchq 
   $numpage=$_GET['n'];   
   $q=$_GET['q'];
                $newspub = new news_publishedModel();
                $nbrfeeds= $newspub->nbrRssTotalq($q);
                $nbrpages=ceil($nbrfeeds/10); 
                if ($numpage>=1&&$numpage<=$nbrpages) {   ?>
                <div class="x_content">  
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings"> 
                            <th class="column-title">Title </th>
                            <th class="column-title">Source</th>
                            <th class="column-title">Type</th>
                            <th class="column-title">Date</th>
                            <th class="column-title">Delete</th>  
                          </tr>
                        </thead> 
 
                        <tbody>  
              <?php $start=$numpage*10-10;//0
                  if ($nbrfeeds-$start>=10) {//25 
                    $req=$newspub->getspecialfeedsq($q,$start,10);
                    foreach($req as $news){  
              ?>  
                            <tr class="odd pointer"> 
                            <td ><?php echo $news['title']; ?></td> 
                            <td ><?php echo $news['source']; ?></td>
                            <td ><?php echo $news['type']; ?></td> 
                            <td ><?php echo $news['pubDate'].' GMT '; ?></td>  
                            <td> <form  method="POST">   
                            <input type="hidden" name="id_del" value="<?php echo $news['id']; ?>"/> 
                            <button  class="flat btn btn-danger" name="delete_rss">Delete 
                            </button>   </form>
                            </td>
                              </tr>
                  <?php }
                  }else{ 
                  $req=$newspub->getspecialfeedsq($q,$start,$nbrfeeds-$start);
                  foreach($req as $news){ ?>
                      <tr class="odd pointer"> 
                            <td ><?php echo $news['title']; ?></td> 
                            <td ><?php echo $news['source']; ?></td>
                            <td ><?php echo $news['type']; ?></td> 
                            <td ><?php echo $news['pubDate'].' GMT '; ?></td>  
                            <td> <form  method="POST">   
                            <input type="hidden" name="id_del" value="<?php echo $news['id']; ?>"/> 
                            <button  class="flat btn btn-danger" name="delete_rss">Delete 
                            </button>   </form>
                            </td>
                              </tr>

                <?php  } } //else ?>

                        </tbody>
                      </table>  
                        <div class="btn-toolbar"> 
                          <div class="btn-group">
                 <?php
                  if($numpage%10==0){
                    $startpage=((floor($numpage/10)-1)*10)+1;
                    }else{
                    $startpage=(floor($numpage/10)*10)+1;
                  }   

                  //before
                  if($numpage<=10){ ?>
                     <a style="display: none;" href="a_delete_rss.php?q=<?php echo $q; ?>&n=<?php  echo $startpage-1; ?>">
                    <button  class="btn btn-success" type="button"><</button>
                    </a> 
                  <?php }else{ ?>
                     <a href="a_delete_rss.php?q=<?php echo $q; ?>&n=<?php  echo $startpage-1; ?>">
                    <button  class="btn btn-success" type="button"><</button> 
                  </a>
                  <?php }  
                  $a=floor(($numpage-1)/10)*10;
                  if($nbrpages-$a<=10){
                    $a=ceil($numpage/10)*10;
                    $endpage=$a-($a-$nbrpages); 
                  }else{
                    $endpage=ceil($numpage/10)*10;
                  }

                  //for
                  for ($i=$startpage; $i <=$endpage; $i++) { 
                    if($numpage==$i){ ?> 
                  <a href="a_delete_rss.php?q=<?php echo $q; ?>&n=<?php  echo $i; ?>">
                    <button class="btn btn-info active" type="button"><?php echo $i; ?></button>
                  </a>
                  <?php }else{ ?>
                  <a href="a_delete_rss.php?q=<?php echo $q; ?>&n=<?php  echo $i; ?>">
                    <button class="btn btn-info" type="button"><?php echo $i; ?></button>
                  </a>
                  <?php } } 
 
                  //next
                    if (ceil($nbrpages/10)>ceil($numpage/10)) {  ?> 
                     <a  href="a_delete_rss.php?q=<?php echo $q; ?>&n=<?php  echo $endpage+1; ?>">
                        <button  class="btn btn-success" type="button">></button>
                      </a>
                    <?php }else{ ?> 
                     <a style="display: none;" href="a_delete_rss.php?q=<?php echo $q; ?>&n=<?php  echo $endpage+1; ?>">
                      <button  class="btn btn-success" type="button">></button>
                    </a>
                      <?php } 

                      //last page
                       if($nbrpages>10&&$numpage==$nbrpages){ ?>  
                        <a href="a_delete_rss.php?q=<?php echo $q; ?>&n=<?php  echo $nbrpages; ?>">
                          <button class="btn btn-warning active" type="button">
                         <?php echo $nbrpages; ?> 
                        </button></a>
                      <?php }else{ ?>
                       <a href="a_delete_rss.php?q=<?php echo $q; ?>&n=<?php  echo $nbrpages; ?>">
                        <button class="btn btn-warning" type="button"> 
                        <?php echo $nbrpages; ?>
                       </button></a>
                   <?php   } ?>
        
                          </div>
                        </div> 
                    </div> 
                  </div>  <!-- xcontent --> 
<?php }else{ //no result for this search ?>
  <h3> There was no search results </h3>
  
<?php } }//else if ?>


              </div>
            </div>
          <!--        /Table             -->
          </div> 
        <!-- /page content -->























      <?php   if(isset($_POST['delete_rss'])){      ?>
        <script>
            swal({ 
                    title: "Are you sure ?",
                    text: "we can not get this Article Again!",
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
                        window.location = 'a_del_rss.php?id_del=<?php echo $_POST['id_del'];?>';
                    } else {
                        swal("Cancellation successfully", "your Article is out of risk", "info");
                    }
                });

    </script>
        <?php }  ?>
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


  <!-- <script src="../../asset/js/jquery.js"></script> -->
  <script src="../../asset/js/jquery-1.8.3.min.js"></script>
  <script src="../../asset/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="../../asset/js/jquery.dcjqaccordion.2.7.js"></script>
  <script src="../../asset/js/jquery.scrollTo.min.js"></script>
  <script src="../../asset/js/jquery.sparkline.js"></script>


  <!--common script for all pages-->
  <script src="../../asset/js/common-scripts.js"></script>

  <script type="text/javascript" src="../../asset/js/gritter/js/jquery.gritter.js"></script>
  <script type="text/javascript" src="../../asset/js/gritter-conf.js"></script>

  <!--script for this page-->
  <script src="../../asset/js/sparkline-chart.js"></script>
  <script src="../../asset/js/zabuto_calendar.js"></script>
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
       }else{ ?>
        <script>
          window.location.replace('index.php');
        </script> 
  <?php  } ?>

