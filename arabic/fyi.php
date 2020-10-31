<?php 
session_start();   ob_start();   
require_once('models/utilisateurs.model.php'); 
require_once ('../models/v5.news_published.php'); 
require_once ('timee.php');  
if(utilisateursModel::islogged())  
	$log=true;
else $log=false;   
$GLOBALS['activee'] = 1;   

	$topSide=false; $videosSide=false; $bottomSide=false; 
	$nbnewstosh=v5newspublished::NbreNewsToShow();
	if(v5newspublished::nbrhotnews()>0&&(v5newspublished::nbr_ads2()>0||($nbnewstosh>0&&count(v5newspublished::NewsToShow($nbnewstosh))>0))){ $topSide=true; }
	if(v5newspublished::nbrVideos()>0){ $videosSide=true; }
	$table=array("News","Sports","Arts","Technology","General Culture");
	$nbnews=0;
	foreach ($table as $key => $value) {
		if(v5newspublished::nbrNewsBySourceindex($value)>0) $nbnews++;
	}   
	if($nbnews>0&&(v5newspublished::nbr_news_without_images2()>0||v5newspublished::pdfcount()>0)) 
	{ $bottomSide=true; }
		if(!$topSide&&!$videosSide&&!$bottomSide){ 
		echo "<script> location.href='index.php'; </script>";
	 }else{
	 	current_lang();
	 } 

