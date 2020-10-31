<?php     
session_start();      
ob_start(); 
require_once('models/utilisateurs.model.php'); 
require_once ('../models/v5.news_published.php'); 
require_once ('timee.php');  
if(utilisateursModel::islogged())
	$log=true;  
else $log=false;    
$activee=1;     
$GLOBALS['nb_news_types']=0;

	$topSide=false;  $videosSide=false;  $bottomSide=false; 
	$nbnewstosh=v5newspublished::NbreNewsToShow();
	if(v5newspublished::nbrhotnews()>0&&(v5newspublished::nbr_ads2()>0||($nbnewstosh>0&&count(v5newspublished::NewsToShow($nbnewstosh))>0))){
			$topSide=true;
	}
	if(v5newspublished::nbrVideos()>0){ $videosSide=true; } 
	$table=array("News","Sports","Arts","Technology","General Culture"); 
	foreach ($table as $key => $value) 
	if(v5newspublished::nbrNewsBySourceindex($value)>0) $GLOBALS['nb_news_types']++; 
	if($GLOBALS['nb_news_types']>0&&(v5newspublished::nbr_news_without_images2()>0||v5newspublished::pdfcount()>0)) { $bottomSide=true; }
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
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/style2.css">
	<link rel="stylesheet" href="../css/skins/all.css"> 

	<link rel="stylesheet" href="../css/demo.css">  
	<style type="text/css">
		@media (min-width: 992px) { 
			.video_height{ height: 400px; } 
			}else{ 
				.video_height{ height: 200px; }	 
			}
			video[poster]{ 
				width:100%;
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
		if($topSide){
			?> 
			<section class="home" style="padding-bottom: 0px;padding-top: 0px;  <?php if(isMobile()) echo ' margin-top: -10px; ' ?> " >
				<div class="container"   >
					<div class="row"> 
						<div class="col-md-8 col-sm-12 col-xs-12 mainSadow"> <!-- here edit -->
							<?php     
							$nbseconds=v5newspublished::timToContinue();
							$realsconds=$nbseconds*1000; ?>
							<div data-interval="<?php echo $realsconds; ?>"  id="carouselExampleControls" class="carousel slide" data-ride="carousel" id="featured"  > 
								<div class="carousel-inner">
									<?php 
                          // ads  
									if (v5newspublished::nbr_ads2()>0) {
									$req=v5newspublished::ads();
										foreach($req as $news){
											if($activee==1)  echo '<div class="carousel-item  item active">';
											else  echo '<div class="carousel-item  item">';
											$activee=0;  ?> 
											<article>
												<?php  
												$type=v5newspublished::typeOfMedia($news['media']); 
												if ($type=="image") { ?>
													<a  href="fyi_detail_ads.php?id=<?php echo 
													$news['id'];  ?>"  >
													<img preload="none"   width="100%" class="video_height" style="  padding-bottom: 5px; " 
													src="<?php echo 'ads/image/'.$news['media']; ?>" 
													alt="Image"> 
												</a> 
											<?php	}else  if ($type=="video") { ?> 
												<a  href="fyi_detail_ads.php?id=<?php echo 
												$news['id'];  ?>">
												<video preload="none"  width="100%" controls="controls" class="video_height"
												<?php  $thumbnail=$news['thumbnail'];
												if ($thumbnail!=""){
													echo 'poster="'.$thumbnail.'"'; } ?>   >
													<source src="<?php echo 'ads/image/'.
													$news['media']; ?>"  
													>
												</video>  
											</a>
										<?php	} ?>    
										<div class="con-vid" > 
											<div style="padding-top: 10px;" class="one-t">
												<a style=" background-color: #FC624D;" >
													<?php echo "Actualités";  ?></a>
												</div>
												<h5 class="one-title">
													<a style="color: black;"  
													href="fyi_detail_ads.php?id=<?php echo $news['id'];  ?>" >
													<?php echo $news['title'];  ?> 
												</a>
											</h5>
											<div class=" time2">
												<a>FYI PRESS </a> &nbsp;&nbsp;&nbsp;&nbsp;
												<?php real_news_time($news['pubDate']); 
												if($log){
													if(v5newspublished::already_read_ads($news['id'])){
													echo '<i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: green; " aria-hidden="true"></i>';
													}else{
													echo '<i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: red; " aria-hidden="true"></i>';
													}
												}//log
												 ?>   
											</div>
											</div>
										</article>
									</div> 
								<?php } }   
                       		//news   
								$nbrnewstodisplay=v5newspublished::NbreNewsToShow(); 
								if($nbrnewstodisplay>0){ 
									$req=v5newspublished::NewsToShow($nbrnewstodisplay);
									foreach($req as $news){   
											$thumbnail=$news['thumbnail'];
											$mediav='fyipanel/views/image_news/'.$news['media']; 
											$linkv="fyi_detail.php?id=".$news['id'];
											if ($news['type']=="General Culture") $typesectionv="Culture";
											else  $typesectionv=$news['type']; 
											$source="FYI PRESS";   
										if ($activee==1) echo '<div  class="carousel-item active item">';
										else echo '<div class="carousel-item  item">';
										$activee=0; ?>   
										<article>
											<?php 	 
											$type=v5newspublished::typeOfMedia($news["media"]);  
											if ($type=="image") { ?>
												<a  href="<?php echo $linkv;  ?>"  >
													<img preload="none"   width="100%"  class="video_height"   style="   padding-bottom: 5px; "  src="<?php echo $mediav; ?>"  alt="Image"> 
												</a> 
											<?php	}else  if ($type=="audio"||$type=="video") { ?>  
												<video preload="none"  width="100%" class="video_height" controls 
												<?php if ($thumbnail!=""){ echo 'poster="'.$thumbnail.'"'; } ?>  >
												<source src="<?php echo $mediav; ?>">
												</video>  
											<?php }   ?>  
											<div class="con-vid" > 
												<div class="one-t">
													<a   href="fyi_category.php?id=
													<?php echo  $typesectionv; ?>&n=1" 
													style=" background-color: #FC624D;" >
													<?php  echo utilisateursModel::type($news['type']);  ?> 
												</a>
											</div>
											<h5 class="one-title">
												<a style="color:black;"  href="<?php echo $linkv;  ?>" >
													<?php echo $news['title'];  ?> 
												</a>
											</h5>
											<div class="time2">
												<a style=" text-transform: capitalize;" >
													<?php echo $source; ?> 
												</a> &nbsp;&nbsp;&nbsp;&nbsp;
													<?php real_news_time($news['pubDate']);
													if($log){
													if(v5newspublished::already_read($news['id'])){
													echo '<i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: green; " aria-hidden="true"></i>';
													}else{
													echo '<i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: red; " aria-hidden="true"></i>';
													}
												}//log
													 ?>  
											</div> 
											</div>
										</article>
									</div>  
								<?php  } }   
								?> 	
							</div> 
							<?php if(isMobile()){ ?>
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
					<?php }else{ ?>
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

	<div class="col-xs-12 col-sm-12 col-md-4 " id="margin_hotnews" >  
		<?php if(v5newspublished::nbrhotnews()>0){ ?> 
			<h1 class="title-col" >
				Dernières Actualités  	
				<div class="carousel-nav" id="hot-news-nav">
					<div class="prev">
						<i class="ion-ios-arrow-left"></i>
					</div>
					<div class="next">
						<i class="ion-ios-arrow-right"></i>
					</div>
				</div>  
			</h1>
			<div class="body-col vertical-slider" data-max="3" data-nav="#hot-news-nav" data-item="article" style="height: 500px !important;" > 
				<?php 
				$query=v5newspublished::hotnews(10); 
				foreach($query as $news){  ?> 
					<article class="article-mini shadowBox" style="margin-bottom: 10px;" > <!--edit here-->
						<div class="inner">
							<?php 
								$media='fyipanel/views/image_news/'.$news['media']; 
								$link="fyi_detail.php?id=".$news['id'];
								$typesection4=$news['type'];    
							?>
							<figure  style="width: 120px; height: 100px;" >
								<a  href="<?php echo $link;  ?>">
									<img preload="none"  src="<?php echo $media; ?>" alt="Image">
								</a>
							</figure>
							<div class="padding" style="padding-left: 50px;" >
								<h1 style="font-size: 12px;" ><a 
									href="<?php echo $link;  ?>">
									<?php echo $news['title'];  ?> 
								</a>
							</h1>
							<div class="detail" >
								<div class="category"> 
									<a >
										<?php   echo utilisateursModel::type2($typesection4);  ?> 
									</a>  
								</div>
								<div class="time">
									<?php real_news_time($news['pubDate']);  ?>
								</div>
								<?php 
								if($log){
													if(v5newspublished::already_read($news['id'])){
													echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: green; " aria-hidden="true"></i></div>';
													}else{
													echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: red; " aria-hidden="true"></i></div>';
													}
												}//log
								 ?> 
							</div>
						</div>
					</div>
				</article> 
			<?php } ?>
		</div>
	<?php } ?>
</div> 
</div>
</div> 
</section>
<?php } ?>



<div style="height: 40px; background-color: #e9ebee; " ></div>
<?php  if($videosSide){   ?>  
	<section  class="best-of-the-week" style="margin-bottom: 0px;padding-top: 0px;">
		<div class="container">
			<h1>
				<div class="text">Videos</div>
				<div class="carousel-nav" id="best-of-the-week-nav">
					<div class="prev">
						<i class="ion-ios-arrow-left"></i>
					</div>
					<div class="next">
						<i class="ion-ios-arrow-right"></i>
					</div>
				</div> 
			</h1>
			<div class="owl-carousel owl-theme carousel-1">
					<?php  $query=v5newspublished::videos(10); 
					foreach($query as $news){   
							$thumbnail=$news['thumbnail'];
							$mediav='fyipanel/views/image_news/'.$news['media']; 
							$linkv="fyi_detail.php?id=".$news['id'];
							$typesectionv=$news['type'];  
						?>    
						<article class="article"> 
							<div class="inner" style="box-shadow:none !important;" >
								<figure>
									<a>
										<video preload="none"  width="100%" height="100%" controls  
										<?php if ($thumbnail!=""){ echo 'poster="'.$thumbnail.'"'; } ?> >
										<source src="<?php echo $mediav; ?>"  >
										</video> 
									</a>
								</figure>
								<div class="padding"> 
									<h2><a   href="<?php echo $linkv; ?>">
										<?php echo $news['title']; ?></a></h2> 
										<div class="detail"> 
											<div class="category"> 
												<a>   <?php    echo utilisateursModel::type2($typesectionv);  ?>    </a> 
											</div> 
											<div class="time"><?php real_news_time($news['pubDate']);  ?></div>
									    <?php  if($log){
													if(v5newspublished::already_read($news['id'])){
													echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: green; " aria-hidden="true"></i></div>';
													}else{
													echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: red; " aria-hidden="true"></i></div>';
													}
												}//log
										?> 
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

		<?php    
		function getrssnews($n,$l){  
			if(v5newspublished::nbrNewsBySourceindex($n)>0){   	?>
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
							$typesectionv=$news['type'];   
						?>  
						<article class="col-md-12 article-list">
							<div class="inner">
								<figure> 
									<?php 	 
									$type=v5newspublished::typeOfMedia($news["media"]); 
								      //poster="https://addpipe.com/sample_vid/poster.png" hhh
									if ($type=="video"||$type=="audio") { ?>  
										<video preload="none"  height="100%"   width="100%" controls 
										<?php if ($thumbnail!=""){ echo 'poster="'.$thumbnail.'"'; } ?> >
										<source src="<?php echo $mediav; ?>"  >
										</video>
									<?php }else  if ($type=="image") { ?> 
										<a  href="<?php echo $linkv; ?>" > 
											<img preload="none"  height="100%"  src="<?php echo $mediav; ?>" alt="image">
										</a>
									<?php }   ?>  
								</figure>
								<div class="details"> 
									<h1><a  href="<?php echo $linkv; ?>" > 
										<?php echo $news["title"]; ?></a>
									</h1>
									<p>
										<?php echo $news["description"]; ?>
									</p>
									<footer>
										<div class="detail">
											<div class="category">
												<a><?php  echo utilisateursModel::type($typesectionv); ?></a>
											</div>
											<div class="time"><?php real_news_time($news["pubDate"]); ?></div>
											<?php 
												if($l){
													if(v5newspublished::already_read($news['id'])){
													echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: green; " aria-hidden="true"></i></div>';
													}else{
													echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: red; " aria-hidden="true"></i></div>';
													}
												}//log
											?>  
										</div>    
								</footer>
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
					<div>Lire la suite</div>
					<div><i class="ion-ios-arrow-thin-right"></i></div>
				</a>
			</footer>  
			<br><br><br>
		</div> 
	<?php	}}   

			if($bottomSide){  ?> 
		<section class=" home " style="padding-bottom: 0px;padding-top: 0px;"  >
			<div class="container">
				<div class="row" > 
					<!-- newssssss-->
					<div class="col-md-8 col-sm-12 col-xs-12 "  >  
						<?php   foreach ($table as $key => $value)  getrssnews($value,$log);  ?>     
					</div> <!-- endof8 -->  
					<div class="col-xs-12 col-sm-12 col-md-4" style="padding-bottom: 60px;" >  
						<?php  
						if(v5newspublished::nbr_news_without_images2()>0) {  
							$nbnews=$GLOBALS['nb_news_types']*6; 
							?>
							<aside><br>
								<div class="line" style="margin: 0px 0px;"><div>Actualités</div></div>
								<div class="tab-content">
									<div class="tab-pane active" id="recomended"> 
										<?php $query=v5newspublished::newsWithoutMedia($nbnews);
										foreach($query as $news){ 
												$linkv="fyi_detail.php?id=".$news['id'];
												$typesectionv=$news['type'];  
											?> 
											<article class="article-mini">
												<div class="inner"> 
													<h1><a  href="<?php echo $linkv; ?>">
														<?php echo $news['title']; ?></a></h1>
														<p><?php echo $news['description']; ?></p>
														<div class="detail">  
															<div class="category">
																<a>
																	<span class="fa fa-newspaper"></span> 
																	<b><?php echo utilisateursModel::type( $typesectionv); ?></b>
																</a>
															</div>   
															<div class="time"><?php echo real_news_time($news['pubDate']); ?></div>
															<?php  if($log){
																if(v5newspublished::already_read($news['id'])){
																	echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: green; " aria-hidden="true"></i></div>';
																}else{
																	echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: red; " aria-hidden="true"></i></div>';
																}
												}//log
												?> 
														</div> 
													</div>
												</article> 
											<?php } ?> 
											<footer >
												<a  class="btn btn-primary more pull-right " href="fyiall.php?id=1">
													<div>Lire la suite</div>
													<div><i class="ion-ios-arrow-thin-right"></i></div>
												</a>
											</footer>
										</div> 
									</div>
								</aside> 
							<?php } 

							if(v5newspublished::pdfcount()>0){ ?>
								<h1 class="title-col">
									Bibliothèque
									<div class="carousel-nav" id="hot-news-nav">
										<div class="prev">
											<i class="ion-ios-arrow-left"></i>
										</div>
										<div class="next">
											<i class="ion-ios-arrow-right"></i>
										</div>
									</div>
								</h1>
								<div class="body-col vertical-slider" data-max="4" data-nav="#hot-news-nav" data-item="article">
									<?php $query=v5newspublished::newsStartCountpdf();
									foreach($query as $news){  ?> 
										<article class="article-mini" >
											<div class="inner" >
												<figure>
													<a  href="fyi_detail.php?id=<?php echo $news['id'];  ?>">
														<img preload="none"  style="width: 100%; height: 100%" src="images/img/pdf.jpg" alt="Image">
													</a>
												</figure>
												<div class="padding">
													<h1><a  href="fyi_detail.php?id=<?php echo $news['id'];  ?>">
														<?php echo $news['title'];  ?> 
													</a>
												</h1> 
												<div class="detail"> 
													<div class="category">
														<a >
												  <?php   echo utilisateursModel::type($news['type']) ;  ?> 
														</a>
													</div>
													<div class="time"><?php real_news_time($news['pubDate']);  ?></div>
													<?php  if($log){
																if(v5newspublished::already_read($news['id'])){
																	echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: green; " aria-hidden="true"></i></div>';
																}else{
																	echo '<div class="time"><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: red; " aria-hidden="true"></i></div>';
																}
												}//log
												?> 
												</div>
											</div>
										</div>
									</article> 
								<?php } ?> 
							</div> 
							<hr>
							<footer >
								<a  class="btn btn-primary more pull-right " 
								href="fyi_library.php?n=1">
								<div>Lire la suite</div>
								<div><i class="ion-ios-arrow-thin-right"></i></div>
							</a>
						</footer>
					<?php } ?> 
				</div> 
			</div>
		</div> 
	</section> 
<?php } ?>

<!-- Start footer -->
<?php require_once ('footer.php') ?>
<!-- End Footer --> 
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

