<?php 
session_start();   ob_start();    
require_once('models/utilisateurs.model.php');
require_once('timee.php');
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
			<style type="text/css">
			@media only screen and (min-width: 992px) {
    #ptop {
        padding-top: 15%;
    }
}
		</style>
	</head>

	<body class="skin-orange">
	<?php 
						require_once ("header.php"); 
						include 'fyipanel/models/news_published.model.php';
						include 'models/rssModel.php';
						if(isset($_GET['id'])&&!empty($_GET['id'])){
							$numpage=$_GET['id'];
							$rss = new rssModel(); 
							$nbrfeeds= $rss->nbrfeeds2();
							$nbrpages=ceil($nbrfeeds/10);
							if ($numpage>=1&&$numpage<=$nbrpages&&news_publishedModel::nbrhotnews()>0) {
								$nbhnews=0;
	 ?> 
		<section class="category">
		  <div class="container">
		    <div class="row">
		      <div class="col-md-8 text-left">
		        <div class="row">
		          <div class="col-md-12">        
		            <ol class="breadcrumb"> 
		              <li><a href="index.php">À la une</a></li>
		              <li class="active">FLUX RSS</li>
		            </ol>
		            <h1 class="page-title">Catégorie : RSS FEEDS</h1> 
		          </div>
		        </div>
		        <div class="line"></div>
		        <div class="row">
		         		<?php   
									 //news
									$start=$numpage*10-10;//0
									if ($nbrfeeds-$start>=10) {//25
										$nbhnews=4;
										 $req=$rss->getspecialfeeds($start,10);
								 			foreach($req as $news){ 
								 			 if($news['rank']==1){ 
											$linkv="detail.php?id=".$news['id'];
											 $typesectionv="FYI Press";   
										}else{ 
											$typesectionv=$news['Source']; 

										//zzz  
										if(news_publishedModel::source_not_open($typesectionv)){
										   $linkv=stripslashes($news['link']);
										}else{  
										   $has_http = strpos($news['link'],'http://') !== false; 
										   if($has_http){
										   	  $linkv=utilisateursModel::getLink("http_link")."/iframe.php?link=".stripslashes($news['link'])."&id=".$news['id'];
										   }else{
										   	  $linkv=utilisateursModel::getLink("https_link")."/iframe.php?link=".stripslashes($news['link'])."&id=".$news['id']; 
										   } 
										}
										//	
										} 
								 			  ?>
		          <article class="col-md-11" style="padding-bottom: 30px;" >
		              <div class="details">
		                <h6><a target="_blank" style="color: #000;" href="<?php echo $linkv; ?>">
		                	<?php echo stripslashes($news['title']); ?> 
		                	</a>
		                </h6>
		                <p>
		                  <?php echo stripslashes($news['description']); ?>
		                </p>
		                <div class="detail">
		                  <div class="category">
		                   <a  ><?php echo $typesectionv; ?></a>
		                  </div>
		                  <div class="time"><?php echo $news['pubDate']; ?></div>
		                </div> 
		              </div>
		          </article>		        
		         <?php  }   	
						}else{
					    $req=$rss->getspecialfeeds($start,$nbrfeeds-$start); 
					    if($nbrfeeds-$start==1) $nbhnews=1;
						 else $nbhnews=floor(($nbrfeeds-$start)/2);
					    foreach($req as $news){ 
					     if($news['rank']==1){ 
											$linkv="detail.php?id=".$news['id'];
											 $typesectionv="FYI Press";   
										}else{ 
											$typesectionv=$news['Source']; 
											
										//zzz  
										if(news_publishedModel::source_not_open($typesectionv)){
										   $linkv=stripslashes($news['link']);
										}else{  
										   $has_http = strpos($news['link'],'http://') !== false; 
										   if($has_http){
										   	  $linkv=utilisateursModel::getLink("http_link")."/iframe.php?link=".stripslashes($news['link'])."&id=".$news['id'];
										   }else{
										   	  $linkv=utilisateursModel::getLink("https_link")."/iframe.php?link=".stripslashes($news['link'])."&id=".$news['id']; 
										   } 
										}
										//	
										}     ?> 
					     <article class="col-md-11" style="padding-bottom: 30px;">
		              <div class="details">
		                <h6><a target="_blank" style="color: #000;" href="<?php echo $linkv; ?>">
		                	<?php echo stripslashes($news['title']); ?> 
		                	</a>
		                </h6>
		                <p>
		                  <?php echo stripslashes($news['description']); ?>
		                </p>
		                <div class="detail">
		                  <div class="category">
		                   <a  ><?php echo $typesectionv; ?></a>
		                  </div>
		                  <div class="time"><?php echo $news['pubDate']; ?></div>
		                </div> 
		              </div>
		          </article> 
		          <?php   }  } // if rest 1 
		          ?>
		          <div class="col-md-12 text-center  " style="padding-bottom: 30px;">
				            <ul class="pagination"> 

		                        <?php   if($numpage%10==0){
										$startpage=((floor($numpage/10)-1)*10)+1;
									}else{
										$startpage=(floor($numpage/10)*10)+1;
									}
						            
									if($numpage<=10){ 		 ?>
						                <li class="prev">
						                 <a style="display: none;" href="rssall.php?id=<?php echo $startpage-1; ?>">
												<i class="ion-ios-arrow-left"></i>
										 	</a>
										 </li> 
								<?php	}else{ ?> 
						               <li class="prev">
						                 <a   href="rssall.php?id=<?php echo $startpage-1; ?>">
												<i class="ion-ios-arrow-left"></i>
										 	</a>
										 </li> 
								<?php	}
 
									$a=floor(($numpage-1)/10)*10;
									if($nbrpages-$a<=10){
										$a=ceil($numpage/10)*10;
										$endpage=$a-($a-$nbrpages);

									}else{
										$endpage=ceil($numpage/10)*10;
									}

									for ($i=$startpage; $i <=$endpage; $i++) { 
										if($numpage==$i){ ?>  
					                  <li class="active">
										   <a href="rssall.php?id=<?php echo $i; ?>" >
										      <?php echo $i; ?> 
										  </a>
									  </li>  
									<?php	}else{ ?>
									<li >
										   <a href="rssall.php?id=<?php echo $i; ?>" >
										      <?php echo $i; ?> 
										  </a>
									  </li>  
								<?php   }
									}  

									//next button
									if (ceil($nbrpages/10)>ceil($numpage/10)) { ?> 
				                       <li class="next">
											<a href="rssall.php?id=<?php echo $endpage+1; ?>">
												<i class="ion-ios-arrow-right"></i>
											</a>
										</li>   
								<?php	}else{ ?>
							         <li class="next">
							         	<a  style="display: none;" href="rssall.php?id=<?php echo $endpage+1; ?>">
											 <i class="ion-ios-arrow-right"></i>
										</a>
									 </li>  
				                    <?php   } ?> 

				                <?php   if($nbrpages>10&&$numpage==$nbrpages){ ?>
				                        	<li class="active" >
											   <a href="rssall.php?id=<?php echo $nbrpages; ?>">
												    <?php echo $nbrpages; ?> 
											    </a>
										    </li>  
				                   <?php }else if($nbrpages>10){  ?>
				                        <li>
										   <a href="rssall.php?id=<?php echo $nbrpages; ?>">
											   <?php echo $nbrpages; ?> 
										    </a>
									    </li> 
				              <?php  }  ?>
				               </ul>
				            </div>  
				           <?php }}    ?>	 
		        </div>
		      </div>

		   
					<div class="col-md-4 sidebar" id="sidebar"> 
						<?php  if(news_publishedModel::nbrhotnews()>0){  ?>
						<aside>
							<br>
							<h1  id="ptop" class="aside-title">Dernières Actualités</h1>
							<div class="aside-body"> 
							<?php    
								$news=new news_publishedModel();   
									$query=$news->hotnews($nbhnews);
                        			foreach($query as $news){
                                      if($news['rank']==1){
											$media='fyipanel/views/image_news/'.$news['media']; 
											$link="detail.php?id=".$news['id'];
											$typesection4="FYI Press";   
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
										<h1 style="font-size: 15px;">
											<a target="_blank" href="<?php echo $link; ?>" > 
										   <?php echo $news['title']; ?> </a>
									    </h1>
										<div class="detail" style="padding-top: 10px;" >
										 <div class="category">
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
		</section>

		<?php require_once ('footer.php') ?>

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