?> 
<!DOCTYPE html>  
<html> 
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
	<meta charset="utf-8" >
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
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
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/style_ar.css">
	<link rel="stylesheet" href="../css/style2.css"> 
	<link rel="stylesheet" href="../css/skins/all.css">  
	<link rel="stylesheet" href="../css/demo.css">  
	<style type="text/css">
		.menu ul > li > a{
			font-family: 'Droid Arabic Kufi', serif; 
			letter-spacing: 0px;
		}
		h1{
			font-family: 'Droid Arabic Kufi', serif; 
			letter-spacing: 0px;
			font-size: 5px;
		}	
		@media (min-width: 992px) {
			.video_height{ height: 400px; } 


			}else{ 
				.video_height{ height: 200px; }	 
			}
			video[poster]{ 
				width:100%;
			}  
			.txtright{
				text-align: right  !important;

			}
			.float_right{
				float: right !important;
			}
			.float_left{
				float: left !important;
			}
			@media (min-width: 420px) {
				.mr_types{
					padding-right: 330px !important;
				}
			}

			@media (max-width: 991px) {
				#margin_hotnews{  
					margin-top: 40px; 
					margin-bottom: 40px;  
				} 
			} 
		</style>
	</head>    

	<body class="skin-orange">
		<?php require_once ("fyi_header.php");  
			if($topSide){ ?>   
			<section class="home" style="padding-bottom: 0px;padding-top: 0px; 
			<?php if(isMobile()) echo ' margin-top: -10px; ' ?> " >
			<div class="container"   >
				<div class="row">  
					<?php function hot_newss($log){ ?> 
						<div class="col-xs-12 col-sm-12 col-md-4 " id="margin_hotnews" > 
							<?php  if(v5newspublished::nbrhotnews()>0){ ?>
								<h1 class="title-col " style="text-align: right;">
									الأخبار الساخنة
									<div class="carousel-nav" id="hot-news-nav" style="float: left;"  >
										<div class="prev">
											<i class="ion-ios-arrow-left"></i>
										</div> 
										<div class="next">
											<i class="ion-ios-arrow-right"></i>
										</div>
									</div>  
								</h1> 
								<div class="body-col vertical-slider" data-max="3" style="height: 500px !important;" data-nav="#hot-news-nav"  data-item="article"  >
        				<?php   $query=v5newspublished::hotnews(10); 
								foreach($query as $news){  ?> 
									<article class="article-mini shadowBox" style="margin-bottom: 10px; direction: rtl;" >
										<div class="inner">
											<?php   
											$media='fyipanel/views/image_news/'.$news['media']; 
											$link="fyi_detail.php?id=".$news['id'];
											$typesection=$news['type'];    
											?>  
											<figure  style="width: 120px; height: 100px; float: right;   " >
												<a target="_blank" href="<?php echo $link;  ?>">
													<img style="width: 120px; height: 100px;  "
													src="<?php echo $media; ?>" alt="Image">
												</a>
											</figure> 
										<div class="padding"  style="padding-right: 50px; margin-right: 85px; margin-left: 0px;" >
												<h1 style="font-size: 14px; text-align: right;" >
													<a target="_blank"  href="<?php echo $link;  ?>">
														<?php echo $news['title'];  ?> 
													</a>
												</h1>
												<div class="detail" style="float: right;"  > 
													<div style="font-size: 17px; padding-left: 20px;" > 
														<h6>
															<a><?php echo utilisateursModel::type($typesection); ?></a>
													    </h6>  
													</div>
													<div style=" font-size: 17px;"  >
														<h6 dir="rtl" >
															<?php real_news_time_without_before($news['pubDate']);  ?>
														</h6>
													</div>  
													<div style="padding-right: 20px;">
														<?php  if($log){
																if(v5newspublished::already_read($news['id'])){
																	echo '<div> <i class="fa fa-circle green_circle" aria-hidden="true"></i></div>'; 
																}else{
																	echo '<div> <i class="fa fa-circle red_circle" aria-hidden="true"></i></div>';
																}
															}//log 
													?>
													</div> 

											</div>
										</div>
									</div>
								</article> 
							<?php } ?>
						</div> 
					<?php } ?>
				</div> 
			<?php }    
			function newss($log){ ?>  
				<div class="col-md-8 col-sm-12 col-xs-12 "> 
					<?php     
					$nbseconds=v5newspublished::timToContinue();
					$realsconds=$nbseconds*1000; ?>
					<div data-interval="<?php echo $realsconds; ?>"  id="carouselExampleControls" 
						class="carousel slide mainSadow" data-ride="carousel" id="featured"  > 
						<div class="carousel-inner">
			 <?php	 // ads  
			 if (v5newspublished::nbr_ads2()>0) {
			 	$req=v5newspublished::ads();
			 	foreach($req as $news){
			 		if($GLOBALS['activee']==1)  echo '<div class="carousel-item  item active">';
			 		else  echo '<div class="carousel-item  item">';
			 		$GLOBALS['activee']=0;  ?> 
			 		<article>
			 			<?php  
			 			$type=v5newspublished::typeOfMedia($news['media']); 
			 			if ($type=="image") { ?>
			 				<a target="_blank" href="fyi_detail_ads.php?id=<?php echo 
			 				$news['id'];  ?>"  >
			 				<img  width="100%" class="video_height" style="  padding-bottom: 5px; " 
			 				src="<?php echo 'ads/image/'.$news['media']; ?>" 
			 				alt="Image"> 
			 			</a> 
			 		<?php	}else  if ($type=="video") { ?> 
			 			<a target="_blank" href="fyi_detail_ads.php?id=<?php echo 
			 			$news['id'];  ?>">
			 			<video width="100%" controls="controls" class="video_height"
			 			<?php  $thumbnail=$news['thumbnail'];
			 			if ($thumbnail!=""){
			 				echo 'poster="'.$thumbnail.'"'; } ?>   >
			 				<source src="<?php echo 'ads/image/'.
			 				$news['media']; ?>"  
			 				>
			 			</video>  
			 		</a>
			 	<?php	} ?>    
			 	<div class="con-vid " > 
			 		<div style="padding-top: 10px;" class="one-t txtright">
			 			<a style=" background-color: #FC624D; font-size: 17px;" >
			 				<?php echo "اخبار ";  ?></a>
			 			</div>
			 			<h5 class="one-title txtright">
			 				<a style="color: black;" target="_blank" 
			 				href="fyi_detail_ads.php?id=<?php echo $news['id'];  ?>" >
			 				<?php echo $news['title'];  ?> 
			 			</a>
			 		</h5>
			 		<div class=" time2 txtright" style="font-size: 17px;" >
						<span style=" float: right;" >
							<a> إف واي آي برس   </a>
						</span> 
						<span style="padding-right: 20px; float: right;">
							<?php real_news_time($news['pubDate']);  ?>
						</span>  
			 			<span style="padding-right: 20px; float: right;">
			 				<?php  if($log){
							if(v5newspublished::already_read($news['id'])){
								echo '<i class="fa fa-circle green_circle2" aria-hidden="true"></i>'; 
									}else{
								echo '<i class="fa fa-circle red_circle2" aria-hidden="true"></i>';
								}
							}//log 
						?> 
			 			</span> 
			 		</div>
			 	</div>
			 </article>
			</div> 
		<?php } }  //ads

       //news  
		$nbrnewstodisplay=v5newspublished::NbreNewsToShow(); 
		if($nbrnewstodisplay>0){ 
			$req=v5newspublished::NewsToShow($nbrnewstodisplay);
			foreach($req as $news){    
				$thumbnail=$news['thumbnail'];
				$mediav='fyipanel/views/image_news/'.$news['media']; 
				$linkv="fyi_detail.php?id=".$news['id'];
				if ($news['type']=="General Culture") $typesection="Culture";
				else  $typesection=$news['type']; 
				$source="إف واي آي برس";   
				if ($GLOBALS['activee']==1) echo '<div class="carousel-item active item">';
				else echo '<div class="carousel-item  item">';
				$GLOBALS['activee']=0; ?>   
				<article>
					<?php 	 
					$type=v5newspublished::typeOfMedia($news["media"]);  
					if ($type=="image") { ?>
						<a target="_blank" href="<?php echo $linkv;  ?>">  
							<img width="100%" class="video_height" style="padding-bottom: 5px;" src="<?php echo $mediav; ?>"  alt="Image"> 
						</a> 
					<?php	}else  if ($type=="audio"||$type=="video") { ?>  
						<video width="100%" class="video_height" controls 
						<?php if ($thumbnail!=""){ echo 'poster="'.$thumbnail.'"'; } ?>  >
						<source src="<?php echo $mediav; ?>">
						</video>  
					<?php }   ?>  
					<div class="con-vid" > 
						<div class="one-t txtright"  >
							<a  target="_blank" href="fyi_category.php?id=
							<?php echo  $typesection; ?>&n=1" 
							style=" background-color: #FC624D; font-size: 17px; " >
							<?php echo utilisateursModel::type($typesection);  ?>    
						</a>
					</div>
					<h5 class="one-title txtright">
						<a style="color:black;" target="_blank" href="<?php echo $linkv;  ?>" >
							<?php echo $news['title'];  ?> 
						</a> 
					</h5>
					<div class=" time2 txtright" style="font-size: 17px;" >
						<span style=" float: right;" >
							<a> إف واي آي برس   </a>
						</span> 
						<span style="padding-right: 20px; float: right;">
							<?php real_news_time($news['pubDate']);  ?>
						</span>  
			 			<span style="padding-right: 20px; float: right;">
			 				<?php  if($log){
							if(v5newspublished::already_read($news['id'])){
								echo '<i class="fa fa-circle green_circle2" aria-hidden="true"></i>'; 
									}else{
								echo '<i class="fa fa-circle red_circle2" aria-hidden="true"></i>';
								}
							}//log 
						?> 
			 			</span> 
			 		</div>
				</div>
			</article>
		</div>  
	<?php  } }  ?>  
</div> 

<?php  }    

if(isMobile()){
	newss($log);	
	hot_newss($log);
	?>
	<a class="carousel-control-prev " href="#carouselExampleControls " role="button" 
	data-slide="prev" style=" height: 25%; align-items: flex-end;   width: 15%; "   >
	<span class="carousel-control-prev-icon align-bottom" aria-hidden="true"  ></span>
	<span class="sr-only">Previous</span>
</a> 
<a class="carousel-control-next  " href="#carouselExampleControls" 
role="button" data-slide="next"  
style="    align-items: flex-end; height: 25%;  width: 15%;" >
<span class="carousel-control-next-icon" aria-hidden="true"   ></span>
<span class="sr-only">Next</span>
</a>
<?php }else{ 
	hot_newss($log);
	newss($log);	

	?>
	<a class="carousel-control-prev prev_next_mobile" href="#carouselExampleControls " role="button" 
	data-slide="prev" style="height: 50%;   align-items: flex-end;   width: 15%; "   >
	<span class="carousel-control-prev-icon align-bottom" aria-hidden="true"  ></span>
	<span class="sr-only">Previous</span>
</a> 
<a class="carousel-control-next  " href="#carouselExampleControls" 
role="button" data-slide="next"  
style="    align-items: flex-end; height: 50%; width: 15%;" >
<span class="carousel-control-next-icon" aria-hidden="true"   ></span>
<span class="sr-only">Next</span>
</a>
<?php }  ?>

</div> <!-- c --> 
</div> <!-- 8 --> 

</div>
</div>
</section>
<?php } ?>
<div style="height: 40px; background-color: #e9ebee; " ></div>
<?php if($videosSide){ ?>
	<!--  section daily news -->  
	<section  class="best-of-the-week " style="margin-bottom: 0px;padding-top: 40px;">
		<div class="container">
			<h1 style="margin-bottom: 60px;" > 
				<div class="carousel-nav" id="best-of-the-week-nav" style="float: left;" >
					<div class="next">
						<i class="ion-ios-arrow-left"></i>
					</div>
					<div class="prev">
						<i class="ion-ios-arrow-right"></i>
					</div>
				</div>  
				<div class="text" style="float: right;" >الفيديوهات</div>
			</h1>
			<div class="owl-carousel   carousel-1" style="float: right !important;">
					<?php  	// news videos    
					$query=v5newspublished::videos(10);
					foreach($query as $news){   
						$thumbnail=$news['thumbnail'];
						$mediav='fyipanel/views/image_news/'.$news['media']; 
						$linkv="fyi_detail.php?id=".$news['id'];
						$typesection=$news['type'];  
						?>   
						<article class="article " > 
							<div class="inner" style="  box-shadow:none;" >
								<figure>
									<a>
										<video width="100%" height="100%" controls  
										<?php if ($thumbnail!=""){ echo 'poster="'.$thumbnail.'"'; } ?> >
										<source src="<?php echo $mediav; ?>"  >
										</video> 
									</a>
								</figure>
								<div class="padding"> 
									<h2 style="text-align: right;" ><a target="_blank"  href="<?php echo $linkv; ?>">
										<?php echo $news['title']; ?></a></h2> 
										<div class="detail float_right "> 
										<div style="padding-right: 20px;"> 
											<?php  
											if($log){
												if(v5newspublished::already_read($news['id'])){
													echo '<i class="fa fa-circle green_circle" aria-hidden="true"></i>'; 
												}else{
													echo '<i class="fa fa-circle red_circle" aria-hidden="true"></i>';
												}
											}//log 
											?> 
										</div>
											<div class="time ">
												<h6><?php real_news_time($news['pubDate']); ?> </h6>
											</div>
											<div class="category"> 
												<h6><a><?php echo utilisateursModel::type($typesection); ?></a> </h6>
											</div> 
										</div> 
									</div>
								</div>
							</article>
						<?php } ?> 
					</div>
				</div>
			</section>
		<?php } ?> 
		<!-- end of section daily news -->  

		<?php  function getrssnews($n,$log){ ?>
			<!-- newsx --> 
			<?php  if(v5newspublished::nbrNewsBySourceindex($n)>0){ 
				?>
				<div class="line">
					<div> <?php echo utilisateursModel::type($n); ?> </div> 
				</div>
				<div class="row">
					<?php   
					$req=v5newspublished::getNewsRssByTypeCount($n,4);
					foreach($req as $news){  
						$thumbnail=$news['thumbnail'];
						$mediav='fyipanel/views/image_news/'.$news['media']; 
						$linkv="fyi_detail.php?id=".$news['id'];
						$typesection=$news['type'];  
						?> 
						<article style="text-align: right;" class="col-md-12 article-list">
							<div class="inner"> 
								<figure style="float: right !important; " > 
									<?php 	 
									$type=v5newspublished::typeOfMedia($news["media"]); 
								      //poster="https://addpipe.com/sample_vid/poster.png" hhh
									if ($type=="video"||$type=="audio") { ?>  
										<video height="100%"   width="100%" controls 
										<?php if ($thumbnail!=""){ echo 'poster="'.$thumbnail.'"'; } ?> >
										<source src="<?php echo $mediav; ?>"  >
										</video>
									<?php }else  if ($type=="image") { ?> 
										<a target="_blank" href="<?php echo $linkv; ?>" > 
											<img height="100%"  src="<?php echo $mediav; ?>" alt="image">
										</a>
									<?php }   ?>   
								</figure>
								<div class="details mr_types"  > 
									<h1><a target="_blank" href="<?php echo $linkv; ?>" > 
										<?php echo $news["title"]; ?></a>
									</h1>
									<p style="font-family: 'Droid Arabic Kufi', serif; 
									letter-spacing: 0px;">
									<?php
									$real_sentence=stripslashes($news["description"]);
									$nb_words=str_word_count($real_sentence);
									$sentence=implode(' ', array_slice(explode(' ', $real_sentence), 0, 40));
									echo $sentence;   
									if ($nb_words>160) {
										echo '<br> ...';
									} 

									?>   
								</p>
								<div style="position: relative; right: 0px;" > 
									<h6 class="float_right" style="    margin-right: inherit;" > 
										<span style="float: right;">
											<a >
												<?php echo utilisateursModel::type($typesection); ?> 
											</a> 
										</span>
										 <span style="padding-right: 20px; float: right;   " >
											<?php real_news_time($news['pubDate']); ?> 
										</span>
										<span style="padding-right: 20px; float: right;   " >
										<?php  if($log){
											if(v5newspublished::already_read($news['id'])){
												echo '<i class="fa fa-circle green_circle2" aria-hidden="true"></i>'; 
													}else{
												echo '<i class="fa fa-circle red_circle2" aria-hidden="true"></i>';
												}
											}//log 
										?>
										</span> 
									</h6> 
								</div>
							</div>
						</div>
					</article>
				<?php } ?> 
				<footer style="margin-left: 40%"  >
					<?php if ($n!="General Culture") {
						$srcc=$n;
					}else{$srcc="Culture"; } ?>
					<a class="btn btn-primary more "  
					href="fyi_category.php?id=<?php echo $srcc; ?>&n=1">
					<div style="font-size: 20px;" >إقرا المزيد</div>
					<div><i class="ion-ios-arrow-thin-left"></i></div>
				</a>
			</footer>  
			<br><br><br>
		</div>  
	<?php	}} 
	       
	       if($bottomSide){ ?> 
		<section class=" home " style="padding-bottom: 0px;padding-top: 20px;"   >
			<div class="container">
				<div class="row" >    
					<?php  	function news_wout_media($nb,$log){  ?>
						<div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom: 60px;" >  
							<?php if(v5newspublished::nbr_news_without_images2()>0) { ?>
								<aside><br>
									<div class="line"  style="margin: 0px 0px;"><div> اخبار </div></div>
									<div class="tab-content">
										<div  class="tab-pane active" id="recomended"> 
											<?php  $query=v5newspublished::newsWithoutMedia($nb*5);
											foreach($query as $news){ 
												$linkv="fyi_detail.php?id=".$news['id'];
												$typesection=$news['type'];    
												?> 
												<article class="article-mini">
													<div class="inner" style="float: right;"> 
														<h1 class="txtright " ><a target="_blank" href="<?php echo $linkv; ?>">
															<?php echo $news['title']; ?></a></h1>
															<p style="font-family: 'Droid Arabic Kufi', serif; 
															letter-spacing: 0px;" class="txtright"><?php echo $news['description']; ?></p>
															<div class="detail float_right">   
																<div style=" padding-right: 20px;"> 
																	<?php  
																	if($log){
																		if(v5newspublished::already_read($news['id'])){
																			echo '<i class="fa fa-circle green_circle" aria-hidden="true"></i>'; 
																		}else{
																			echo '<i class="fa fa-circle red_circle" aria-hidden="true"></i>';
																		}
																	}//log 
																	?> 
																</div>
																<div style="padding-right: 20px;" >
																	<h6><?php echo real_news_time($news['pubDate']); ?> </h6>
																</div> 

																<div class="category" >
																	<h6><a> 
																		<?php echo utilisateursModel::type($typesection); ?> 
																	</a></h6>
																</div>  
																
															</div> 
														</div>
													</article> 
												<?php } ?> 
												<footer >
													<a target="_blank" class="btn btn-primary more pull-right " href="fyiall.php?id=1">
														<div style="font-size: 18px;" >إقرا المزيد</div>

														<div><i class="ion-ios-arrow-thin-left"></i></div>
													</a>
												</footer>
											</div> 
										</div>
									</aside> 
								<?php }
 
								if(v5newspublished::pdfcount()>0){ ?>
									<h1 class="title-col" style="text-align: right; margin-top: 30px;
									padding-right: 10px;"> 
										المكتبة 
										<div class="carousel-nav" id="hot-news-nav" style="float: left;">
											<div class="prev">
												<i class="ion-ios-arrow-left"></i>
											</div>
											<div class="next">
												<i class="ion-ios-arrow-right"></i>
											</div>
										</div>
									</h1>
								<div class="body-col vertical-slider" data-max="4" data-nav="#hot-news-nav" data-item="article"  > 
									<?php	
									$query=v5newspublished::newsStartCountpdf();
									foreach($query as $news){  ?> 
										<article class="article-mini" style="background-color: white; direction: rtl; height: 120px; margin-bottom: 15px;" >
											<div class="inner" >
												<figure style="float: right; width: 110px; height: 110px">
													<a target="_blank" href="fyi_detail.php?id=<?php echo $news['id'];  ?>">
														<img preload="none"  style="width: 110px; height: 100px" src="images/img/pdf.jpg" alt="Image">
													</a>
												</figure>
												<div class="padding" style="margin-right: 115px; margin-left: 0px;">
													<h1><a target="_blank" href="fyi_detail.php?id=<?php echo $news['id'];  ?>">
														<?php echo $news['title'];  ?> 
													</a>
												</h1> 
												<div class="detail"> 
													<div  style="padding-left: 20px;">
														<a style="font-size: 18px;">
															<?php echo utilisateursModel::type($news['type']) ;  ?> 
														</a>
													</div>
													<div class="time" style="font-size: 18px; padding-left: 20px;"><?php real_news_time($news['pubDate']);  ?> 
													</div>
													<div>  
													<?php if($log){
																if(v5newspublished::already_read($news['id'])){
																echo '<i class="fa fa-circle green_circle3" 					aria-hidden="true"></i>'; 
																}else{
																echo '<i class="fa fa-circle red_circle3" aria-hidden="true"></i>';
																}
															}//log 
															?> 
													</div> 
												</div>
											</div>
										</div>
									</article> 
								<?php } ?> 
							</div>  
							<footer >
								<a target="_blank" class="btn btn-primary more pull-right " 
								href="fyi_library.php?n=1">
								<div style="font-size: 18px;"> إقرا المزيد  </div>
								<div><i class="ion-ios-arrow-thin-left"></i></div>
							</a>
						</footer>
					<?php } ?> 
				</div> 
			<?php  } 

			function news_w_media($log){ ?> 
				<div class="col-md-8 col-sm-12 col-xs-12 "  >  
					<?php
					$table=array("News","Sports","Arts","Technology","General Culture");
					foreach ($table as $key => $value)  getrssnews($value,$log); 
					?>   
				</div> 
			<?php }  

			 
			if(isMobile()){ 
				news_w_media($log);	 
				news_wout_media($nbnews,$log); 
			}else{   
				news_wout_media($nbnews,$log);
				news_w_media($log);	 
			} 
			?>  
		</div>
	</div>
</section> 
<?php } ?>
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

<script  >
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

