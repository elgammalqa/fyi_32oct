<?php 
session_start();   ob_start();  
 if(isset($_COOKIE['fyiuser_email'])){ 
 	$user_email=$_COOKIE['fyiuser_email'];
}else if(isset($_SESSION['user_auth']['user_email'])){
	$user_email=$_SESSION['user_auth']['user_email'];
}   
require_once('models/utilisateurs.model.php');
require_once('models/comments.model.php');
require_once('models/replies.model.php');
require_once ('timee.php');     
require_once ('fyipanel/models/news_published.model.php');
if(utilisateursModel::islogged())
$log=true; 
else $log=false;    
  
 ?>   
<!DOCTYPE html>
<html>

<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script> 
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/style2.css">
	<link rel="stylesheet" href="../css/skins/all.css"> 
	<link rel="stylesheet" href="../css/demo.css">
	<link rel="stylesheet" href="../css/sweetalert.css" />
	<script src="fyipanel/production/js/sweetalert-dev.js"></script> 
</head>

<body class="skin-orange ">
	<?php require_once('header.php'); 
	if(isset($_GET['id'])&&!empty($_GET['id']) && isset($_GET['link'])&&!empty($_GET['link'])){    
		$id_art_actuel=$_GET['id']; 
		?> 
		<div class="container">
		<section class="category">
			<div class="col-md-12 col-sm-12 ol-xs-12 ">
				<?php 
					$clink = $_SERVER['QUERY_STRING']; 
				    $clink = substr($clink, 0,strpos($clink, "&id=") );
				    $clink = substr($clink, 5); 
				    $id=$_GET['id'];    
				    $ch = curl_init();    
				    curl_setopt($ch, CURLOPT_URL, $clink);
				    curl_setopt($ch, CURLOPT_HEADER, true); 
				    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				    curl_exec($ch);  
				    $clink = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);  
				    $has_hashtag = strpos($clink, '#') !== false;
				    if($has_hashtag){
				         $clink = substr($clink, 0,strpos($clink, "#") );
				    }  
				?> 
					<object type="text/html" class"pmc" width="100%" height="900" data="<?php echo $clink; ?>">
					</object>
			</div>
		</section>
	</div>
 
		<div class="container"> 
				<div class="row"> 
 
					<div class="col-md-8 " style="margin-top: 40px; "> 
						<div class="comments"> 
						<form method="post" >
							<?php if ($log==false) { ?>
							<h3 class="xlogin"> Bitte <a href="login.php"> &nbsp;Anmelden&nbsp;</a>Zu kommentieren</h3>
							<div class="line thin"></div>
						<?php } ?> 

						<p class="xtitleen" style="text-align: center;"> Kommentare </p>
 						<p class="xtitleen"> Beachten : </p>
						 <span class="xtitle2en" >
						 	Die veröffentlichten Kommentare geben nicht die Ansichten von Chats Run und seinen Mitarbeitern wieder, sondern die Ansichten derjenigen, die sie verfasst haben.
 						 </span> <br><br>

						<?php if ($log){ ?>
							<p style="font-size: 22px; ">
								<?php $countofrep=commentsModel::rss_countTotalOfComments($id_art_actuel);
								if ($countofrep<=1) echo $countofrep.' Kommentar ';
								else echo $countofrep.' Kommentare ';  ?>  &nbsp; &nbsp; &nbsp;
								<a onclick="f10()" style="cursor: pointer;">Einen Kommentar schreiben </a>
							</p> <hr>
						<?php } ?> 
						</form>  

						 

 <div class="comment-list">   
				 		<!-- comments  -->
				    <?php $qr=commentsModel::rss_commentsStartNbres(0,10,$id_art_actuel);
					    foreach ($qr as $comment) {   ?>  
					    	<div style=" margin-bottom: 10px;" >
						    <div class="exampleen_c">
							    <h3><?php echo commentsModel::nameReporter2($comment['email_user']); ?></h3>
							    <p><?php echo $comment['response']; ?></p> 
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
							    <i style="color: #FC624D; font-weight: bold; ">
							    	<?php real_comments_time($comment['time']); ?></i>
						    </div>

						    <?php if ($log==true){?>
							    <div style="border: none;" class="modal-footer">
							    	<a href="<?php echo 'iframee.php?link='.$clink.'&id=' . $id_art_actuel . '&r=' . $comment['id']; ?>">
										<button  type="button" class="btn btn-primary xreplyen" 
												data-dismiss="modal">Antwort
										</button> 
									</a> 
 
                      <?php  if(! commentsModel::rss_HisComment($comment['id'],$user_email) && 
                            !commentsModel::rss_comment_already_reported($comment['id'],$user_email) ){ ?> 
								<a href="<?php echo 'rss_report.php?link='.$clink.'&id='.$id_art_actuel.'&id_c='.$comment['id']; ?>">
									<button type="button" class="btn btn-danger xreporten1"
											 data-dismiss="modal">Bericht
									</button>
								</a> 
						  <?php }else if(! commentsModel::rss_HisComment($comment['id'],$user_email) && 
                            commentsModel::rss_comment_already_reported($comment['id'],$user_email) ){ ?>
                            <button disabled="" type="button" class="btn btn-danger xreporten2" > 				Bericht 
							</button> 
                                    <?php } ?>    
								  </div>  
								   <?php  } ?>
								   </div> 
 									<!-- replies  -->
					    <?php $qrss=repliesModel::rss_repliesStartNbres(0,10,$id_art_actuel,$comment['id']);
					        foreach ($qrss as $reply) {    ?> 
					        	<div style=" margin-bottom: 10px;" >
								<div class="exampleen_r">
								    <h3><?php echo commentsModel::nameReporter2($reply['email_user']) ?></h3>
								    <p><?php echo $reply['response']; ?></p>
								    <div class="abc" >								  	
								  <?php if ($reply['media']!=''){
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
  
 
							   <?php if ($log==true){?>
								    <div style="border: none; margin-right:15%" class="modal-footer">
								    <a href="<?php echo 'iframee.php?link='.$clink.'&id=' . $id_art_actuel . '&r=' . $comment['id']; ?>">
								        <button type="button" class="btn btn-primary xreplyen" 
								        		data-dismiss="modal">Antwort
								        </button>
								    </a>
 
								 <?php if(!commentsModel::rss_HisReply($reply['id'],$user_email) && 
								  !commentsModel::rss_reply_already_reported($reply['id'],$user_email)){ ?>
								    <a  href="<?php echo 'rss_report.php?link='.$clink.'&id='.$id_art_actuel.'&id_r='.$reply['id']; ?>">
								        <button type="button" class="btn btn-danger xreporten1" 
								        		data-dismiss="modal"> Bericht
								        </button>
								    </a>

								  <?php } else if(!commentsModel::rss_HisReply($reply['id'],$user_email) && 
								   commentsModel::rss_reply_already_reported($reply['id'],$user_email)){ ?> 
 									<button disabled="" type="button"
 										 class="btn btn-danger xreporten2" data-dismiss="modal">Bericht
								     </button> 
 									<?php } ?> 
								    </div>   
								   <?php  } // log true ?>
								   </div>
								   <?php  } // for replies
								} // for comments 
								?> 
							</div> 






	<?php	if($log){  ?>
							<form style="padding-bottom: 50px;"  enctype="multipart/form-data" method="post" class="row"> 
								<div class="form-group col-md-12">
									<label for="message">Kommentar <span class="required"></span></label>
									<textarea style="font-size: 18px;" maxlength="500" required="required" id="myTextField"  class="form-control" name="message"  placeholder="schreibe deinen Kommentar ..."></textarea>
								</div>  
								<div class="image-upload form-group col-md-8">  
									 <label for="file-input" style="font-size: 18px;">
			                          Bild oder Video hinzufügen &nbsp; : &nbsp; <img style="cursor: pointer;" width="15%" height="15%" src="images/cam.png"/>
			                           </label> 
			                      <input accept="image/*|video/*|audio/*" name="image" style="display: none;" id="file-input" type="file" /> 
								</div>
								<div class="form-group col-md-4"> 
									<input value="0" id="c_id" name="c_id" type="hidden" class="btn btn-primary form-control">
									<input value="Kommentar senden" name="send" type="submit" class="btn btn-primary form-control" style="font-size: 20px; padding-top:5px !important; margin-top: 0px !important">
								</div>  
							</form>
			<?php
				// comment 
			if (isset($_POST['send'])) {
				if (!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
					$state_logo = 0;
				} else {
					$state_logo = 1;
					$typeimage = 0;
					$checkexistedeja = 0;
					$fin = 0;
					$size_error = 0;
					$target_dir = "images/rss_comments/";
					$target_file = $target_dir . basename($_FILES["image"]["name"]);
					$uploadOk = 1;
					$maxsize = utilisateursModel::info("maxsizecomments");
					if (ceil($_FILES['image']['size'] / 1048576) > $maxsize) {
						$size_error = 1;
						$uploadOk = 0;
					}
					$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

					if (file_exists($target_file)) {
						$checkexistedeja = 1;
						$uploadOk = 0;
					}
						// Allow certain file formats
					if (
						$imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG"
						&& $imageFileType != "AC-3" && $imageFileType != "ac-3" && $imageFileType != "mp4" && $imageFileType != "MP4" && $imageFileType != "mp3" && $imageFileType != "MP3" && $imageFileType != "webm" && $imageFileType != "WEBM" && $imageFileType != "flv" && $imageFileType != "FLV" && $imageFileType != "mkv" && $imageFileType != "MKV" && $imageFileType != "mpeg" && $imageFileType != "MPEG"
						&& $imageFileType != "gif" && $imageFileType != "GIF"
					) {
						$typeimage = 1;
						$uploadOk = 0;
					}
						// Check CFE $uploadOk is set to 0 by an error
					if ($uploadOk == 1) {
						$ImageName = (string)commentsModel::rss_nbr_news_with_images() + 1;
						$target_file = $target_dir . basename($_FILES["image"]["name"]);
						if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
							$im = $ImageName . "-" . rand(1, 100) . "." . $imageFileType;
							$target_file2 = $target_dir . basename($im);
							rename($target_file, $target_file2);
							$nomlogo = $im;
						} else {
							$fin = 1;
							$uploadOk = 0;
						} 
					}
					} // image  
					$responsetoadd = strip_tags($_POST['message']);
					$comment = new commentsModel();
					$comment->setresponse(addslashes($responsetoadd));
					date_default_timezone_set('GMT');
					$comment->settime(strip_tags(date("Y-m-d H:i:s")));
					$comment->setid_news(strip_tags($id_art_actuel));
					$comment->setemail_user(strip_tags($user_email));
					if ($state_logo == 1) {
						if ($uploadOk == 1) {
							$comment->setmedia($nomlogo);
							if ($comment->rss_add_comments() == true) { ?>
								<script>
									window.location.replace("iframe.php?link=<?php echo $clink; ?>&id=<?php echo $id_art_actuel; ?>");
								</script>
							  <?php   }else{  ?>
                                     	    <script>
                                                 swal("Achtung!  ", " Kommentar nicht hinzugefügt !","warning")
                                            </script> ';
                                     <?php   }

                                    }else{
                                            $msg=null;
                                             if($checkexistedeja==1) $msg.='Datei Bereits verlassen, Bitte ändern Sie den Namen und versuchen Sie es erneut\n';
                            if($size_error==1) $msg.='Dateigröße muss kleiner sein als '.$maxsize .' MB\n';
                                            if($typeimage==1) $msg.='Sorry, Just Accept jpg, jpeg, png, gif, ac-3,mp4,flk,mkv,mpeg & webm Format\n';
                                            if($fin==1) $msg.='Sorry, Fehler beim Hochladen von Datei.\n';
                                            $msg.=" Kommentar nicht hinzugefügt ";
                                            ?>
                                            <script>
                                                 swal("Achtung!","<?php echo $msg;?>","warning")
                                            </script>
							<?php
						}
					} else {  
						$comment->setmedia('');
						if ($comment->rss_add_comments() == true) { ?>
							<script>
								window.location.replace("iframe.php?link=<?php echo $clink; ?>&id=<?php echo $id_art_actuel; ?>");
							</script>
						<?php   } else {  ?>
							<script>
								swal("Achtung!", "Kommentar nicht hinzugefügt !", "warning")
							</script> ';
						<?php   }
				} //state logo  
			} //send
		} //log 
		?>

     </div> 
 </div> 




		         <div class="col-md-4 sidebar" id="sidebar" style="margin-top: 60px;">
			      <?php 
			 			$news = new news_publishedModel();
						$nb_comments = commentsModel::nbHotNewsRss($id_art_actuel);
						if($log){
							if($nb_comments==0) $nb_comments=1; 
							else $nb_comments=$nb_comments;
						}else{
							if($nb_comments==0) $nb_comments=0;
							else if($nb_comments==1) $nb_comments=1;
							else $nb_comments=$nb_comments-1;
						} 
			if ($nb_comments!=0) {  ?>
				<aside>
					<br>
					 <h1 class="aside-title">Aktuelle Nachrichten</h1> 
					<div class="aside-body">
						<?php
						$query = $news->hotnews($nb_comments);
						foreach ($query as $news) {
							if ($news['rank'] == 1) {
								$media = 'fyipanel/views/image_news/' . $news['media'];
								$link = "detail.php?id=" . $news['id'];
								$typesection4 = "fyi press";
							} else {
								$media = $news['media']; 
								$typesection4 = $news['type']; 
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
										<a  href="<?php echo $link; ?>" > 
										  <img width="100%" height="100%"  src="<?php echo $media; ?>" alt="Image">
										  </a> 
									</figure>
									<div class="details">
										<h1 style="font-size: 15px;">
											<a   href="<?php echo $link; ?>" > 
										   <?php echo $news['title']; ?> </a>
									    </h1>
										<div class="detail" style="padding-top: 10px;" >
										 <div class="xtypeenhot">
										 	  <a >  <?php echo $typesection4; ?> </a>
										</div>
											<div class="time">
												<?php real_news_time($news['pubDate']); ?> 
										    </div>
										</div>
									</div>
								</div>
							</article> 
							<?php } 	 ?>
						</div>
						</aside><?php }	 ?>
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

<script type="text/javascript">
	function f10(){
		document.getElementById("myTextField").focus(); 
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