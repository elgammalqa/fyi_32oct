<?php 
session_start();   ob_start();    
require_once('models/utilisateurs.model.php');
require_once('fyipanel/views/connect.php');
require_once('fyipanel/models/news_published.model.php'); 
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

	<body  class="skin-orange">
		  <?php require_once('fyi_header.php'); ?>
		<section class="category" style="margin-bottom: 30%" >
			 <div class="container">
			<div class="col-md-6 col-sm-12"> 
							<form   method="POST" class="search" autocomplete="off"   >
								<div class="form-group">
									<div class="input-group">
									 <input type="text" name="search" class="form-control"
									 placeholder="arama ... ">
									  <div class="input-group-btn">
											<button type="submit" name="search_news" class="btn btn-primary">
												<i class="ion-search"></i>
											</button>
										</div>
									</div>
								</div> 
							</form>								
						</div>
					</div>
		  <div class="container">
		    <div class="row"> 	 
	<div class="col-md-8 text-left">
    <?php if (isset($_POST['search_news'])) { 
	 if (isset($_POST['search'])) {
		 $searchq = $_POST['search'];  
		 $requete = $con->prepare("select count(*) from  news_published where title LIKE '%$searchq%' OR description LIKE '%$searchq%' OR pubDate LIKE '%$searchq%' "); 
              $requete->execute();
              $count = $requete->fetchColumn();  
              $query=utilisateursModel::find_search($searchq);
		if ($count == 0) { 
			echo 'Arama sonucu yoktu';
		}else if($searchq==""){ 
			echo ''; 
	    }else{ 
	    	 foreach($query as $row){  
				$linkv="fyi_detail.php?id=".$row['id'];
				if(isMobile()) $source="FYI_PRESS";  else $source="FYI PRESS";  
				$title = $row['title'];
				$description = $row['description'];
				$pubDate = $row['pubDate'];
				$type = $row['type']; 
				$id = $row['id'];   ?>
				<div class="row">
					<article class="col-md-11 box article-fw" style="padding-bottom:20px;" >
						<div class="details">  
							<h6>
								<a href="<?php echo $linkv; ?>" target="_blank" style="color: #000; font-weight: bold; font-size: 20px; " >
									<?php echo $title; ?>
								</a>
							</h6>
							<p> <?php echo $description; ?> </p> 
							
						<div class="form-group" > 
							<div class="col-md-4  col-sm-4 col-xs-3 " > 
							    <div class="time" style="color:#F73F52; font-size: 13px; " >
								   <?php echo $source; ?>
							    </div> 
						    </div>

						    <div class="col-md-4   col-sm-4 col-xs-3 " >
							    <div class="time" style="color:#F73F52; font-size: 13px; ">
								     <?php echo utilisateursModel::type($type); ?>
							    </div>
							</div>

							<div class="col-md-4   col-sm-4 col-xs-6" >
							     <div class="time" style="color:#F73F52; font-size: 13px; ">
							     	<?php echo $pubDate; ?>
							     </div> 
							</div>
						</div>
					</div>
					</article>
				</div> 
				<br>
			<?php } 
	     	}
	     }
      } ?>


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