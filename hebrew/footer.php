<?php   
           function getfooteratt($data){
           	 include 'fyipanel/views/connect.php';
            $requete = $con->prepare('select '.$data.' from footer where id=1');
            $requete->execute();
            $name = $requete->fetchColumn();
            echo $name;  
           }  
                  function get_data_condition($link,$table,$cond,$value){  
            include($link); $tab = array();      
            $query=$con->query('select * from '.$table.' where '.$cond.'="'.$value.'" ');
            while ($data = $query->fetch())  $tab[] = $data; 
            return $tab; 
        } 

        function get_ad_id($link,$t){  
            include($link);   
            $query=$con->query('select id_add from times_hot_ads where "'.$t.'" between ad_from and ad_to');
            $id = $query->fetchColumn();  
            return $id;
        }  
           function likes(){
           	 include '../fyipanel/views/connect.php';
            $requete = $con->prepare('select fyi_likes from footer where id=1');
            $requete->execute();
            $name = $requete->fetchColumn();
            echo $name;  
           }   
           function myLogo($sp){  ?>
 			<li class="list-inline-item"><a target="_blank" href="<?php getfooteratt($sp); ?>">
 				<i><img src="../logos/<?php echo $sp; ?>.png"  class="widthHeight" ></i></a></li>
          <?php  }  ?>  
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script><link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
	<style type="text/css"> 
section {
    padding: 60px 0; 
}

section .section-title {
    text-align: center;
    color: #007b5e;
    margin-bottom: 50px;
    text-transform: uppercase;
}
#footer {
    background: #3da0ca !important;
    /* v5 */
    padding-top: 30px !important;
    padding-bottom: 30px !important; 
}
#footer h5{
	padding-left: 10px;
    border-left: 3px solid #eeeeee;
    padding-bottom: 6px;
    margin-bottom: 20px;
    color:#ffffff;
}
#footer a {
    color: #ffffff;
    text-decoration: none !important;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
}
#footer ul.social li{
	/* should set */
	padding: 3px 0;
}
#footer ul.social li a i {
    margin-right: 5px;
	font-size:25px;
	-webkit-transition: .5s all ease;
	-moz-transition: .5s all ease;
	transition: .5s all ease;
}
#footer ul.social li:hover a i {
	font-size:30px;
	margin-top:-10px;
}
#footer ul.social li a,
#footer ul.quick-links li a{
	color:#ffffff;
}
#footer ul.social li a:hover{
	color:#eeeeee;
}
#footer ul.quick-links li{
	padding: 3px 0;
	-webkit-transition: .5s all ease;
	-moz-transition: .5s all ease;
	transition: .5s all ease;
}
#footer ul.quick-links li:hover{
	padding: 3px 0;
	margin-left:5px;
	font-weight:700;
}
#footer ul.quick-links li a i{
	margin-right: 5px;
}
#footer ul.quick-links li:hover a i {
    font-weight: 700;
}

@media (max-width:767px){
	#footer h5 {
    padding-left: 0;
    border-left: transparent;
    padding-bottom: 0px;
    margin-bottom: 10px;
}
}
.xfooter{ 
		font-size: 40px !important;
		color:white;
		text-align: center;
}
.xfooter2{ 
		font-size: 30px !important;
		color:white;
		text-align: center;
}
.xfooter3{ 
		font-size: 20px !important;
		color:white;
		text-align: center;
}
@media (min-width: 361px){   
     	.widthHeight{
			width: 30px; height: 30px;
		}
}
@media (max-width: 360px){   
     	.widthHeight{
			width: 25px; height: 25px;
		}
} 
.xnumber{
			font-weight: bold;
			font-size: 20px;  
}

@media (min-width: 992px){   
		.footerCenter{
			    width: 42%;
   				margin-left: 29%;
   				float: left;
		}
}

@media (max-width: 668px){   
		.social li a {
		width: 30px !important;
		}
}

@media (min-width: 669px){   
		.social li a {
		width: 40px !important;
		}
}
.likeButton{
	background-color: white; border: none;
}


div.fixeddiv {
      background-image: url("../logos/hebrew.png"); 
      position: fixed;
      top: 145px;
      left: 15px;  
      width: 56px;
      height: 145px;
      background-size: cover;
      padding: 3px;
      z-index: 999;
    }

div.fixeddiv2 {
      background-image: url("../logos/hebrew.png"); 
      position: fixed;
      bottom:240px;
      left: 0px;  
      width: 56px;
      height: 145px;
      background-size: cover;
      padding: 3px;
      z-index: 999;
    }
    div.fixeddiv3 { 
      position: fixed;
      bottom:0px;
      right: 0px;  
      left: 0px;  
      width: 100%;
      height: 180px;  
      z-index: 999;
    }
   
	</style> 	 
