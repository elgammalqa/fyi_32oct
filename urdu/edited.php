<?php
	require_once('online.php');
  if(isset($_COOKIE['fyiuser_email'])){
 	$user_email=$_COOKIE['fyiuser_email'];
}else if(isset($_SESSION['user_auth']['user_email'])){
	$user_email=$_SESSION['user_auth']['user_email'];
}           
 ?>
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>   
	<title style="text-align: right;" >إف واي آي برس</title>
	
		<style type="text/css">
			@media only screen and (max-width: 991px) {
		    #navbars {
			        margin-top: -50px;
			    }
 				
			#navid {
			  overflow: hidden;
			}
			#colorblack  li a{
				color: black;
			}

			.content {
			  padding: 16px;
			}

			.sticky {
			  position: fixed;
			  top: 0;
			  width: 100%;
			}

			.sticky + .content {
			  padding-top: 60px;
			} 
			#logocolor{
				background-color: #55abcd;
			}   
			}

	@media only screen and (min-width: 991px) { 
		<?php if ($log==false) {  ?>
			#colorblack  li a{
				color: white;
				font-size: 15px;  letter-spacing: 2px; font-weight: 700;
                line-height: 32px;  padding-top: 16px; padding-right: 50px;
			}
		<?php }else {  ?>
			#colorblack  li a{
				color: white;
				font-size: 15px;  letter-spacing: 2px; font-weight: 700;
                line-height: 32px;  padding-top: 16px; padding-right: 70px;
			}
	   <?php } ?>

			#colorblack2 li a{
				color: black;  
			} 
			.pl{
				 padding-left: 80px !important;
				  padding-top: 7px !important;
			}
			.plm li a{
				 padding-right: 40px !important;
			} 
			.header_float_right{
 					float: right !important ;
 				}
		} 

		</style>
	</head>
	 <head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
	 	 <!--<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css"> -->
	 	<link rel="stylesheet" type="text/css" href="fonts/EARLY_ACCESS.css">

	 </head>
	<header style="text-align: right;" class="primary">
		<div id="navbars" class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
			<nav class="menu" style="width: 100% ;height: 100%;   background-color: #55abcd" >
				<div class="container">					 
					<div style="background-color: #55abcd;" id="menu-list" dir="RTL">
						<ul id="colorblack" class="nav-list" dir="RTL" >   

								<li class="header_float_right" ><a id="logocolor" href="index.php"><img src="images/fyipress.png"  style="width: 140px; height: 23px;" ></a></li> 
								<li class="header_float_right" ><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" target="_blank" href="http://www.chatsrun.com"  >شاتس رن</a></li>
								<li class="header_float_right"><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" target="_blank" href="http://www.ispotlights.com"  >
									  سبوت لايتس 
                                	</a></li>

 
								<?php if ($log==false) {  ?>
							<li class="header_float_right"><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="login.php"  >
							سائن ان کریں</a>
						    </li>
							<li class="header_float_right"><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="register.php"  >رجسٹریشن</a></li> 
						<?php }else{ ?>
							<li style="font-size: 20px; padding-top: 20px;" class="dropdown magz-dropdown header_float_right>
							 <a style="padding-right: 0px !important;" >
							 ہیلو :   <?php  
								  echo utilisateursModel::getUserName($user_email);  ?>
								  &nbsp; &nbsp;
								    <i class="ion-ios-arrow-left"> </i>
								</a>
							 <ul id="colorblack2" class="dropdown-menu">  
									<li>
										<a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="resetpass.php">
										    <i  class="icon ion-key">  </i>اپنا پاس ورڈ تبدیل کریں 
									    </a>
									</li> 
									<li class="divider"></li>
									<li><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="logout.php">
										<i class="icon ion-log-out"></i> لاگ آؤٹ</a></li>
								</ul>
						    </li> 
						<?php } ?>
						 
						<li  class="font  header_float_right" ><a target="_blank"  href="search.php" >
								<i style="font-size: 17pt;" class="ion-search"> 	</i></a></li>

								<li  class="dropdown magz-dropdown header_float_right">
										<a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px; padding-left:50px;"> 
											اللغات 
											&nbsp;<i class="ion-ios-arrow-left"></i> </a>
										<ul id="colorblack2" class="dropdown-menu">
											<li><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" class="pl" href="index.php" >العربية</a></li>
											<li><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" class="pl" >ارڈو </a></li>

											<li><a class="pl" href="../index.php"  >English</a></li> 
											<li><a class="pl" href="../turkish/index.php" >Türkçe</a></li>
											<li><a class="pl"  >Teutsche</a></li>
											<li><a class="pl"  href="../spanish/index.php" >Español</a></li>
											<li><a class="pl"  >Français</a></li>
											<li><a class="pl"  >русский</a></li>
											<li><a class="pl"  >日本語</a></li>
											<li><a class="pl"  >中國</a></li>
											<li><a class="pl"  >भारतीय</a></li>
											<li><a class="pl"  >עברית</a></li>
										</ul> 
									</li> 
						</ul>
					</div>
				</div>  
			</nav>
		</div>
<!-- Start nav -->
			<nav id="navid" class="menu" style=" width: 100% ;height: 100%; margin-top: -25px;">
				<div class="container">
					<div class="brand header_float_right "  >
						<a href="index.php">
							<img  style="width: 100px; height: 23px; " src="images/fyipress.png" alt="fyi press Logo">
						</a>
					</div>
					<div class="mobile-toggle">
						<a href="#" data-toggle="menu" data-target="#menu-lists"><i class="ion-navicon-round"></i></a>
					</div>
					<div class="mobile-toggle">
						<a href="#" data-toggle="sidebar" data-target="#sidebar"><i class="ion-ios-arrow-left"></i></a>
					</div>
					<div class="mobile-toggle">
						<a href="#" data-toggle="menu" data-target="#menu-list"><i class="ion-ios-arrow-left"></i></a>
					</div>
					<div style="float: left;" class="mobile-toggle">
						<a href="#" data-toggle="menu" data-target="#menu-list"><img style="width: 60px;" src="images/fyipress.png"></a>
					</div>
				 <div id="menu-lists">
				 	<div class="container navbar">
 				<ul class="nav-list plm">  
							<li style="float: right;" >
							<a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="index.php">الرئيسية</a> 
							</li> 
							<li class="header_float_right" ><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="category.php?id=News&n=1">الأخبار</a></li> 
							<li class="header_float_right" ><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="category.php?id=Sports&n=1">الرياضة</a></li>
							<li class="header_float_right" ><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="category.php?id=Arts&n=1">الفن</a></li>
							<li class="header_float_right" ><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="category.php?id=Technology&n=1">التكنولوجيا</a></li>
							<li class="header_float_right" ><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="category.php?id=Culture&n=1">الثقافة العامة</a></li>
							<li class="header_float_right" ><a style="font-family: 'Droid Arabic Kufi', serif; letter-spacing: 0px;" href="library.php?n=1">المكتبة</a></li>
							
						</ul>
					</div>
				</div>
			</nav>
			<!-- End nav -->
		</header>
