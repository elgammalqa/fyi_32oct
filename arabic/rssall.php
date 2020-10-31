<?php 
session_start();   ob_start();    
require_once('models/utilisateurs.model.php');
require_once('fyipanel/models/news_published.model.php');
require_once('models/rssModel.php');  
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
			<style type="text/css">
			@media only screen and (min-width: 992px) {
    #ptop {
        padding-top: 23%;
    }
}

                .float_right{
					float: right !important;
					text-align: right;
					font-family: 'Droid Arabic Kufi', serif; 
					letter-spacing: 0px;
				} 
				.float_left{
					float: left !important;
					text-align: left;
				}
				 
				.fs_cat{
					font-size: 18px !important;
				} 
		</style>
	</head>

	<body class="skin-orange">
		 <?php require_once ("header.php");  
							if(isset($_GET['id'])&&!empty($_GET['id'])){
								$numpage=$_GET['id'];
								$rss = new rssModel(); 
								$nbrfeeds= $rss->nbrfeeds2();
								$nbrpages=ceil($nbrfeeds/10);
								if ($numpage>=1&&$numpage<=$nbrpages) {
									$start2=$numpage*10-10;//0
									if ($nbrfeeds-$start2>=10) {//25
										$nbhnews=5; 
									}else{
								      if($nbrfeeds-$start2==1) $nbhnews=1;
									     else $nbhnews=floor(($nbrfeeds-$start2)/2);
									}
		  ?> 
		<section class="category">
		  <div class="container">
		    <div class="row"> 
		    	 <div class="col-md-4 sidebar" id="sidebar"  > 
					  <?php if(news_publishedModel::nbrhotnews()>0){  ?> 
						<aside> 
							<br>
							<h1 class="aside-title float_right" style="margin-bottom: 0px;"  >الاخبار الحالية</h1> 
							    <div class="line"  ></div>
							<div class="aside-body"> 
								<?php    
								$news=new news_publishedModel();   
									$query=$news->hotnews($nbhnews);
                        			foreach($query as $news){
                                      if($news['rank']==1){
											$media='fyipanel/views/image_news/'.$news['media']; 
											$link="detail.php?id=".$news['id'];
											$typesection4="إف واي آي برس";   
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
									<div class="details float_right">
										<h5  >
											<a style="color: black !important ; text-align: right;" target="_blank" href="<?php echo $link; ?>" > 
										   <?php echo $news['title']; ?> </a>
									    </h5> 
										<div class="detail float_right "   >
										  	<div class="time fs_cat">
												<?php real_news_time($news['pubDate']); ?> 
										    </div>
										    <div class="category fs_cat">
										 	  <a >  
									          <?php echo utilisateursModel::source($typesection4); ?> </a>
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

		            <div class="col-md-8 float_right "> 
		      	            <div  >
					 	        <ol   style="list-style: none; " >
						            <li class="float_right fs_cat "  ><a href="index.php">الرئيسية</a>
						              </li>
						            <li class="float_right fs_cat">  &nbsp; / &nbsp;</li> 
						            <li class="float_right fs_cat" class="active"> الاخبار  </li>
                                </ol> 
                                <br><br>
					        </div>

							    <div class="line"></div>
							     <div class="row">
		         		<?php    
									 //news
									$start=$numpage*10-10;//0
									if ($nbrfeeds-$start>=10) {//25
										 $req=$rss->getspecialfeeds($start,10);
								 			foreach($req as $news){ 
								 			 if($news['rank']==1){ 
											$linkv="detail.php?id=".$news['id'];
											 $typesectionv="إف واي آي برس";   
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
		          <article class="box"   style="padding-bottom: 50px;  " >
		              <div class="details">
		                <h5><a target="_blank" style="color: #000; font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; font-size: 17px; " href="<?php echo $linkv; ?>">
		                	<?php echo stripslashes($news['title']); ?> 
		                	</a>
		                </h5>
		                <p style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;font-size: 16px ! important;">
		                   <?php
				                    $real_sentence=stripslashes($news["description"]);
				                    $nb_words=str_word_count($real_sentence);
				                    $sentence=implode(' ', array_slice(explode(' ', $real_sentence), 0, 40));
				                      echo $sentence;  
				                     if ($nb_words>300) {
				                      echo '<br> ...';
				                     }   
				                ?>   
		                </p>
		                <div class="detail" style=" float: right;  " >
		                  
		                  <div class="time" style="font-size: 18px ! important;">
		                  	<?php echo real_news_time($news['pubDate']); ?></div>
		                  	<div class="category  " style="font-size: 18px ! important; text-align: right;"   >
		                   <a  ><?php echo utilisateursModel::source($typesectionv); ?></a>
		                  </div>
		                </div> 
		              </div>
		          </article>		        
		         <?php  }   	
						}else{
					    $req=$rss->getspecialfeeds($start,$nbrfeeds-$start);
					    foreach($req as $news){ 
					     if($news['rank']==1){ 
											$linkv="detail.php?id=".$news['id'];
											 $typesectionv="إف واي آي برس";   
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
					 <article class="box"   style="padding-bottom: 50px;">
		              <div class="details">
		                <h5><a target="_blank" style="color: #000; font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; font-size: 17px; " href="<?php echo $linkv; ?>">
		                	<?php echo stripslashes($news['title']); ?> 
		                	</a>
		                </h5>
		                <p style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;font-size: 16px ! important;">
		                   <?php
				                    $real_sentence=stripslashes($news["description"]);
				                    $nb_words=str_word_count($real_sentence);
				                    $sentence=implode(' ', array_slice(explode(' ', $real_sentence), 0, 40));
				                      echo $sentence;   
				                     if ($nb_words>300) {
				                      echo '<br> ...';
				                     }   
				                ?>   
		                </p>
		                <div class="detail" style=" float: right;" >
		                  <div class="category" style="font-size: 18px ! important;">
		                   <a  ><?php echo utilisateursModel::source($typesectionv); ?></a>
		                  </div>
		                  <div class="time" style="font-size: 18px ! important; ">
		                  	<?php echo real_news_time($news['pubDate']); ?>
		                  		
		                  	</div>
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
						                <li class="prev float_right">
						                 <a style="display: none;" href="rssall.php?id=<?php echo $startpage-1; ?>">
												<i class="ion-ios-arrow-left"></i>
										 	</a>
										 </li> 
								<?php	}else{ ?> 
						               <li class="prev float_right">
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
					                  <li class="active float_right">
										   <a href="rssall.php?id=<?php echo $i; ?>" >
										      <?php echo $i; ?> 
										  </a>
									  </li>  
									<?php	}else{ ?>
									<li class="float_right" >
										   <a href="rssall.php?id=<?php echo $i; ?>" >
										      <?php echo $i; ?> 
										  </a>
									  </li>  
								<?php   }
									}  

									//next button
									if (ceil($nbrpages/10)>ceil($numpage/10)) { ?> 
				                       <li class="next float_right">
											<a href="rssall.php?id=<?php echo $endpage+1; ?>">
												<i class="ion-ios-arrow-left"></i>
											</a>
										</li>   
								<?php	}else{ ?>
							         <li class="next float_right">
							         	<a  style="display: none;" href="rssall.php?id=<?php echo $endpage+1; ?>">
											 <i class="ion-ios-arrow-left"></i>
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