</head>  
	<?php if(!isMobile()){ ?>
	<section id="footer"   >
<?php }else{ ?>
<section id="footer"  style="margin-bottom:180px !important; " >
<?php } ?>
		<?php if(!isMobile()){ ?>
		 <div class="fixeddiv" >  
		 <?php }else{ ?>
		 <div class="fixeddiv2"  > 
		 	<?php } ?>
		 	<a target="_blank"  href="<?php getfooteratt('whatsapp'); ?>">
		 		<li class="lifirst" ><img src="../logos/Message-icon.png" ></li>
		 	</a>
		 	<a target="_blank" href="<?php getfooteratt('email'); ?>">
		 		<li class="lisecond"><img src="../logos/Email-icon.png" ></li>
		 	</a>  
		 </div> 






	<?php if(isMobile()){
		$there_is_ad=false;
		date_default_timezone_set('GMT'); 
     	$time_now=date("H:i").':00'; 
     	$id_of_ad=get_ad_id('fyipanel/views/connect.php',$time_now);
     	if($id_of_ad==null){//default ad
			$q=get_data_condition('fyipanel/views/connect.php','default_hot_ad','id',1);
			foreach ($q as $key => $value) {
				$media_=$value['media'];
				$link_=$value['link'];
				$fit_=$value['fit'];
		    } ?> 
			<div class="fixeddiv3"  >   
		 		<a <?php if($link_!=null) { echo 'href="'.$link_.'"'; } ?> >
				<img src="hot_ads/media/<?php echo  $media_; ?>"  
 					style="background-color: white; height: 180px; width: 100%;
 					 border: none; object-fit: <?php echo $fit_; ?>;" >
		   		 </a> 
		 	</div>  
		    <?php   
		    }else{//there is an ad 
     			$there_is_ad=true;
     			$qr=get_data_condition('fyipanel/views/connect.php','hot_ads','id',$id_of_ad);
     			foreach ($qr as $key => $value_ad) {
     				$media_ad=$value_ad['media'];
     			    $thumb_ad=$value_ad['thumbnail'];
     				$link_ad=$value_ad['link'];
     				$id_ad=$value_ad['id'];
     				$fit_ad=$value_ad['fit'];
     			} 
     			$img_or_video=news_publishedModel::typeOfMedia($media_ad); 
 				?>
     			<div class="fixeddiv3"  >   
		 		<?php if($img_or_video=='image'){ ?> 
					<form method="post" >
 						<button name="add_hot_ad" type="submit" style="width: 100%"   >
 							<img src="hot_ads/media/<?php echo $media_ad; ?>"  
 								style="height: 180px; width: 100%; object-fit: <?php echo $fit_ad; ?> " >
 						</button>
 					</form> 
     			<?php }else if($img_or_video=='video'){ ?>
     				<video id="myVideo" style="height: 180px; width: 100%; " controls
						<?php if ($thumb_ad!=""){ echo 'poster="hot_ads/thumbnail/'.$thumb_ad.'"'; } ?> >
							<source src="hot_ads/media/<?php echo $media_ad; ?>" >
					</video>
     				<?php } ?>
		 	    </div>  
	<?php  } 
	if($there_is_ad) {  include('count_hot_ads.php'); }
}?> 


		<div class="container">
			<div class="row text-center text-xs-center text-sm-left text-md-left" style="padding-bottom: 30px;"  >
				<div class="col-xs-12 col-sm-12 col-md-12">
					<p class="xfooter"> מי אנחנו </p> 
					<p class="xfooter2">
						 <?php $sp='aboutus'; getfooteratt($sp); ?>
					</p>
				</div> 

			</div> 
			<div class="row"  >
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5" >
					<p class="xfooter2">  תיצור איתנו קשר  </p> 
					<ul class="list-unstyled list-inline social text-center footerCenter" style="background-color: white; direction: ltr !important;" > 
 						<form method="POST" action="add_like.php">
 						<?php $sp='whatsapp';  myLogo($sp); ?> 
 						<?php $sp='email';  myLogo($sp); ?> 
 						<?php $sp='twitter';  myLogo($sp); ?> 
 						<?php $sp='youtube';  myLogo($sp); ?> 
 						<?php $sp='facebook';  myLogo($sp); ?> 
 						<?php $sp='chatsrun';  myLogo($sp); ?>  
 						<?php 
                         $sp='fyi_likes'; 
                         if (isset($_COOKIE['already_l_hb'])){  ?>  
                         <button disabled="" class="likeButton" > 
 						<li class="list-inline-item"><a target="_blank"  >
 						<i><img src="../logos/<?php echo $sp; ?>.png" class="widthHeight" ></i></a></li>
 						<li class="list-inline-item xnumber"> <?php likes(); ?></li></li>
 						</button> 
 					    <?php }else{ ?>
 						<button  name="likee" class="likeButton" >
 						<li  class="list-inline-item">
 							<a target="_blank"  >
 						      <i><img src="../logos/<?php echo $sp; ?>.png"  class="widthHeight" ></i>
 							</a>
 						<li class="list-inline-item xnumber"> <?php likes(); ?></li>
 					    </li> 
 						</button>
 						<?php } ?>
 						</form>    
					</ul> 
				</div> 
				</hr>
			</div>	 
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
					<p class="h6 xfooter3" dir="rtl">
						כל הזכויות שמורות  
						<a class="text-green ml-2" 
						href="<?php $ch='chatsrun'; getfooteratt($ch); ?>" target="_blank">
						&nbsp;&nbsp; ChatsRun </a> </p>
				</div>
				</hr>
			</div>	

		</div> 
	</section>
	<!-- ./Footer -->
		<!-- End Footer --> 