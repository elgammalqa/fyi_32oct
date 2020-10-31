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
			 <div class="col-md-4 sidebar" id="sidebar" style="margin-top: 15px;"> 
					  <?php if(v5newspublished::nbrhotnews()>0){  ?> 
						<aside> 
							<br>
							<h1 class="aside-title float_right" style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; margin-bottom: 0px;" > חדשות אחרונות</h1> 
							    <div class="line" style="margin :20px; " ></div>
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
										<a target="_blank" href="<?php echo $link; ?>" > 
										  <img width="100%" height="100%"  src="<?php echo $media; ?>" alt="Image">
										  </a> 
									</figure>
									<div class="details">
										<p class="float_right" >
											<a target="_blank" href="<?php echo $link; ?>" class="newFont" > 
										   <?php echo $news['title']; ?> </a>
									    </p> 
										<div class="detail float_right "   >
											 <?php   if($log){
													if(v5newspublished::already_read($news['id'])){
													echo '<div style="padding-top: 6px; margin-right: 25px; ">
													<i class="fa fa-circle" style=" font-size: 10px; color: green; " aria-hidden="true"></i></div>';
													}else{
													echo '<div style="padding-top: 6px; margin-right: 25px; ">
													<i class="fa fa-circle" style=" font-size: 10px; color: red; " aria-hidden="true"></i></div>';
													}
												}//log
										?>  
										  	<div class="time fs_cat">
												<?php real_news_time($news['pubDate']); ?> 
										    </div>
										     <span style="padding-right: 20px;" ></span>
										    <div class="category fs_cat">
										 	  <a >  
									          <?php echo utilisateursModel::type($typesection4); ?> </a>
										   </div>

										</div>
									</div>
								</div>
							</article>
							
						<?php } ?> 
							</div>
						</aside>
			           <?php } // news > 0 ?>
					</div> 
 
					<div class="col-md-8">
					<?php if(isset($_GET['id'])&&!empty($_GET['id'])){  
							$news=new adsModel();
						  if($news->findnews($_GET['id'])!=null){
						  	$id_art_actuel=$_GET['id'];
					?> 
					<div>
					 	<ol style="list-style: none; " >
						    <li class="  xhome"  >
						    	<a  href="fyi.php"> תפריט ראשי   </a> 
						    		 &nbsp; / &nbsp;   פרטים   
						    </li> 
						</ol> 
					 </div> 
					 <header> 
						<h1 class="xarticletitle">
							<?php echo $news->gettitle(); ?> 
						</h1>  
					</header>    
						<article class="article main-article"> 
							<div class="main" style="padding-top: 0px !important;" > 
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
								if(isMobile()){   ?>
									 <footer id="mleft" >
									   <a  target="_blank" class="btn btn-primary more pull-right " 
									        href="download_ads.php?id=<?php echo $news->getid(); ?>">
												<div >  הורד  </div>
												<div><i class="ion-ios-download"></i></div>
				 					   </a> 
								       <span style="margin-left: 20px;" ></span>
								        <a target="_blank" class="btn btn-primary more pull-right " 
								            href="ads/pdf/<?php echo $news->getpdf(); ?>">
											<div > לתצוגה  </div>
											<div><i class="ion-ios-eye"></i></div>
									    </a> 
								  	</footer> 
								<?php }else{  ?>
									<div style="font-family: helvetica, tahoma; padding-bottom: 10px; 
										padding-top: 20px;"  >  
									    <embed src="ads/pdf/<?php echo $news->getpdf(); ?>" 
									        type="application/pdf" class="viewpdf"> </embed> 
									    </div>  
								<?php  } }//pdf ?>    
								
									<div class="xtypedate" >
										<a class="xtype" >
										  <?php echo " חדשות "; ?> 
										</a>  
										<span class="xdate" >
												  פורסם  <?php real_news_time($news->getpubDate()); ?>
										</span>  
									</div>
			  						<div class="xdetail2"> 
										<?php echo  $news->getdescription(); ?> 
									</div>  
			                      	<div class="xcontent">
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
						<h3  style="text-align: center; padding-top: 40px; " >  אנא  <a href="login.php">התחברות</a> תגובה </h3> 
								<div class="line thin"  ></div>
						<?php	}  ?>

 						<p class="xtitle" style="text-align: center;" > הערות  </p>
 						<p class="xtitle"  > הודעה  : </p>
						 <span class="xtitle2" >
							ההערות שפורסמו אינן מייצגות את הדעות של צ'אטים ריץ 'ואת עובדיה, אלא את השקפותיהם של אלה שכתבו אותם. 	
						 </span>

						<?php if ($log==true){ ?>
						    <h4  class="title" style=" text-align: center;" >  
								  <a onclick="f10()" style="cursor: pointer; font-size: 23px; text-align: right; padding-right: 20px;">
								  כתוב הערה 									
								</a>
								 <?php
							$countofrep=adscommentsModel::countTotalOfComments($id_art_actuel);
							   echo ' סך הכל תגובות  :  '. $countofrep; ?>
							</h4> 
							<?php } ?>
							</form> 



				 <div class="comment-list">   
				 		<!-- comments  -->
				    <?php  
				     $qr=adscommentsModel::commentsStartNbres(0,10,$id_art_actuel);
					    foreach ($qr as $comment) {   ?>  
					    	<div style=" margin-bottom: 40px;  text-align: right; " >
						    <div style="margin-left: 10%;" id="example1">
							    <h3><?php echo adscommentsModel::nameReporter2($comment['email_user']); ?></h3> 
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
							    <i style="color: #FC624D; font-weight: bold; "><?php  real_comments_time($comment['time']); ?></i>
						    </div>

						    <?php if ($log==true){?>
							    <div style="border: none;" class="modal-footer">
								<a href="<?php echo 'fyi_detaill_ads.php?id='.$id_art_actuel.'&r='.$comment['id']; ?>">
								   <button type="button" class="btn btn-primary xreply" data-dismiss="modal">
								    תשובה 
								    </button>
								 </a>

								 <?php if(!adscommentsModel::HisComment($comment['id'],$user_email) && 
								 !adscommentsModel::ads_comment_already_reported($comment['id'],$user_email)){ ?>
								<a href="<?php echo 'report_ads.php?id='.$id_art_actuel.'&id_c='.$comment['id']; ?>">
								    <button type="button" class="btn btn-danger xreport1" data-dismiss="modal">
								     להגיש תלונה 
								    </button>
								</a>
								     <?php } else if(!adscommentsModel::HisComment($comment['id'],$user_email) && 
								 	adscommentsModel::ads_comment_already_reported($comment['id'],$user_email)){ ?>
								    <button disabled="" type="button" class="btn btn-danger xreport2" data-dismiss="modal">
								         להגיש תלונה  
								    </button>
								     <?php } ?> 
 
								  </div>  
								   <?php  } ?>
								   </div> 
 
 									<!-- replies  -->
					    <?php	$qrss=adsrepliesModel::repliesStartNbres(0,10,$id_art_actuel,$comment['id']);
					        foreach ($qrss as $reply) {    ?> 
					        	<div style=" margin-bottom: 40px; text-align: right; " >
								<div style="margin-left: 20%;    " id="example1">
								    <h3><?php echo adscommentsModel::nameReporter2($reply['email_user']) ?></h3> 
								    <p><?php echo $reply['response']; ?></p>
								    <div class="abc" >								  	<?php
								    	if ($reply['media']!=''){
								  		$typee=adscommentsModel::typeOfMedia($reply['media']);
								  	    if ($typee=="image"){ ?>
											<img     src="<?php echo 'ads/replies/'.$reply['media']; ?>">	
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
							    <i style="color: #FC624D; font-weight: bold; "><?php  real_comments_time($reply['time']); ?></i>
							    </div>


							   <?php if ($log==true){?>
								    <div style="border: none;" class="modal-footer">
								    <a href="<?php echo 'fyi_detaill_ads.php?id='.$id_art_actuel.'&r='.$comment['id']; ?>">
								        <button type="button" class="btn btn-primary xreply" data-dismiss="modal">
								          	 תשובה  
								        </button>
								    </a>
					 <?php if(!adscommentsModel::HisReply($reply['id'],$user_email) && 
					         !adscommentsModel::ads_reply_already_reported($reply['id'],$user_email)){ ?>
					         	<a href="<?php echo 'report_ads.php?id='.$id_art_actuel.'&id_r='.$reply['id']; ?>">
								        <button type="button" class="btn btn-danger xreport1" data-dismiss="modal">
								          	 להגיש תלונה  
								        </button>
								</a>
								         <?php }else if(!adscommentsModel::HisReply($reply['id'],$user_email) && 
					         			adscommentsModel::ads_reply_already_reported($reply['id'],$user_email)){ ?>
								        <button disabled=""  type="button" class="btn btn-danger xreport2" data-dismiss="modal">
								             להגיש תלונה  
								        </button>
								         <?php } ?> 
 
								    </div>   
								   <?php  } // log true ?>
								   </div>
								   <?php  } // for replies
								} // for comments 
								?> 
							</div> 

							

  
						<?php	if($log==true){  ?>
							<form style="padding-bottom: 50px;"  enctype="multipart/form-data" method="post" class="row"> 
								<div class="form-group col-md-12 " style="text-align: right;"  >
									<label for="message" style="font-size: 26px;" > תגובה   </label>
									<textarea style="text-align: right; font-size: 26px;" maxlength="500" required="required" id="myTextField"  class="form-control" name="message" 
									 placeholder="  השאר תגובה  "></textarea>
								</div>
								
								<div class="image-upload form-group col-md-8 col-xs-12 " style="float: right;" >  
									 <label for="file-input" style="font-size: 20px;" >
			                           <img style="cursor: pointer;" width="15%" height="15%" src="images/cam.png"/><span class="newFont" style="float: right; padding-left: 20px;" > 
			                           	 תמונה או וידאו   
			                           </span></label> 
			                      <input accept="image/*|video/*|audio/*" name="image" style="display: none;" id="file-input" type="file" /> 
								</div> 
								<div class="form-group col-md-4 col-xs-12 " style="float: left;"> 
									<input  value="  תגובה " name="send" type="submit" class="btn btn-primary form-control " style="font-size: 27px; font-weight: bold; padding-top:0px !important; margin-top: 0px !important" >
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
                                                 swal("תשומת הלב!","התגובה לא נוספה !","warning")       
                                            </script> '; 

                                		  }else{

                                        $comment->setmedia($nomlogo);   
                                        if ($comment->add_comments()==true) { ?>   
                                      <script>
                                        window.location.replace("fyi_detail_ads.php?id=<?php echo $id_art_actuel; ?>");
                                      </script>  
                                     <?php }else   echo '<script>
                                                 swal("תשומת הלב!","התגובה לא נוספה !","warning")                                                                                                  
                                            </script> '; 
                                        } 

                                    }else{  
										$msg=null;  
										if($size_error==1) $msg.='גודל הקובץ חייב להיות קטן מ '.$maxsize.' MB\n'; 
											if($checkexistedeja==1) $msg.='הקובץ כבר קיים, אנא שנה את שם הקובץ ונסה שוב\n'; 
										   if($typeimage==1) $msg.='מצטערים, פשוט קבל jpg, jpeg, png, gif, ac-3, mp3, mp4, flk, mkv, mpeg & webm פורמט\n'; 
										   if($fin==1) $msg.='מצטערים, שגיאה בעת העלאת קובץ.\n'; 
										   $msg.="התגובה לא נוספה";  
										   ?>
                                            <script>
                                                 swal("תשומת הלב!","<?php echo $msg;?>","warning")
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
                                                 swal("תשומת הלב!","התגובה לא נוספה !","warning")  
                                            </script> '; 

                                		  }else{ 
                                        $comment->setmedia('');   
                                        if ($comment->add_comments()==true){ ?> 
                                        	  <script>
                                              window.location.replace("fyi_detail_ads.php?id=<?php echo $id_art_actuel; ?>");
                                            </script> 
                                      <?php  }     
                                        else   echo '<script>
										swal("תשומת הלב!","התגובה לא נוספה !","warning")  
                                            </script> '; 
                                        } 


                       } //state logo  
             }//send
         }//log
 
							 ?>
						</div>
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