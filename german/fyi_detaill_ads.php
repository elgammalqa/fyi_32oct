<?php
session_start();   ob_start(); 
 if(isset($_COOKIE['fyiuser_email'])){
 	$user_email=$_COOKIE['fyiuser_email'];
}else if(isset($_SESSION['user_auth']['user_email'])){
	$user_email=$_SESSION['user_auth']['user_email'];
}   
require_once('models/utilisateurs.model.php');
require_once('models/adscomments.model.php');
require_once('models/adsreplies.model.php');
require_once ('fyipanel/models/ads.model.php');
require_once('../models/v5.news_published.php');
require_once ('fyipanel/models/news_published.model.php');
require_once ('timee.php');
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
		<link rel="stylesheet" href="../css/sweetalert.css"/>
        <script src="fyipanel/production/js/sweetalert-dev.js"></script> 
  </head>
	<body onload="f10()" class="skin-orange">
	 	 <?php require_once ("fyi_header.php"); ?>
		<section class="single">
			<div class="container">
				<div class="row"> 

					<div class="col-md-8 " style="padding-top: 23px;"> 
					<?php if(isset($_GET['id'])&&!empty($_GET['id'])){  
							$news=new adsModel();
						  if($news->findnews($_GET['id'])!=null){
						  	$id_art_actuel=$_GET['id']; 
						  	if($log) { 
						  		v5newspublished::add_user_ads($id_art_actuel);
						  	}
					?> 
						<div class="xhomeen">
							<a href="fyi.php">Startseite</a>
							 &nbsp; / &nbsp; Detail
						</div>
						</ol>  
						<header> 
							<h1 class="xarticletitleen">
								<?php echo $news->gettitle(); ?> 
							</h1>  
						</header> 
						<article class="article main-article">  

							<div class="main"> 
								<?php if($news->getmedia()!=''){ ?>
								<div class="featured"> 
										<?php 	$type=news_publishedModel::typeOfMedia($news->getmedia()); 
												if ($type=="video") { ?>  
													 <video   width="100%"  controls  <?php if ($news->getthumbnail()!=""){ echo 'poster="'.$news->getthumbnail().'"'; } ?> >
	 												 	<source src="<?php echo 'ads/image/'. $news->getmedia(); ?>"  >
													</video>
													  <?php }else  if ($type=="image") { ?> 
												<a  href="fyi_detail_ads.php?id=<?php echo $news->getid(); ?>" > 
											        <img width="100%" height="100%"  src="<?php echo 'ads/image/'.$news->getmedia(); ?>" alt="Image">
											    </a>
											    <?php } ?>    
								</div>  
								<?php } ?>   
								<?php if($news->getpdf()!=''){   
								 	if(isMobile()){ ?>  
			                            <footer id="mleft" >
											   <a class="btn btn-primary more pull-right"   href="download_ads.php?id=<?php echo $news->getid(); ?>">
													<div >Herunterladen</div>
													<div><i class="ion-ios-download"></i></div>
						 					   </a>
											<span style="margin-left: 20px;" ></span>
											    <a class="btn btn-primary more pull-right" 
											        href="ads/pdf/<?php echo $news->getpdf(); ?>">
												    <div >Anzeigen</div>
												    <div><i class="ion-ios-eye"></i></div>
												</a> 
										</footer> 
								 	<?php }else{ ?>   
								 		<div style="font-family: helvetica, tahoma; padding-bottom: 10px; padding-top: 20px;"  >  
									        <embed src="ads/pdf/<?php echo $news->getpdf(); ?>" 
									        type="application/pdf" class="viewpdf"> </embed> 
									    </div>  
										<?php } } //pdf ?>  

			 					<div class="xtypedate" >
									<span class="xdateen" >
									  <?php real_news_time($news->getpubDate()); ?>
									</span> 
									<a class="xtypeen" >
									  <?php echo  "Nachrichten"; ?> 
									</a>   
								</div>
		  						<div class="xdetail2en"> 
									<?php echo  $news->getdescription(); ?> 
								</div>  
		                      	<div class="xcontenten">
		                      	 	<?php echo  html_entity_decode($news->getcontent());?>
		                     	</div>   
						</article> 
						<?php }else{ ?>
						<script>
				                window.location.replace('404.php');
				        </script> 
						<?php }
						 }else{ ?>
						<script>
						        window.location.replace('404.php');
						</script> 
						<?php }  ?> 

 
 
                    	 
				  
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
								<?php $countofrep=adscommentsModel::countTotalOfComments($id_art_actuel);
								if ($countofrep<=1) echo $countofrep.' Kommentar ';
								else echo $countofrep.' Kommentare ';  ?>  &nbsp; &nbsp; &nbsp;
								<a onclick="f10()" style="cursor: pointer;">Einen Kommentar schreiben </a>
							</p> <hr>
						<?php } ?> 
						</form>   

				 <div class="comment-list">   
				 		<!-- comments  -->
				    <?php $qr=adscommentsModel::commentsStartNbres(0,10,$id_art_actuel);
					    foreach ($qr as $comment) {   ?>  
					    	<div style=" margin-bottom: 10px;" >
						    <div class="exampleen_c">
							    <h3>
							    	<?php echo adscommentsModel::nameReporter2($comment['email_user']); ?>
							    </h3>
							    <p><?php echo $comment['response']; ?></p> 
							    <div class="abc" >
								  	<?php  if ($comment['media']!=''){ 	$typee=adscommentsModel::typeOfMedia($comment['media']);
								  	    if ($typee=="image"){ ?>
										    <img src="<?php echo 'ads/comments/'.$comment['media']; ?>">	
												<?php }else if($typee=="video"){ ?>
											<video  controls  >
											    <source src="<?php echo 'ads/comments/'.$comment['media']; ?>"  >
											</video>
										    <?php }else if($typee=="audio"){ ?>
										    <audio   controls  >
												 <source src="<?php echo 'ads/comments/'.$comment['media']; ?>"  >
										    </audio> 
									    <?php }   } ?>   
							    </div>
							    <br>	
							    <i style="color: #FC624D; font-weight: bold; "><?php real_comments_time($comment['time']); ?></i>
						    </div>  
						    <?php if ($log){?>
							    <div style="border: none;" class="modal-footer">
									<a href="<?php echo 'fyi_detaill_ads.php?id='.$id_art_actuel.'&r='.$comment['id']; ?>">
										<button  type="button" class="btn btn-primary xreplyen" 
												data-dismiss="modal">Antwort
										</button> 
									</a> 

						<?php  if(!adscommentsModel::HisComment($comment['id'],$user_email) &&
							!adscommentsModel::ads_comment_already_reported($comment['id'],$user_email) ){ ?>
								<a href="<?php echo 'report_ads.php?id='.$id_art_actuel.'&id_c='.$comment['id']; ?>">
									<button type="button" class="btn btn-danger xreporten1"
											 data-dismiss="modal">Bericht
									</button>
								</a>
							<?php } else if(!adscommentsModel::HisComment($comment['id'],$user_email) &&
						 		adscommentsModel::ads_comment_already_reported($comment['id'],$user_email) ){ ?>
								<button disabled="" type="button" class="btn btn-danger xreporten2" > 			Bericht 
								</button>
							<?php } ?> 
  
								  </div>   
								   <?php  } ?> 
								   </div> 
 									<!-- replies  -->
					    <?php $qrss=adsrepliesModel::repliesStartNbres(0,10,$id_art_actuel,$comment['id']);
					        foreach ($qrss as $reply) {    ?> 
					        	<div style=" margin-bottom: 10px;" >
								<div class="exampleen_r">
								    <h3><?php echo adscommentsModel::nameReporter2($reply['email_user']) ?></h3>
								    <p><?php echo $reply['response']; ?></p>
								    <div class="abc" >								  	
								   <?php if ($reply['media']!=''){
								  		$typee=adscommentsModel::typeOfMedia($reply['media']);
								  	    if ($typee=="image"){ ?>
											<img src="<?php echo 'ads/replies/'.$reply['media']; ?>">	
												<?php }else if($typee=="video"){ ?>
												<video  controls  >
												      <source src="<?php echo 'ads/replies/'.$reply['media']; ?>"  >
												</video>
												<?php }else if($typee=="audio"){ ?>
											    <audio   controls  >
												    <source src="<?php echo 'ads/replies/'.$reply['media']; ?>"  >
											    </audio> 
								        <?php }   } ?>  

								   </div>
								   	<br>	
								    <i style="color: #FC624D; font-weight: bold;">
								    	<?php real_comments_time($reply['time']); ?></i>
							    </div>
 

							   <?php if ($log){?>
								<div style="border: none; margin-right:15%" class="modal-footer">
									<a href="<?php echo 'fyi_detaill_ads.php?id='.$id_art_actuel.'&r='.$comment['id']; ?>">
								        <button type="button" class="btn btn-primary xreplyen" 
								        		data-dismiss="modal">Antwort
								        </button>
								    </a>

								<?php if( !adscommentsModel::HisReply($reply['id'],$user_email) && 
								!adscommentsModel::ads_reply_already_reported($reply['id'],$user_email)){ ?>
								    <a href="<?php echo 'report_ads.php?id='.$id_art_actuel.'&id_r='.$reply['id']; ?>">
								        <button type="button" class="btn btn-danger xreporten1" 
								        		data-dismiss="modal"> Bericht
								        </button>
								    </a>
								   <?php }else if(!adscommentsModel::HisReply($reply['id'],$user_email) && 
								     adscommentsModel::ads_reply_already_reported($reply['id'],$user_email)){ ?>
								        <button disabled="" type="button" class="btn btn-danger xreporten2" data-dismiss="modal">Bericht
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
		   if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
            $state_logo=0;
            }else  {
                $state_logo=1;
                $typeimage=0;
                $checkexistedeja=0;
                $fin=0;
                 $size_error=0;
           if (isset($_GET['r'])&&!empty($_GET['r'])) {
                $target_dir = "ads/replies/";
            }else{
            	 $target_dir = "ads/comments/";
            }
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
                         if (isset($_GET['r'])&&!empty($_GET['r'])) {
				            	  $ImageName=(string)adsrepliesModel::nbr_news_with_images()+1;
				            }else{
				            	  $ImageName=(string)adscommentsModel::nbr_news_with_images()+1;
				            }

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
                            $comment = new adscommentsModel();
                            $comment->setresponse(addslashes($responsetoadd));
                             date_default_timezone_set('GMT');
                            $comment->settime(strip_tags(date("Y-m-d H:i:s")));
                            $comment->setid_ads(strip_tags($id_art_actuel));
                            $comment->setemail_user(strip_tags($user_email));
                            $rep = new adsrepliesModel();
                            $rep->setresponse(addslashes($responsetoadd));
                             date_default_timezone_set('GMT');
                            $rep->settime(strip_tags(date("Y-m-d H:i:s")));
                            $rep->setid_ads(strip_tags($id_art_actuel));
                            $rep->setemail_user(strip_tags($user_email));
                            if($state_logo==1){
                                if($uploadOk==1){
                                	if (isset($_GET['r'])&&!empty($_GET['r'])) {
                                		 $rep->setmedia($nomlogo);
                                          $rep->setid_comment($_GET['r']);
                                        if ($rep->add_replies()==true) {?>
                                      <script>
                                        window.location.replace("fyi_detail_ads.php?id=<?php echo $id_art_actuel; ?>");
                                      </script>
                                     <?php }else   echo '<script>
                                                 swal("Achtung!  ", " Kommentar nicht hinzugefügt !","warning")
                                            </script> ';

                                		  }else{

                                        $comment->setmedia($nomlogo);
                                        if ($comment->add_comments()==true) { ?>
                                      <script>
                                        window.location.replace("fyi_detail_ads.php?id=<?php echo $id_art_actuel; ?>");
                                      </script>
                                     <?php }else   echo '<script>
                                                 swal("Achtung!  ", " Kommentar nicht hinzugefügt !","warning")
                                            </script> ';
                                        }

                                    }else{
                                            $msg=null;
                                             if($size_error==1) $msg.='Dateigröße muss kleiner sein als '.$maxsize.' MB\n';
                                             if($checkexistedeja==1) $msg.='Datei Already Exist, Bitte ändern Sie den Namen und versuchen Sie es wieder\n';
                                            if($typeimage==1) $msg.='Sorry, Just Accept jpg, jpeg, png, gif, ac-3,mp4,flk,mkv,mpeg & webm Format\n';
                                            if($fin==1) $msg.='Sorry, Fehler beim Hochladen von Datei.\n';
                                            $msg.="Kommentar nicht hinzugefügt";
                                            ?>
                                            <script>
                                                 swal("Aufmerksamkeit!","<?php echo $msg;?>","warning")
                                            </script>
                                        <?php
                             }
                               }else{
                               if (isset($_GET['r'])&&!empty($_GET['r'])) {
                                		 $rep->setmedia('');
                                          $rep->setid_comment($_GET['r']);
                                        if ($rep->add_replies()==true) {   ?>
                                            <script>
                                              window.location.replace("fyi_detail_ads.php?id=<?php echo $id_art_actuel; ?>");
                                            </script>
                                     <?php  } else   echo '<script>
                                                 swal("Achtung!  ", " Kommentar nicht hinzugefügt !","warning")
                                            </script> ';

                                		  }else{
                                        $comment->setmedia('');
                                        if ($comment->add_comments()==true){ ?>
                                        	  <script>
                                              window.location.replace("fyi_detail_ads.php?id=<?php echo $id_art_actuel; ?>");
                                            </script>
                                      <?php  }
                                        else   echo '<script>
                                                 swal("Achtung!  ", " Kommentar nicht hinzugefügt !","warning")
                                            </script> ';
                                        }


                       } //state logo
             }//send
         }//log

							 ?>
						</div>
					</div>

					



					<div class="col-md-4 sidebar" id="sidebar"> 
						<?php  if(v5newspublished::nbrhotnews()>0){  ?>
						<aside>
							<br>
							<h1 class="aside-title">Aktuelle Nachrichten</h1>
							<div class="aside-body"> 
							<?php   $news=new news_publishedModel();   
									$query=v5newspublished::hotnews(4);
                        			foreach($query as $news){ 
											$media='fyipanel/views/image_news/'.$news['media']; 
											$link="fyi_detail.php?id=".$news['id'];
											$typesection4=$news['type'];  
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
										 	  <a >  <?php echo utilisateursModel::type($typesection4); ?> </a>
										</div>
											<div class="time"  >
												<?php real_news_time($news['pubDate']); ?> 
										    </div>
										    <?php   if($log){
													if(v5newspublished::already_read($news['id'])){
													echo '<div class="xtypeenhot" style="padding-left: 20px;"  >
													<i class="fa fa-circle" style=" font-size: 10px; color: green; " aria-hidden="true"></i></div>';
													}else{
													echo '<div class="xtypeenhot" style="padding-left: 20px;">
													<i class="fa fa-circle" style=" font-size: 10px; color: red; " aria-hidden="true"></i></div>';
													}
												}//log
										?> 
										</div> 
									</div>  
									</div> 
							</article> 
						<?php } 	 ?> 
							</div> 
						</aside>
					<?php }	 ?> 
					</div>   

				</div>
			</div>
		</section>
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
 			function f11(){
 				window.location.replace('fyi_detaill_ads.php?id=<?php echo $id_art_actuel; ?>');
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
