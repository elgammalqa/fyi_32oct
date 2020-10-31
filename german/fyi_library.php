<?php 
session_start();   ob_start();    
require_once('models/utilisateurs.model.php');
require_once('fyipanel/models/news_published.model.php'); 
require_once('../models/v5.news_published.php'); 
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
		<?php require_once ("fyi_header.php"); ?> 
		<section class="category">
		  <div class="container"> 
		    <div class="row"> 	
		     <div class="row"> 
		          <div class="col-md-8">        
		            <ol class="breadcrumb">
		              <li><a href="#">Startseite</a></li>
		              <li class="active">Bibliothek</li>
		            </ol>
		            <h1 class="page-title">Kategorie: Bibliothek</h1> 
		            </div>
		        </div>   
		      <div style="padding-top: 40px;" class="col-md-8 text-left"> 
		    	<?php  
						if(isset($_GET['n'])&&!empty($_GET['n'])){ // id and num page existe   
								$numpage=$_GET['n'];
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
								 <a target="_blank" href="fyi_detail.php?id=<?php echo $news["id"]; ?>"  >
									  <img height="100%" src="images/img/pdf.jpg"  alt="Image"> 
							     </a>    
				              </figure>
				              <div class="details"> 
				                <h1><a target="_blank" href="fyi_detail.php?id=<?php echo $news['id']; ?>">
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
				                   <?php   if($log){
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
				        <?php 	} //for
				        }else{
						$req=$newspub->getspecialfeedsBySourcePdf($start,$nbrfeeds-$start);
						 foreach($req as $news){ ?>
							<article class="col-md-12 article-list">
				            <div class="inner">
				            <figure>   
								 <a target="_blank" href="fyi_detail.php?id=<?php echo $news["id"]; ?>"  >
									  <img height="100%" src="images/img/pdf.jpg"  alt="Image"> 
							     </a>    
				              </figure>
				              <div class="details"> 
				                <h1><a target="_blank" href="fyi_detail.php?id=<?php echo $news['id']; ?>">
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
				                   <?php   if($log){
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
										 	<a style="display: none;" href="fyi_library.php?n=
										 	<?php  echo $startpage-1; ?>">
										 		<i class="ion-ios-arrow-left"></i>
										 	</a>
										 </li> 
								<?php	}else{ ?> 
						                 <li class="prev">
										 	<a  href="fyi_library.php?n=<?php  echo $startpage-1; ?>">
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
											 	<a href="fyi_library.php?n=<?php  echo $i; ?>">
											 		<?php echo $i; ?> 
											    </a>
											</li>  
									<?php	}else{ ?>
											<li >
											    <a href="fyi_library.php?n=<?php  echo $i; ?>">
												    <?php echo $i; ?> 
											    </a>
										    </li> 
								<?php   }
									}

									//next button
									if (ceil($nbrpages/10)>ceil($numpage/10)) { ?>
										<li class="next">
											<a href="fyi_library.php?n=<?php  echo $endpage+1; ?>">
												<i class="ion-ios-arrow-right"></i>
											</a>
										</li> 
								<?php	}else{ ?>
							            <li class="next">
											<a  style="display: none;" 
											    href="fyi_library.php?n=<?php  echo  $endpage+1; ?>">
												<i class="ion-ios-arrow-right"></i>
											</a>
										</li>

				                    <?php   } ?>  
				                <?php   if($nbrpages>10&&$numpage==$nbrpages){ ?>
				                        	<li class="active" >
											    <a href="fyi_library.php?n=<?php  echo $nbrpages; ?>">
												    <?php echo $nbrpages; ?> 
											    </a>
										    </li>  
				                   <?php }else if($nbrpages>10){ ?>
				                        <li>
											    <a href="fyi_library.php?n=<?php  echo $nbrpages; ?>">
												    <?php echo $nbrpages; ?> 
											    </a>
									    </li> 
				              <?php  } ?>
				               </ul>
				            </div>   
		      </div>  
		  </div>  

                     <div class="col-md-4 sidebar" id="sidebar"> 
						<?php  if(v5newspublished::nbrhotnews()>0){  ?>
						<aside>
							<br>
							<h1  id="ptop" class="aside-title">Aktuelle Nachrichten</h1>
							<div class="aside-body"> 
							<?php       
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
										<h1 style="font-size: 20px;">
											<a target="_blank" href="<?php echo $link; ?>" > 
										   <?php echo $news['title']; ?> </a>
									    </h1>
										<div class="detail" style="padding-top: 10px;" >
										 <div class="category">
										 	  <a >  <?php echo utilisateursModel::type($typesection4); ?> </a>
										</div>
											<div class="time">
												<?php real_news_time($news['pubDate']); ?> 
										    </div>
										    <?php   if($log){
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