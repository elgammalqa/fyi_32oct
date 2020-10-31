<?php  
session_start();   ob_start();

if(isset($_COOKIE['fyiuser_email'])){
	$user_email=$_COOKIE['fyiuser_email'];
}else if(isset($_SESSION['user_auth']['user_email'])){
	$user_email=$_SESSION['user_auth']['user_email'];
}
date_default_timezone_set('GMT');
require_once('models/utilisateurs.model.php');
require_once('models/comments.model.php');
require_once('models/replies.model.php');
require_once('../models/v5.news_published.php');
require_once ('timee.php');    
include 'fyipanel/models/news_published.model.php';
if(utilisateursModel::islogged())
	$log=true; 
else $log=false;   
  
?>   
<!DOCTYPE html>    
<html dir="rtl" lang="ar">  
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script> 
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="icon"   href="images/fyipress.ico">
	<!-- Bootstrap -->
	<link rel="stylesheet" href="../scripts/bootstrap/bootstrap.min.css">
	<!-- IonIcons -->
	<link rel="stylesheet" href="../scripts/ionicons/css/ionicons.min.css">
	<!-- Toast -->
	<link rel="stylesheet" href="../scripts/toast/jquery.toast.min.css">
	<!-- OwlCarousel -->
	<link rel="stylesheet" href="../scripts/owlcarousel/dist/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="../scripts/owlcarousel/dist/assets/owl.theme.default.min.css">
	<!-- Magnific Popup -->
	<link rel="stylesheet" href="../scripts/magnific-popup/dist/magnific-popup.css">
	<link rel="stylesheet" href="../scripts/sweetalert/dist/sweetalert.css">
	<!-- Custom style -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/style2.css">
	<link rel="stylesheet" href="../css/skins/all.css">
	<link rel="stylesheet" href="../css/demo.css">
	<link rel="stylesheet" href="../css/sweetalert.css"/>

    <link rel="stylesheet" type="text/css" href="../css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="../css/component.css" />
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <style>
        .ui-tabs .ui-tabs-nav li{float: right !important; width: 50% !important; margin: 0 !important;}
        .ui-tabs .ui-tabs-nav .ui-tabs-anchor{width: 100% !important; text-align: center !important;font-weight: bold !important;}
        .skin-orange a:hover, .skin-orange a:focus{color: #fff !important;}

        #link{display: none}
        input[type=radio].css-checkbox {
            position:absolute; z-index:-1000; left:-1000px; overflow: hidden; clip: rect(0 0 0 0); height:1px; width:1px; margin:-1px; padding:0; border:0;
        }

        .comment-list.right_of_reply .skin-orange a:hover{color: #FC624D !important; opacity: 1 !important;}

        input[type=radio].css-checkbox + label.css-label {
            padding-right:24px;
            height:19px;
            display:inline-block;
            line-height:19px;
            background-repeat:no-repeat;
            background-position: 120px 0;
            font-size:19px;
            vertical-align:middle;
            cursor:pointer;
        }

        input[type=radio].css-checkbox:checked + label.css-label {
            background-position: 120px -19px;
        }
        label.css-label {
            background-image:url('../images/check.png');
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        #file-4,#file-3{display: none}
    </style>

	<script src="fyipanel/production/js/sweetalert-dev.js"></script>  
	<style type="text/css">
		@import url(https://fonts.googleapis.com/earlyaccess/scheherazade.css); 
	</style> 
</head> 
<body class="skin-orange ">
	<?php require_once('header.php');

	//if($log){
        include("fyipanel/views/connect.php");
    //}

	if(isset($_GET['id'])&&!empty($_GET['id']) && isset($_GET['link'])&&!empty($_GET['link'])){    
		$id_art_actuel=$_GET['id'];
		$clink=$_GET['link'];


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
            return $a;
        }

        if ($log && isset($_POST['send_right_of_reply'])) {

            $reply_to = filter_text($_POST['reply_to']);
            $title = filter_text($_POST['title']);
            $phone = filter_text($_POST['phone']);
            $link = filter_text($_POST['link']);
            $message_to_admin = filter_text($_POST['message_to_admin']);
            $news_id = (int)$_POST['news_id'];
            $reply = htmlspecialchars($_POST['myTextField2'], ENT_QUOTES);
            $main_image_upload = false;
            $user_image_upload = false;
            $reply_image_name = '';
            $user_image_name = '';
            $domain = 'http://127.0.0.1/fyi/';
            //$domain = 'https://www.fyipress.net/';

            if (!empty($_FILES['file-3']['name'])) {

                $allowed_image_extension = array(
                    "png",
                    "jpg",
                    "jpeg"
                );

                $file_extension = pathinfo($_FILES["file-3"]["name"], PATHINFO_EXTENSION);

                if (! in_array($file_extension, $allowed_image_extension)) {
                    echo 'برجاء اختيار صور png,jpg,jpeg فقط';
                    exit;
                }
                else{
                    $maxsize = utilisateursModel::info("maxsizecomments");
                    if (ceil($_FILES['file-3']['size'] / 1048576) > $maxsize) {
                        echo 'برجاء اختيار صورة بحجم أصغر';
                        exit;
                    }
                    else{
                        $target_dir = "images/rss_comments/";
                        $reply_image_name = time() . mt_rand(1111,9999).'.'.$file_extension;
                        $reply_image_full_link = $domain.'arabic/images/rss_comments/'.$reply_image_name;
                        $target_file = $target_dir . $reply_image_name;
                        if (move_uploaded_file($_FILES["file-3"]["tmp_name"], $target_file)) {
                            $main_image_upload = true;
                        } else {
                            echo 'حدث خطأ برفع الملف برجاء المحاولة مرة أخرى';
                        }

                    }

                }

            }

            if (!empty($_FILES['file-4']['name'])) {
                $allowed_image_extension = array(
                    "png",
                    "jpg",
                    "jpeg"
                );

                $file_extension = pathinfo($_FILES["file-4"]["name"], PATHINFO_EXTENSION);

                if (! in_array($file_extension, $allowed_image_extension)) {
                    echo 'برجاء اختيار صور png,jpg,jpeg فقط';
                    exit;
                }
                else{
                    $maxsize = utilisateursModel::info("maxsizecomments");
                    if (ceil($_FILES['file-4']['size'] / 1048576) > $maxsize) {
                        echo 'برجاء اختيار صورة بحجم أصغر';
                        exit;
                    }
                    else{
                        $target_dir = "images/rss_comments/";
                        $user_image_name = time().mt_rand(11111,99999).'.'.$file_extension;
                        $user_image_full_link = $domain.'arabic/images/rss_comments/'.$user_image_name;
                        $target_file = $target_dir . $user_image_name;
                        if (move_uploaded_file($_FILES["file-4"]["tmp_name"], $target_file)) {
                            $user_image_upload = true;
                        } else {
                            echo 'حدث خطأ برفع الملف برجاء المحاولة مرة أخرى';
                        }

                    }

                }


            }

            if($reply_to == 'something_else'){

                if($link == ''){
                    $_SESSION['save_status'] = 2;
                    $message_type = 'error';
                    $exec_q = false;
                }
                else{
                    $exec_q = true;
                }
            }
            else{
                $exec_q = true;
            }

            if($exec_q){
                $created_at = date("Y-m-d H:i:s");

                $stmt = $con->prepare("insert into rss_right_of_reply (news_id, user_email, reply_title, user_image, uploaded_image, created_at, user_phone, message_to_mentor, reply, reply_to_link) values (:news_id, :email, :reply_title, :user_image, :uploaded_image, :created_at, :user_phone, :message_to_mentor, :reply, 
:reply_to_link)");
                $stmt->bindParam(':news_id', $news_id);
                $stmt->bindParam(':email', $user_email);
                $stmt->bindParam(':reply_title', $title);
                $stmt->bindParam(':user_image', $user_image_full_link);
                $stmt->bindParam(':uploaded_image', $reply_image_full_link);
                $stmt->bindParam(':created_at', $created_at);
                $stmt->bindParam(':user_phone', $phone);
                $stmt->bindParam(':message_to_mentor', $message_to_admin);
                $stmt->bindParam(':reply', $reply);
                $stmt->bindParam(':reply_to_link', $link);
                if($stmt->execute()){
                    $_SESSION['save_status'] = 1;
                    $message_type = 'success';
                }
                else{
                    $_SESSION['save_status'] = 0;
                    $message_type = 'error';
                    print_r($stmt->errorInfo());
                    exit;
                }
            }

        }

        if(isset($_SESSION['save_status']) && $_SESSION['save_status'] == 1){
            $message = "تم إرسال حق الرد بنجاح وسيتم مراجعته";
        ?>
        <script>
            swal("  تم   ", '<?=$message?>' ,'<?=$message_type?>')
        </script>
    <?php
        }
        elseif(isset($_SESSION['save_status']) && $_SESSION['save_status'] == 0){
            $message = "حدث خطأ برجاء إعادة المحاولة";
    ?>
        <script>
            swal("  إنتباه   ", '<?=$message?>' ,'<?=$message_type?>')
        </script>
    <?php
        }
        elseif(isset($_SESSION['save_status']) && $_SESSION['save_status'] == 2){
        $message = 'يجب ادخال رابط الموضوع';
        ?>
            <script>
                swal("  إنتباه   ", '<?=$message?>' ,'<?=$message_type?>')
            </script>
        <?php 
        }

        $_SESSION['save_status'] = 3;
        unset($_SESSION['save_status']);

		?> 
		<div class="container">
			<section class="category">
				<div class="col-md-12 col-sm-12 ol-xs-12 "> 
               <?php      
                $ch = curl_init();  
                curl_setopt($ch, CURLOPT_URL, $clink);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $a = curl_exec($ch); // $a will contain all headers
                $clink = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); 
                ?>
                <object data="<?php echo $clink; ?>" type="text/html"  class="pmc" width="100%" height="900" ></object>
                 
				</div>
			</section>
		</div>  

		<div class="container"> 
			<div class="row">  
				<div class="col-md-4 sidebar" id="sidebar" style="margin-top: 60px;"> 
					<?php 
					$news = new news_publishedModel();
					$nb_comments = commentsModel::nbHotNewsRss($id_art_actuel);
					if($log){
						if($nb_comments==0) $nb_comments=1; 
						else $nb_comments=$nb_comments;
					}
					else{
						if($nb_comments==0) $nb_comments=0;
						else if($nb_comments==1) $nb_comments=1;
						else $nb_comments=$nb_comments-1;
					} 
					if ($nb_comments!=0) {  ?>
						<aside>  <br> 
							<h1 class="aside-title xhotnewsTitle"  >الاخبار الحالية</h1> 
							    <div class="line xline" ></div>  
							<div class="aside-body"> 
								<?php 
								$query = $news->hotnews($nb_comments);
								foreach($query as $news){
									if($news['rank']==1){
										$media='fyipanel/views/image_news/'.$news['media']; 
										$link="detail.php?id=".$news['id'];
										$typesection4=" إف واي آي برس    ";   
									}else{ 
										$media=$news['media']; 
										$typesection4=$news['type']; 
										 //zzz  
										if(news_publishedModel::source_not_open($typesection4)){
										   $link=stripslashes($news['content']);
										}else{  
										   $has_http = strpos($news['content'],'http://') !== false; 
										   if($has_http){
										   	  $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".stripslashes($news['content'])."&id=".$news['id'];
										   }else{
										   	  $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".stripslashes($news['content'])."&id=".$news['id']; 
										   } 
										}
										//
									}
									?>   
 									<article class="article-fw" style="padding-bottom: 40px;" >
								<div class="inner">
									<figure>
										<a target="_blank" href="<?php echo $link; ?>" > 
										  <img width="100%" height="100%"  src="<?php echo $media; ?>" alt="Image">
										  </a> 
									</figure>
									<div class="details"> 
										<p  >
											<a target="_blank" href="<?php echo $link; ?>" class="newFontv" > 
										   <?php echo $news['title']; ?> </a>
									    </p> 
										<div class="detail"   > 
										 	  <a class=" xtype">  
									          <?php echo utilisateursModel::source($typesection4); ?> </a> 
										  	<span class="xdate" >
												<?php real_news_time($news['pubDate']); ?> 
										    </span>  
										</div>
									</div>
								</div>
							</article>

										<?php } ?> 
									</div>
								</aside>
							<?php } // news > 0 ?>
						</div>

						<div class="col-md-8" style="margin-top: 40px;">

                            <div class="comments">

                                <form method="post"  >
                                    <?php if ($log==false) { ?>
                                        <h3  style="text-align: center; padding-top: 40px; " >  فضلا  <a href="login.php"> سجل دخولك  </a> للتعليق </h3>
                                        <div class="line thin"  ></div>
                                    <?php } ?>

                                    <p class="xtitle" style="text-align: center;" >التعليقات  </p>
                                    <p class="xtitle"  > تنوية : </p>
                                    <span class="xtitle2" >
                    التعليقات المنشورة لا تعبر عن وجهة نظر شاتس رن ولا العاملين فيها وإنما هي وجهة نظر من قام بكتابتها فقط .
                 </span>
                                    <?php if ($log==true){ ?>
                                        <h3  class="title" style=" text-align: center;" >
                                            <a onclick="f10()" style="cursor: pointer; font-size: 23px; text-align: right; padding-right: 20px;">
                                                اكتب تعليق
                                            </a>
                                            <?php $countofrep=commentsModel::rss_countTotalOfComments($id_art_actuel);
                                            echo ' عدد التعليقات  :  '. $countofrep; ?>
                                        </h3>
                                        <hr>
                                    <?php } ?>

                                </form>

                                <div class="comment-list">
                                    <!-- comments  -->
                                    <?php $qr=commentsModel::rss_commentsStartNbres(0,10,$id_art_actuel);
                                    foreach ($qr as $comment) {   ?>
                                        <div style=" margin-bottom: 40px; text-align: right;" >
                                            <div style="margin-left: 10%;" id="example1">
                                                <h3><?php echo commentsModel::nameReporter2($comment['email_user']); ?></h3>
                                                <p ><?php echo $comment['response']; ?></p>
                                                <div class="abc" >
                                                    <?php  if ($comment['media']!=''){ 	$typee=commentsModel::typeOfMedia($comment['media']);
                                                        if ($typee=="image"){ ?>
                                                            <img src="<?php echo 'images/rss_comments/'.$comment['media']; ?>">
                                                        <?php }else if($typee=="video"){ ?>
                                                            <video  controls  >
                                                                <source src="<?php echo 'images/rss_comments/'.$comment['media']; ?>"  >
                                                            </video>
                                                        <?php }else if($typee=="audio"){ ?>
                                                            <audio   controls  >
                                                                <source src="<?php echo 'images/rss_comments/'.$comment['media']; ?>"  >
                                                            </audio>
                                                        <?php }   } ?>
                                                </div>
                                                <br>
                                                <i style="color: #FC624D; font-weight: bold; "><?php real_comments_time($comment['time']); ?></i>
                                            </div>

                                            <?php if ($log){?>
                                                <div style="border: none;" class="modal-footer">
                                                    <a  href="<?php echo 'iframee.php?link='.$clink.'&id=' . $id_art_actuel . '&r=' . $comment['id']; ?>">
                                                        <button  type="button" class="btn btn-primary xreply" data-dismiss="modal">
                                                            رد
                                                        </button>
                                                    </a>

                                                    <?php  if(!commentsModel::rss_HisComment($comment['id'],$user_email) &&
                                                        !commentsModel::rss_comment_already_reported($comment['id'],$user_email) ){ ?>
                                                        <a href="<?php echo 'rss_report.php?link='.$clink.'&id='.$id_art_actuel.'&id_c='.$comment['id']; ?>">
                                                            <button type="button" class="btn btn-danger xreport1" data-dismiss="modal">
                                                                إبلاغ
                                                            </button>
                                                        </a>
                                                    <?php } else if(!commentsModel::rss_HisComment($comment['id'],$user_email) &&
                                                        commentsModel::rss_comment_already_reported($comment['id'],$user_email) ){ ?>
                                                        <button disabled=""  type="button" class="btn btn-danger xreport2" data-dismiss="modal">   إبلاغ
                                                        </button>
                                                    <?php } ?>

                                                </div>
                                            <?php  } ?>
                                        </div>
                                        <!-- replies  -->
                                        <?php	$qrss=repliesModel::rss_repliesStartNbres(0,10,$id_art_actuel,$comment['id']);
                                        foreach ($qrss as $reply) {    ?>
                                            <div style=" margin-bottom: 40px; text-align: right; " >
                                                <div style="margin-left: 20%;    " id="example1">
                                                    <h3><?php echo commentsModel::nameReporter2($reply['email_user']) ?></h3>
                                                    <p><?php echo $reply['response']; ?></p>
                                                    <div class="abc" >
                                                        <?php
                                                        if ($reply['media']!=''){
                                                            $typee=commentsModel::typeOfMedia($reply['media']);
                                                            if ($typee=="image"){ ?>
                                                                <img     src="<?php echo 'images/rss_replies/'.$reply['media']; ?>">
                                                            <?php }else if($typee=="video"){ ?>
                                                                <video  controls  >
                                                                    <source src="<?php echo 'images/rss_replies/'.$reply['media']; ?>"  >
                                                                </video>
                                                            <?php }else if($typee=="audio"){ ?>
                                                                <audio   controls  >
                                                                    <source src="<?php echo 'images/rss_replies/'.$reply['media']; ?>"  >
                                                                </audio>
                                                            <?php }   } ?>

                                                    </div>
                                                    <br>
                                                    <i style="color: #FC624D; font-weight: bold;"><?php real_comments_time($reply['time']); ?></i>
                                                </div>


                                                <?php if ($log){ ?>
                                                    <div style="border: none;" class="modal-footer">
                                                        <a href="<?php echo 'iframee.php?link='.$clink.'&id=' . $id_art_actuel . '&r=' . $comment['id']; ?>">
                                                            <button type="button" class="btn btn-primary xreply" data-dismiss="modal">
                                                                رد
                                                            </button>
                                                        </a>
                                                        <?php if( !commentsModel::rss_HisReply($reply['id'],$user_email) &&
                                                            !commentsModel::rss_reply_already_reported($reply['id'],$user_email)){ ?>
                                                            <a href="<?php echo 'rss_report.php?link='.$clink.'&id='.$id_art_actuel.'&id_r='.$reply['id']; ?>">
                                                                <button type="button" class="btn btn-danger xreport1" data-dismiss="modal">
                                                                    إبلاغ
                                                                </button>
                                                            </a>
                                                        <?php } else if( !commentsModel::rss_HisReply($reply['id'],$user_email) &&
                                                            commentsModel::rss_reply_already_reported($reply['id'],$user_email)){ ?>
                                                            <button disabled="" type="button" class="btn btn-danger xreport2" data-dismiss="modal">
                                                                إبلاغ
                                                            </button>
                                                        <?php } ?>
                                                    </div>
                                                <?php  } // log true ?>
                                            </div>
                                        <?php  } // for replies
                                    } // for comments
                                    ?>
                                </div>

                                <?php
                                if($log){  ?>
                                    <form style="padding-bottom: 50px;"  enctype="multipart/form-data" method="post" class="row">
                                        <div class="form-group col-md-12 " style="text-align: right;"  >
                                            <label for="message" style="font-size: 26px;" >   تعليق   </label>
                                            <textarea style="text-align: right; font-size: 26px;" maxlength="500" required="required" id="myTextField"  class="form-control" name="message"
                                                      placeholder=" اكتب تعليق  "  ></textarea>
                                        </div>

                                        <div class="image-upload form-group col-md-8 col-xs-12 " style="float: right;" >
                                            <label for="file-input" style="font-size: 20px;" >
                                                <img style="cursor: pointer;" width="15%" height="15%" src="images/cam.png"/><span class="newFont" style="float: right; padding-left: 20px;" >  أضف صورة او فيديو
                                   </span></label>
                                            <input accept="image/*|video/*|audio/*" name="image" style="display: none;" id="file-input" type="file" />
                                        </div>


                                        <div class="form-group col-md-4 col-xs-12 " style="float: left;">
                                            <input value="  نشر " name="send" type="submit" class="btn btn-primary form-control " style="font-size: 27px; font-weight: bold; padding-top:0px !important; margin-top: 0px !important" >
                                        </div>
                                    </form>

                                <?php
                                // comment 8
                                if (isset($_POST['send'])) {
                                if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
                                    $state_logo=0;
                                }else  {
                                    $state_logo=1;
                                    $typeimage=0;
                                    $checkexistedeja=0;
                                    $fin=0;
                                    $size_error=0;
                                    $target_dir = "images/rss_comments/";
                                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                                    $uploadOk = 1;
                                    $maxsize=utilisateursModel::info("maxsizecomments");
                                    if (ceil($_FILES['image']['size']/1048576)>$maxsize) {
                                        $size_error=1; $uploadOk = 0;
                                    }
                                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                                    if (file_exists($target_file)) {    $checkexistedeja=1;  $uploadOk = 0;   }
                                    // Allow certain file formats
                                    if($imageFileType != "jpg" &&$imageFileType != "JPG" && $imageFileType != "png"&& $imageFileType != "PNG" && $imageFileType != "jpeg"&& $imageFileType != "JPEG"
                                        && $imageFileType != "AC-3" && $imageFileType != "ac-3"&& $imageFileType != "mp4"&& $imageFileType != "MP4"&& $imageFileType != "mp3"&& $imageFileType != "MP3"&& $imageFileType != "webm"&& $imageFileType != "WEBM" && $imageFileType != "flv" && $imageFileType != "FLV"&& $imageFileType != "mkv"&& $imageFileType != "MKV"&& $imageFileType != "mpeg"&& $imageFileType != "MPEG"
                                        && $imageFileType != "gif"&& $imageFileType != "GIF") {
                                        $typeimage = 1;    $uploadOk = 0;
                                    }
                                    // Check CFE $uploadOk is set to 0 by an error
                                    if ($uploadOk == 1) {
                                        $ImageName=(string)commentsModel::nbr_news_with_images()+1;
                                        $target_file = $target_dir . basename($_FILES["image"]["name"]);
                                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                            $im=$ImageName."-".rand(1,100).".".$imageFileType;
                                            $target_file2= $target_dir . basename($im);
                                            rename($target_file,$target_file2);
                                            $nomlogo=$im;
                                        } else {
                                            $fin=1;
                                            $uploadOk = 0;
                                        }
                                    }
                                } // image
                                $responsetoadd=strip_tags($_POST['message']);
                                $comment = new commentsModel();
                                $comment->setresponse(addslashes($responsetoadd));
                                date_default_timezone_set('GMT');
                                $comment->settime(strip_tags(date("Y-m-d H:i:s")));
                                $comment->setid_news(strip_tags($id_art_actuel));
                                $comment->setemail_user(strip_tags($user_email));
                                if($state_logo==1){
                                if($uploadOk==1){
                                $comment->setmedia($nomlogo);
                                if ($comment->rss_add_comments()==true){ ?>
                                    <script>
                                        window.location.replace("iframe.php?link=<?php echo $clink; ?>&id=<?php echo $id_art_actuel; ?>");
                                    </script>
                                <?php   }else{  ?>
                                    <script>
                                        swal("  إنتباه   ","   لم تتم اضافة التعليق   ","warning")
                                    </script> ';
                                <?php   }

                                }else{
                                $msg=null;
                                if($checkexistedeja==1)
                                    $msg.='  الصورة او الفيديو موجود مسبقا ، يرجى تغيير اسم الصورة او الفيديو والمحاولة مرة أخرى    \n';
                                if($size_error==1)
                                    $msg.='  يجب أن يكون حجم الملف أقل من   '.$maxsize .' MB\n';
                                if($typeimage==1) $msg.='عذرًا ، تقبل الصور والفيديوهات بالصيغ التالية  فقط  jpg و jpeg و png و gif و ac-3 و mp3 و mp4 و flk و mkv و mpeg & webm \n';
                                if($fin==1) $msg.='عذرا ، خطأ أثناء تحميل الملف.   \n';
                                $msg.="   لم تتم اضافة التعليق   ";
                                ?>
                                    <script>
                                        swal("  إنتباه   ","<?php echo $msg;?>","warning")
                                    </script>
                                <?php
                                }
                                }else{
                                $comment->setmedia('');
                                if ($comment->rss_add_comments()==true){ ?>
                                    <script>
                                        window.location.replace("iframe.php?link=<?php echo $clink; ?>&id=<?php echo $id_art_actuel; ?>");
                                    </script>
                                <?php   }else{  ?>
                                    <script>
                                        swal("  إنتباه   ","   لم تتم اضافة التعليق   ","warning")
                                    </script> ';
                                <?php   }
                                } //state logo
                                }//send
                                }//log
                                ?>
                            </div>


                            </div>


 </div> 
</div>  
</div>  
<?php }else{  ?>
	<script>  window.location.replace('404.php'); </script> 
<?php }  ?> 
<!-- Start footer -->
<?php require_once ('footer.php') ?>
<!-- End Footer -->

