<?php 
session_start();   ob_start();

include '../models/user.model.php';  
include '../../models/utilisateurs.model.php'; 
  if(userModel::islogged("Admin")==true){ 
    if(userModel::isLoged_but_un_lock()){ 
        header('Location:lock_screen.php');
    }else{

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
                  <h2>review right of reply: </h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>  
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php

                    function filter_text($x)
                    {
                        $a = trim($x);
                        $a = htmlspecialchars(strip_tags($a), ENT_QUOTES);
                        $a = str_ireplace('include', 'inc_lude', $a);
                        $a = str_ireplace('require', 'req_uire', $a);
                        $a = str_ireplace('cmd=', '_', $a);
                        $a = str_ireplace('--', '_', $a);
                        $a = str_ireplace('union', '_', $a);
                        $a = str_ireplace('.php', '_php', $a);
                        $a = str_ireplace('.js', '_js', $a);
                        $a = str_ireplace('truncate', 'tru__ate', $a);
                        $a = str_ireplace('empty', 'em__y', $a);
                        $a = str_ireplace('alter', 'alt_', $a);
                        $a = str_ireplace('drop', 'dr__', $a);
                        return $a;
                    }

                    include '../views/connect.php';
                    $domain = 'https://www.fyipress.net/';
                    //$domain = 'http://127.0.0.1/fyi/';

                    if(isset($_GET['id'])){
                        $id = (int) $_GET['id'];
                        $stmt = $con->prepare("select *, rss_right_of_reply.status as publish_status from rss_right_of_reply join utilisateurs where rss_right_of_reply.user_email = utilisateurs.email and rss_right_of_reply.id = 
'$id'");
                        $stmt->execute();
                        if($stmt->rowCount() !== 1){
                            echo '<h3>This record doesn\'t exist</h3>';
                        }
                        else{

                        if(isset($_SESSION['saved'])){
                        if($_SESSION['saved'] == 0){
                            ?>
                            <script>
                                swal(" Warning ", 'Error! Please try again' ,'error')
                            </script>
                        <?php
                        }
                        if($_SESSION['saved'] == 1){
                        ?>
                            <script>
                                swal(" Done", 'Success' ,'success')
                            </script>
                            <?php
                        }
                            $_SESSION['saved'] = 3;
                            unset($_SESSION['saved']);
                        }


                        $logged_in_email =  $_COOKIE['fyipEmail'];

                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        $type = '';

                        $news_id = $row['news_id'];
                        if(trim($row['reply_to_link']) == ''){
                            $reply_to_news = true;
                            if($row['tbl'] == 'rss'){
                                $news_published = false;
                                $stmt1 = $con->prepare("select * from rss join rss_sources join sources_not_open where rss.id = '$news_id' and rss.favorite = rss_sources.id and sources_not_open.source = rss_sources.source");
                                $stmt1->execute();
                                if($stmt1->rowCount() == 1){
                                    $external = true; //external link
                                    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

                                }
                                else{
                                    $external = false; //in iframe
                                    $stmt1 = $con->prepare("select * from rss join rss_sources where rss.id = '$news_id' and rss.favorite = rss_sources.id ");
                                    $stmt1->execute();
                                    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                }
                            }

                            else{
                                $news_published = true;
                                $external = false; //in iframe
                                $stmt1 = $con->prepare("select * from news_published where id = '$news_id' ");
                                $stmt1->execute();
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                            }

                            //print_r($row1); exit;

                            $type = $row1['type'];

                        }

                        else{
                            $reply_to_news = false;
                        }

                        if(isset($_POST['handle_reply'])){
                            $publish_status = (int) $_POST['publish'];
                            $feedback = filter_text($_POST['message']);
                            if(isset($_POST['type'])){
                                $type = strip_tags(htmlspecialchars($_POST['type']));
                            }
                            else{
                                $type = 'News';
                            }

                            $mail_feedback_message = '';

                            $published = false;
                            switch ($publish_status){
                                case '1':
                                    $published = true;
                                    $mail_feedback_message = 'זכות התשובה פורסמה';
                                    break;
                                case '0':
                                    $mail_feedback_message = 'זכות התשובה נדחתה';
                            }

                            $reply_id = (int) $_POST['reply_id'];

                            $user_email=$logged_in_email;

                            $time = date("Y-m-d H:i:s");

                            $q = $con->prepare("update rss_right_of_reply set status = '$publish_status', feedback = '$feedback', reviewed_by = '$user_email', reviewed_at = '$time' where id = '$reply_id'");
                            if($q->execute()){

                                if($published){
                                    if($row['uploaded_image'] !== ''){
                                        $media = $row['uploaded_image'];
                                        $watermarksrc=realpath( '../views/image_news/watermark.png' );
                                        $image = imagecreatefromjpeg( '../views/image_news/'.$media );
                                        $logoImage = imagecreatefrompng( $watermarksrc );
                                        imagealphablending( $logoImage, true );
                                        $imageWidth=imagesx($image);
                                        $imageHeight=imagesy($image);
                                        $logoWidth=imagesx($logoImage);
                                        $logoHeight=imagesy($logoImage);
                                        $marge_right = 30;
                                        $marge_bottom = $imageHeight-130;
                                        imagecopy(
                                            $image,
                                            $logoImage,
                                            $imageWidth-$logoWidth-$marge_right, $imageHeight-$logoHeight-$marge_bottom,0, 0, $logoWidth, $logoHeight );

                                        // Set type of image and send the output

                                        @imagepng( $image, '../views/image_news/'.$media );/* save image with watermark */

                                        // Release memory
                                        imagedestroy( $image );
                                        imagedestroy( $logoImage );
                                    }
                                    else{
                                        $media = 'right_of_reply.png';
                                    }

                                    date_default_timezone_set('GMT');
                                    $p_date = date("Y-m-d H:i:s");

                                    $add_news = $con->prepare("insert into news values (NULL , '$row[reply_title]', '', '$type', '$media', '$row[reply]', '$p_date', '$user_email', '-1', '', '$reply_id')");
                                    $add_news->execute();

                                    $add_news = $con->prepare("insert into news_published values (NULL , '$row[reply_title]', '', '$type', '$media', '$row[reply]', '$p_date', '$user_email', '1', '', '$reply_id')");
                                    $add_news->execute();
                                }

                                $smtpsecure=utilisateursModel::info2("smtpsecure");
                                $email_sender=utilisateursModel::info2("email");
                                $password_sender=utilisateursModel::info2("password");
                                $host=utilisateursModel::info2("host");
                                $port=utilisateursModel::info2("port");
                                $link=utilisateursModel::info2("link");

                                $smtpsecure = str_replace(' ', '', $smtpsecure);
                                $email_sender = str_replace(' ', '', $email_sender);
                                $password_sender = str_replace(' ', '', $password_sender);
                                $host = str_replace(' ', '', $host);
                                $port = str_replace(' ', '', $port);
                                $link = str_replace(' ', '', $link);

                                require('../../PHPMailer-master/PHPMailerAutoload.php');
                                $mail=new PHPMailer();
                                $mail->IsSmtp();
                                $mail->SMTPDebug=0;
                                $mail->SMTPAuth=true;
                                $mail->SMTPSecure=$smtpsecure;
                                $mail->Host=$host;
                                $mail->Port=$port; //or 587
                                $mail->IsHTML(true);
                                $mail->CharSet = 'UTF-8';
                                $mail->Username=$email_sender;
                                $mail->Password=$password_sender;
                                $mail->SetFrom($email_sender,"FYI press");
                                $mail->Subject="FYIPress - סקירת זכות התשובה";
                                $name = $row['name'];
                                $mail->AddAddress($row['email'],$name);
                                $mail->Body = "  
                                 <table border='0' cellpadding='0' cellspacing='0'style='margin-left:17%;'  >
                                    <tbody> 
                                        <tr>
                                            <td  >
                                                <a>
                                                   <img src='$link/images/fyipress.png' 
                                                   style='padding:20px; width: 350px; height: 70px;' >
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='font-size: 19px; padding: 20px;  font-family: Helvetica; line-height: 150%; text-align: right;' >
                                               <span style='float:right;' >
                                               שלום    
                                                </span>
                                                <span style='float:right;' >
                                                $name &nbsp;
                                               </span>
                                               <br> <br>
                                               ל- FYIPress      <br><br>
                                               זכות התשובה שלך נבדקה <br>
                                               ".$mail_feedback_message." 
                                                <br>
                                                ".$feedback." <br> 
                                                ".htmlspecialchars_decode($row['reply'])."
                                                <br><br> 
                                               צוות FYIPress     
                                            </td>
                                        </tr> 
                                        <tr>  
                                            <td style='text-align: right; padding: 20px;' >
                                                <a target='_blank' href='$link' style='font-size: 19px;   font-family: Helvetica; line-height: 150%; ' >
                                                בקר באתר שלנו   
                                                </a><br><br>
                                                <span style='font-size: 19px;    font-family: Helvetica;
                                                 line-height: 150%; color: #505050;' >
                                                All right reserved FYIPress       
                                                </span> 
                                            </td>
                                        </tr>           
                                    </tbody> 
                                </table>  
                       ";

                                if ($mail->send()){
                                    $_SESSION['saved'] = 1;
                                }
                                else{
                                    echo 'Saved but email couldn\'t be sent'; exit;
                                }
                                $_SESSION['saved'] = 1;
                            }
                            else{
                                $_SESSION['saved'] = 0;
                            }

                        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

                            ?><meta http-equiv="refresh" content="0;url=<?=$actual_link?>"> <?php

                        }

                        /*if(isset($_SESSION['saved'])){
                            $_SESSION['saved'] = null;
                            unset($_SESSION['saved']);
                        }*/

                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <th>Reply to</th>
                                <td>
                                    <?php
                                    if($reply_to_news){
                                        echo 'الخبر';
                                    }
                                    else{
                                        echo 'رابط آخر';
                                    }
                                    ?>
                                </td>
                            </tr>

                            <?php
                            if($reply_to_news && $type !== ''){
                                ?>
                                <tr>
                                    <th>القسم</th>
                                    <td><?=$type?></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <tr>
                                <th>الرابط</th>
                                <td>
                                    <?php
                                    if($news_published){
                                        ?><a href="<?=$domain?>arabic/detail.php?id=<?=$news_id?>" target="_blank"><?=$row1['title']?></a><?php
                                    }
                                    else{
                                        if($reply_to_news && !$external){
                                            ?><a href="<?=$domain?>arabic/iframe.php?link=<?=$row1['link']?>&id=<?=$news_id?>" target="_blank"><?=$row1['title']?></a><?php
                                        }
                                        elseif($reply_to_news && $external){
                                            ?><a href="<?=$row1['link']?>" target="_blank"><?=$row1['title']?></a><?php
                                        }

                                        elseif(!$reply_to_news){
                                            ?><a href="<?=$row['reply_to_link']?>" target="_blank">Click here to open the link</a><?php
                                        }
                                    }

                                    ?>

                                </td>
                            </tr>

                            <?php
                            if($row['user_image'] !== ''){
                                ?>
                                <tr>
                                    <th>صورة المستخدم</th>
                                    <td><img src="../views/image_news/<?=$row['user_image']?>" style="max-width: 250px;" alt=""></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <?php
                            if($row['uploaded_image'] !== ''){
                                ?>
                                <tr>
                                    <th>صورة الرد</th>
                                    <td><img src="../views/image_news/<?=$row['uploaded_image']?>" style="max-width: 450px;" alt=""></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <?php
                            if($reply_to_news){
                                ?>
                                <tr>
                                    <th>News date</th>
                                    <td><?=$row1['pubDate']?></td>
                                </tr>
                                <?php
                            }
                            ?>

                            <tr>
                                <th>Username</th>
                                <td><?=$row['name']?></td>
                            </tr>
                            <tr>
                                <th>Email address</th>
                                <td><?=$row['email']?></td>
                            </tr>
                            <tr>
                                <th>Phone #</th>
                                <td><?=$row['user_phone']?></td>
                            </tr>

                            <tr>
                                <th>Reply date</th>
                                <td><?=$row['created_at']?></td>
                            </tr>

                            <tr>
                                <th>Title</th>
                                <td><?=$row['reply_title']?></td>
                            </tr>

                            <tr>
                                <th>Message to the mentor</th>
                                <td><?=htmlspecialchars_decode($row['message_to_mentor'])?></td>
                            </tr>

                            <tr>
                                <th>Reply</th>
                                <td class="reply_td"><?=htmlspecialchars_decode($row['reply'])?></td>
                            </tr>

                            <?php
                            if(strlen($row['video']) > 0){
                                ?>
                                <tr>
                                    <th>Video</th>
                                    <td><video src="<?=$row['video']?>" width="600" height="400" controls></video></td>
                                </tr>
                                <?php
                            }
                            ?>
                            
                            <tr>
                                <th>Review status</th>
                                <td><?=($row['reviewed_by'] == '0') ? '<h4><span class="label label-danger">No</span></h4>' : '<h4><span class="label label-success">Yes</span></h4>';?></td>
                            </tr>

                            <?php
                            if($row['reviewed_by'] !== '0'){
                                ?>
                                <tr>
                                    <th>Reviewed by</th>
                                    <td><?=$row['reviewed_by']?></td>
                                </tr>

                                <tr>
                                    <th>Review time</th>
                                    <td><?=$row['reviewed_at']?></td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>

                                        <?php
                                    $stat = $row['publish_status'];
                                        switch ($stat){
                                            case '0':
                                                echo '<h4><span class="label label-danger">Rejected</span></h4>';
                                                break;
                                            case '1':
                                                echo '<h4><span class="label label-success">Published</span></h4>';
                                                break;
                                            case '2':
                                                echo '<h4><span class="label label-default">Pending</span></h4>';
                                                break;
                                        }

                                        ?></td>
                                </tr>

                                <tr>
                                    <th>Feedback</th>
                                    <td><?=$row['feedback']?></td>
                                </tr>
                                <?php
                            }
                            ?>

                        </table>

                        <script src="../../../js/jquery.js"></script>
                        <script>
                            $(function () {
                                $(".reply_td p img").addClass('img-responsive');
                            })
                        </script>

                        <div class="row">
                            <h3>Change status</h3>
                            <div class="col-xs-12">
                                <form action="" method="post">
                                    <?php
                                    if($type !== ''){
                                        ?><input type="hidden" name="type" value="<?=$type?>"><?php
                                    }
                                    ?>
                                    <input type="hidden" name="reply_id" value="<?=$row['id']?>">
                                    <div class="form-group">
                                        <label for="publish">Publish</label>
                                        <select name="publish" id="publish" class="form-control">
                                            <option value="0" <?=($row['publish_status'] == 0) ? 'selected' : ''?>>Rejected</option>
                                            <option value="1" <?=($row['publish_status'] == 1) ? 'selected' : ''?>>Published</option>
                                            <option value="2" <?=($row['publish_status'] == 2) ? 'selected' : ''?>>Pending</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="message">Feedback to the user</label>
                                        <textarea name="message" id="message" class="form-control"></textarea>
                                    </div>

                                    <div class="form-group text-center">
                                        <input type="submit" name="handle_reply" class="btn btn-md btn-primary" value="Save">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }

                    }

                    else{
                        if (isset($_GET['pageno'])) {
                            $pageno = (int)$_GET['pageno'];
                        } else {
                            $pageno = 1;
                        }

                        $no_of_records_per_page = 15;
                        $offset = ($pageno-1) * $no_of_records_per_page;

                        $stmt = $con->prepare("SELECT COUNT(*) as total FROM rss_right_of_reply");
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $total_rows = $row['total'];

                        if($total_rows > 0){
                            $total_pages = ceil($total_rows / $no_of_records_per_page);

                            $stmt = $con->prepare("select * from rss_right_of_reply join utilisateurs where rss_right_of_reply.user_email = utilisateurs.email order by id desc limit $offset , $no_of_records_per_page");
                            $stmt->execute();
                            ?>
                        
                        <div class="row">
                            <div class="col-xs-12"></div>
                        </div>
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Date</th>
                                    <th>By</th>
                                    <th>Reviewed</th>
                                    <th></th>
                                </tr>
                                <?php
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                                    ?>
                                    <tr>
                                        <td><?=$row['created_at']?></td>
                                        <td><?=$row['name']?></td>
                                        <td><?=($row['reviewed_by'] == '0') ? '<h4><span class="label label-danger">No</span></h4>' : '<h4><span class="label label-success">Yes</span></h4>';
                                            ?></td>
                                        <td><a href="a_right_of_reply.php?id=<?=$row['id']?>" class="btn btn-sm btn-primary">View</a></td>
                                    </tr>
                                    <?php
                                    /*print_r($row);
                                    echo '<p>////////////////////////////////////</p>';*/
                                }
                                ?>
                            </table>
                        
                        <div class="row">
                            <div class="col-xs-12">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        for ($x=1; $x<=$total_pages; $x++){
                                            ?> <li class="page-item <?=($pageno == $x) ? 'active' : '';?>"><a class="page-link" href="a_right_of_reply.php?pageno=<?=$x?>"><?=$x?></a></li><?php
                                        }
                                        ?>
                                    </ul>
                                </nav>
                                
                            </div>
                        </div>
                            <?php

                        }
                        else{
                            echo 'No right of reply added yet';
                        }
                    }

                    ?>
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

