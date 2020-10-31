<?php
	require_once('online.php');
  if(isset($_COOKIE['fyiuser_email'])){
 	$user_email=$_COOKIE['fyiuser_email'];
}else if(isset($_SESSION['user_auth']['user_email'])){
	$user_email=$_SESSION['user_auth']['user_email'];
}  ?>
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>   
	<title style="text-align: left;" > FYI Press </title>  
		<style type="text/css">
			@media only screen and (max-width: 991px) { 

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
                line-height: 32px;  padding-top: 16px; padding-right: 40px;
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
		}  
		</style>
	</head>
	
	<header class="primary">
		<div   class=" navbar-expand-lg fixed-top navbar-dark bg-primary">
			<nav class="menu" style="width: 100% ;height: 100%;   background-color: #55abcd; display: block !important;" >
				<div class="container">					
					<div style="background-color: #55abcd;" id="menu-list">
						<ul id="colorblack" class="nav-list">  
							 <?php if(isMobile()){ ?>
							<li style="background-color: red; " class="backk" >
								<a  style="font-size: 30px; color:#fff; border-bottom: none !important; ">
								назад <i style="text-align: left; font-size: 30px;"
								 class="ion-ios-arrow-forward"></i></a></li> 
							 <?php }else{ ?> 
							<li><a id="logocolor" href="index.php"><img src="images/fyipress.png" 
							style="width: 50px; height: 30px;" ></a></li>
							<li><a id="logocolor" href="fyi.php"><img src="../images/fyipress2.png" 
							style="width: 50px; height: 30px;" ></a></li>
							 <?php } ?>
							<li  ><a target="_blank" href="http://www.chatsrun.com"  >ChatsRun</a></li>
							<li><a target="_blank" href="http://www.ispotlights.com"  >SpotLight</a></li>
							<!--
							<li><a target="_blank" href="favorite_countries.php"  >любимые источники</a></li>
						    -->
							<?php if ($log==false) {  ?>
							<li><a href="login.php"  >вход</a></li>
							<li><a href="register.php"  >регистр</a></li> 
						<?php }else{ ?>
							<li class="dropdown magz-dropdown">
							 <a style="padding-right: 0px !important;" >
							   желанный : <?php  
								  echo utilisateursModel::getUserName($user_email);  ?>
								   <i class="ion-ios-arrow-right"></i>
								</a>
							 <ul id="colorblack2" class="dropdown-menu">  
									<li>
										<a href="resetpass.php">
										    <i  class="icon ion-key">  </i>изменить пароль
									    </a>
									</li> 
									<li class="divider"></li>
									<li><a href="logout.php">
										<i class="icon ion-log-out"></i> Выйти</a></li>
								</ul>
						    </li> 
						<?php }  
						 if(!isMobile()){ ?>
							<li  class="dropdown magz-dropdown">
										<a style="  padding-left:50px;">языки <i class="ion-ios-arrow-right"></i></a>
										<ul id="colorblack2" class="dropdown-menu">
											<li><a class="pl" href="../arabic/index.php"  >العربية</a></li>
											<li><a class="pl" href="../urdu/index.php" >ارڈو </a></li>
											<li><a class="pl" href="../home.php" >English</a></li> 
											<li><a class="pl"  href="../turkish/index.php"   >Türkçe</a></li>
											<li><a class="pl" href="../german/index.php" >Deutsche</a></li>
											<li><a class="pl" href="../spanish/index.php" >Español</a></li>
											<li><a class="pl" href="../french/index.php" >Français</a></li>
											<li><a class="pl" href="index.php"  >русский</a></li>
											<li><a class="pl" href="../japanese/index.php" >日本語</a></li>
											<li><a class="pl" href="../chinese/index.php">中國</a></li>
											<li><a class="pl" href="../indian/index.php" >भारतीय</a></li>
											<li><a class="pl"  href="../hebrew/index.php" >עברית</a></li>
										</ul> 
									</li>  
									  <?php } ?>
							<li  class="font"><a target="_blank"  href="fyi_search.php" style="padding-right: 0px;" >
								<i style="font-size: 17pt;" class="ion-search"> 	</i></a></li>
						</ul>
					</div>
				</div> 
			</nav> 
		</div> 