<!-- JS -->
<script src="../js/jquery.js"></script>
<script src="../js/jquery.migrate.js"></script>
<script src="../scripts/bootstrap/bootstrap.min.js"></script>
<script>var $target_end=$(".best-of-the-week");</script>
<script src="../scripts/jquery-number/jquery.number.min.js"></script>
<script src="../scripts/owlcarousel/dist/owl.carousel.min.js"></script>
<script src="../scripts/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="../scripts/easescroll/jquery.easeScroll.js"></script>
<script src="../scripts/sweetalert/dist/sweetalert.min.js"></script>
<script src="../scripts/toast/jquery.toast.min.js"></script> 
<script src="../js/e-magz.js"></script>


    <script>
        $( function() {

            $(".comment-list.right_of_reply img").addClass('img-responsive');

        } );
    </script>
 
<script type="text/javascript">
	function f10(){
		document.getElementById("myTextField").focus(); 
	}
    function f11(){
        document.getElementById("title").focus();
    }
    $(document).ready(function(){
		$('.backk').click(function(){   
			$(".nav-list").removeClass("active");
			$(".nav-list").removeClass("active");
			$(".nav-list .dropdown-menu").removeClass("active");
			$(".nav-title a").text("Menu");
			$(".nav-title .back").remove();
			$("body").css({
				overflow: "auto"
			});
			backdrop.hide();

		});	 
	});  

</script>
</body>
</html>