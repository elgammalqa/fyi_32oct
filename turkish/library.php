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
	</head>

	<body class="skin-orange">
		 	 <?php require_once ("header.php"); ?> 
		<section class="category">
		  <div class="container">
		    <div class="row"> 	
		     <div class="row">
		          <div class="col-md-8">        
		            <ol class="breadcrumb">
		              <li><a href="#">Ana Sayfa </a></li>
		              <li class="active">Kütüphane</li>
		            </ol>
		            <h1 class="page-title">Kategori: Kütüphane</h1> 
		            </div>
		        </div>   
		      <div style="padding-top: 40px;" class="col-md-8 text-left"> 
		    	<?php  
						if(isset($_GET['n'])&&!empty($_GET['n'])){ // id and num page existe   
								$numpage=$_GET['n'];
								include 'fyipanel/models/news_published.model.php';
								$newspub = new news_publishedModel();
								$nbrfeeds= $newspub->nbrNewsPdf();//7
								$nbrpages=ceil($nbrfeeds/10); //1
								if ($numpage>=1&&$numpage<=$nbrpages) {   ?> 
							    <div class="line"></div>
							    <div class="row">
								<?php	$start=$numpage*10-10;//0 
									if ($nbrfeeds-$start>=10) {//25
										 $req=$newspub->getspecialfeedsBySourcePdf($start,10);
					 foreach($req as $news){ ?> 
				          <article class="col-md-12 article-list">
				            <div class="inner">
				              <figure>   
								 <a target="_blank" href="detail.php?id=<?php echo $news["id"]; ?>"  >
									  <img height="100%" src="images/img/pdf.jpg"  alt="Image"> 
							     </a>    
				              </figure>
				              <div class="details"> 
				                <h1><a target="_blank" href="detail.php?id=<?php echo $news['id']; ?>">
				                	<?php echo $news['title']; ?></a>
				                </h1>
				                <p> <?php echo $news['description']; ?>  </p>
				                <div class="detail">
				                  <div class="category"> 
				                    <a>
				                   	  <?php echo news_publishedModel::nameReporter2($news['employee']); ?>
				                    </a>
				                  </div>
				                  <div class="time"><?php real_news_time($news['pubDate']); ?></div>
				                </div> 
				              </div>
				            </div>
				          </article>
				        <?php 	} //for
				        }else{
						$req=$newspub->getspecialfeedsBySourcePdf($start,$nbrfeeds-$start);
						 foreach($req as $news){ ?>
							<article class="col-md-12 article-list">
				            <div class="inner">
				            <figure>   
								 <a target="_blank" href="detail.php?id=<?php echo $news["id"]; ?>"  >
									  <img height="100%" src="images/img/pdf.jpg"  alt="Image"> 
							     </a>    
				              </figure>
				              <div class="details"> 
				                <h1><a target="_blank" href="detail.php?id=<?php echo $news['id']; ?>">
				                	<?php echo $news['title']; ?></a>
				                </h1>
				                <p> <?php echo $news['description']; ?>  </p>

				                <div class="detail">
				                  <div class="category"> 
				                   <a  >
				                   	<?php echo news_publishedModel::nameReporter2($news['employee']); ?> 
				                   </a>
				                  </div>
				                  <div class="time"><?php real_news_time($news['pubDate']); ?></div>
				                </div> 
				              </div>
				            </div>
				          </article>
				      <?php   } // for   	
									} // last page  3 open 
									?> 
						<div class="col-md-12 text-center  " style="padding-bottom: 30px;">
				            <ul class="pagination"> 
								<?php	if($numpage%10==0){
										$startpage=((floor($numpage/10)-1)*10)+1;
									}else{
										$startpage=(floor($numpage/10)*10)+1;
									}
						            
									if($numpage<=10){ 		 ?>
										 <li class="prev">
										 	<a style="display: none;" href="library.php?n=
										 	<?php  echo $startpage-1; ?>">
										 		<i class="ion-ios-arrow-left"></i>
										 	</a>
										 </li> 
								<?php	}else{ ?> 
						                 <li class="prev">
										 	<a  href="library.php?n=<?php  echo $startpage-1; ?>">
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
											 	<a href="library.php?n=<?php  echo $i; ?>">
											 		<?php echo $i; ?> 
											    </a>
											</li>  
									<?php	}else{ ?>
											<li >
											    <a href="library.php?n=<?php  echo $i; ?>">
												    <?php echo $i; ?> 
											    </a>
										    </li> 
								<?php   }
									}

									//next button
									if (ceil($nbrpages/10)>ceil($numpage/10)) { ?>
										<li class="next">
											<a href="library.php?n=<?php  echo $endpage+1; ?>">
												<i class="ion-ios-arrow-right"></i>
											</a>
										</li> 
								<?php	}else{ ?>
							            <li class="next">
											<a  style="display: none;" 
											    href="library.php?n=<?php  echo  $endpage+1; ?>">
												<i class="ion-ios-arrow-right"></i>
											</a>
										</li>

				                    <?php   } ?>  
				                <?php   if($nbrpages>10&&$numpage==$nbrpages){ ?>
				                        	<li class="active" >
											    <a href="library.php?n=<?php  echo $nbrpages; ?>">
												    <?php echo $nbrpages; ?> 
											    </a>
										    </li>  
				                   <?php }else if($nbrpages>10){ ?>
				                        <li>
											    <a href="library.php?n=<?php  echo $nbrpages; ?>">
												    <?php echo $nbrpages; ?> 
											    </a>
									    </li> 
				              <?php  } ?>
				               </ul>
				            </div>   
		      </div>  
		  </div>  

                     <div class="col-md-4 sidebar" id="sidebar"> 
						<?php  if(news_publishedModel::nbrhotnews()>0){  ?>
						<aside>
							<br>
							<h1  id="ptop" class="aside-title">Güncel Haberler</h1>
							<div class="aside-body"> 
							<?php    
								$news=new news_publishedModel();   
									$query=$news->hotnews(4);
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
			                 <?php  }else{ ?> 
                              		<script>
							           window.location.replace('404.php');
						            </script> 
                             <?php } // numpage 
                          }else{ // get isset ?> 
                          	<script>
							           window.location.replace('404.php');
						    </script> 
						<?php } ?>
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