<!-- Start nav -->
			
			<?php if(!isMobile()){ ?>
			<nav id="navid" class="menu" style=" width: 100% ;height: 100%; ">
			<?php }else{  ?>
		    <nav id="navid" class="menu" style=" width: 100% ;height: 100%; background-color: #55abcd;  ">
			<?php } ?>
				<div class="container">
					<?php if(!isMobile()){ ?>
					<div class="brand">
						<a href="index.php">
							<img style="width: 50px; height: 30px;" src="images/fyipress.png"  alt="fyi press Logo">
						</a>
					</div>
					<div class="brand">
						<a href="fyi.php">
							<img style="width: 50px; height: 30px;" src="../images/fyipress2.png"  alt="fyi press Logo">
						</a>
					</div>
					<?php } ?>

					<div class="mobile-toggle">
						<a href="#" data-toggle="menu" data-target="#menu-lists"><i class="ion-navicon-round" style="color: red;"></i></a>
					</div>
				  
					<div class="mobile-toggle">
						<a href="#" data-toggle="menu" data-target="#menu-list"><i  class="ion-android-apps" style="color: red;"></i></a>
					</div>
					
					<div class="mobile-toggle">
					 <a href="#" data-toggle="menu" data-target="#menu-lang"><i class="ion-ios-world" style="color: red;"></i></a>
					</div>
					 <div style="float: left;" class="mobile-toggle">
						<a href="index.php" ><img style="width: 50px; height: 30px;"  src="images/fyipress.png"></a>
					</div> 
					 <div style="float: left;" class="mobile-toggle">
						<a href="fyi.php" ><img style="width: 50px; height: 30px;"  src="../images/fyipress.png"></a>
					</div>  
				 <div id="menu-lists">
						<ul class="nav-list plm"> 
							   	 <?php if(isMobile()){ ?>
							<li style="background-color: red; " class="backk" >
								<a style="  font-size: 30px; color:#fff; border-bottom: none !important; ">назад <i style="text-align: left; font-size: 30px;" class="ion-ios-arrow-forward"></i></a></li>
							 <?php } ?> 
							<li><a href="fyi_category.php?id=News&n=1">новости</a></li>
							<li><a href="fyi_category.php?id=Sports&n=1">спортивный</a></li>
							<li><a href="fyi_category.php?id=Arts&n=1">искусство</a></li>
							<li><a href="fyi_category.php?id=Technology&n=1">Технология</a></li>
							<li><a href="fyi_category.php?id=Culture&n=1">Общая культура</a></li> 
							<li><a href="fyi_library.php?n=1">библиотека</a></li>  
						</ul>
					</div>
					  <?php if(isMobile()){ ?>
                   <div id="menu-lang">
						<ul class="nav-list plm">  
							<li style="background-color: red; " class="backk" >
								<a style="  font-size: 30px; color:#fff; border-bottom: none !important; ">назад <i style="text-align: left; font-size: 30px;" class="ion-ios-arrow-forward"></i></a></li>
								<li><a class="pl" href="../arabic/index.php"  >العربية</a></li>
											<li><a class="pl" href="../urdu/index.php" >ارڈو </a></li>
											<li><a class="pl" href="../home.php" >English</a></li> 
											<li><a class="pl"  href="../turkish/index.php"   >Türkçe</a></li>
											<li><a class="pl" href="../german/index.php" >Deutsche</a></li>
											<li><a class="pl" href="../spanish/index.php" >Español</a></li>
											<li><a class="pl" href="../french/index.php" >Français</a></li>
											<li><a class="pl" href="index.php"  >русский</a></li>
											<li><a class="pl" href="../japanese/index.php"  >日本語</a></li>
											<li><a class="pl" href="../chinese/index.php">中國</a></li>
											<li><a class="pl" href="../indian/index.php" >भारतीय</a></li>
											<li><a class="pl"  href="../hebrew/index.php" >עברית</a></li> 

								</ul>
					</div>
                  <?php } ?>
				</div>
			</nav>
			<!-- End nav -->
		</header>  