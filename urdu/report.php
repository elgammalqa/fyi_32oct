<?php 
session_start();      
if(isset($_COOKIE['fyiuser_email'])){
 	$user_email=$_COOKIE['fyiuser_email'];
}else if(isset($_SESSION['user_auth']['user_email'])){
	$user_email=$_SESSION['user_auth']['user_email'];
} 
require_once('models/utilisateurs.model.php');
require_once('models/comments.model.php');
require_once('models/replies.model.php');
require_once('timee.php');
require_once('models/reports.model.php');
require_once('fyipanel/models/news_published.model.php');
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
	 
		<title>FYI PRESS</title>
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
        <style type="text/css">
        	.myfont{
        		font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;
		      direction: rtl; 
		      color: black !important;
		      font-size: 30px;
		      float: right;
		      font-weight: bold;
		      padding-bottom: 10px;
        	}

        	.newFont{ 
		      font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;
		      direction: rtl; 
		      color: black !important;
		      font-size: 22px;
    		} 

    		.article-fw {
			    display: inline-block;
			    margin-bottom: 20px !important;  
			    border-radius: 10px;
			    padding: 10px;
			    padding-bottom: 10px !important;
			    box-shadow: 0 15px 30px 0 rgba(0,0,0,0.11), 0 5px 15px 0 rgba(0,0,0,0.08);
			}
        </style>
  </head> 
	<body  class="skin-orange"> 
	 	 <?php require_once ("header.php"); ?>  
		<section class="single">
			<div class="container">
				<div class="row">   
			 <div class="col-md-4 sidebar" id="sidebar" style="margin-top: 15px;"> 
					  <?php if(news_publishedModel::nbrhotnews()>0){  ?> 
						<aside> 
							<br>
							<h5 class=" float_right" style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; margin-bottom: 0px;"  > موجودہ خبریں  </h5> 
							    <div class="line" style="margin-bottom: 10px; margin-top: 20px;" ></div>
							<div class="aside-body"> 
								<?php    
								$news=new news_publishedModel();   
									$query=$news->hotnews(1);
                        			foreach($query as $news){
                                      if($news['rank']==1){
											$media='fyipanel/views/image_news/'.$news['media']; 
											$link="detail.php?id=".$news['id'];
											$typesection4=" Fyi Press ";   
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
										<p class="float_right" >
											<a target="_blank" href="<?php echo $link; ?>" class="newFont" > 
										   <?php echo $news['title']; ?> </a>
									    </p> 
										<div class="detail float_right "   >
										    <div class="category fs_cat">
										 	  <a style=" font-size: 20px !important;">  
									          <?php echo $typesection4; ?> </a>
										   </div>
										  	<div class="time fs_cat" style=" font-size: 20px !important;">
												<?php real_news_time($news['pubDate']); ?> 
										    </div>
										     <span style="padding-right: 17px;" ></span>
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
		            <br><br><br><br> 
		            <form method="post" > 
		            <div style="padding-left: 50px; padding-right: 50px;" >
		            	 <div class="form-group">
				            <label for="sel1" class="myfont" > رپورٹ کی قسم  </label>
				              <select required="required" name="typee" class="form-control" id="sel1" 
				              class="myfont2" style="font-size: 20px;"> 
				                <option value="A bad words" > ایک خراب الفاظ  </option>
				                <option value="Sexual content" >جنسی مواد  </option>
				                <option value="Violent content" >تشدد کا مواد  </option>
				                <option value="A bad words" > ایک خراب الفاظ  </option>
				                <option value="Hate speech" > نفرت انگیز تقریر  </option>
				                <option value="Abuse" > بدسلوکی  </option>
				              </select>
				          </div>
				          <div class="form-group">
				            <label for="pwd" class="myfont">    دیگر   </label>
				            <textarea name="other" rows="5" cols="20" class="form-control" 
				            style="font-size: 20px;"></textarea> 
				         </div>
				         <div class="modal-footer">
				          <button  type="submit" name="send" class="btn btn-success " data-dismiss="modal" style="float: left;" >
				          	   بھیجیں 
				          </button>
				          <button type="submit" name="back" class="btn btn-primary" data-dismiss="modal"
				        style="float: left;">
				          	پیچھے 
				          </button>
				        </div>  
		            </div>
		            </form>
		            	<?php 


		            	if (isset($_GET['id'])&&!empty( $_GET['id'])&&isset($_POST['back'])){ ?>
		            		<script type="text/javascript">
		            			window.location.replace('detail.php?id=<?php echo $_GET['id']; ?>');
		            		</script>
		            <?php	}else if ((!isset($_GET['id'])||empty( $_GET['id']))&&isset($_POST['back'])){ ?>
		            		<script type="text/javascript">
		            			window.location.replace('index.php');
		            		</script>
		          <?php   }



		            	if (isset($_POST['send'])){ 
		            	 if (isset($_GET['id'])&&!empty( $_GET['id'])&&isset($_GET['id_c'])&&!empty($_GET['id_c'])&&isset($_POST['typee'])&&!empty($_POST['typee']) ) {  
		            	  $report=new reportModel();
		            	  $id_news=$_GET['id'];
		            	  $id_comment=$_GET['id_c'];
		            	  $report->setid_news($id_news); 
		            	  $report->setemail_user_report($user_email); 
		            	  $report->setemail_user_abuse(reportModel::getemail_user_abuse_2($id_comment));
		            	  $report->setid_comment($id_comment);
		            	  $report->setid_reply("null");
                             date_default_timezone_set('GMT');
		            	  $report->setdate_report(date("Y-m-d H:i:s")); 
		            	  $report->settype($_POST['typee']);
		            	  if (isset($_POST['other'])&&!empty($_POST['other'])) $report->setother($_POST['other']);  
		            	   	else $report->setother('');     
		            	   if ($report->add_report()) { ?>   
                             <script> 
                             	window.location.replace('detail.php?id=<?php echo $_GET['id']; ?>');
                             </script>
                        <?php  }else{ ?>  
                        	<script> 
                        	      swal("توجہ","رپورٹ شامل نہیں ہے! آپ نے پہلے ہی اس تبصرہ کی اطلاع دی ہے","warning");
                            </script> 
		           		<?php }  
		           	}//id c
  
		            if (isset($_GET['id'])&&!empty($_GET['id'])&&isset($_GET['id_r'])&&!empty($_GET['id_r'])&&isset($_POST['typee'])&&!empty($_POST['typee']) ) {
		            	$id_news=$_GET['id'];
		            	$id_reply=$_GET['id_r'];
		            	  $report=new reportModel(); 
		            	  $report->setid_news($id_news);
		            	  $report->setemail_user_report($user_email);
		            	  $report->setemail_user_abuse(reportModel::getemail_user_abuse_r($id_reply));
		            	  $report->setid_comment("null");
		            	  $report->setid_reply($id_reply);
                          date_default_timezone_set('GMT');
		            	  $report->setdate_report(date("Y-m-d H:i:s")); 
		            	  $report->settype($_POST['typee']);
		            	  if (isset($_POST['other'])&&!empty($_POST['other'])) $report->setother($_POST['other']);  
		            	   	else $report->setother(''); 
  
		            	   if ($report->add_report()) { ?>   
                             <script> 
                             	window.location.replace('detail.php?id=<?php echo $_GET['id']; ?>');
                             </script>
                        <?php  }else{ ?> 
                        	<script> 
                        	      swal("توجہ","رپورٹ شامل نہیں ہے! آپ نے پہلے ہی اس تبصرہ کی اطلاع دی ہے","warning");
                            </script> 
		           		<?php } 
		           		 }
		           		}//send
		           		  ?> 
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
		<!--<script src="../js/demo.js"></script> -->
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