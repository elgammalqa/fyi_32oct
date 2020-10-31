<?php   
							include("fyipanel/views/connect.php"); 
							date_default_timezone_set('GMT'); 
							$today = date("Y-m-d");
 							if(isset($_POST['add_hot_ad'])){
							$query = $con->prepare("SELECT count(*) FROM hot_ads_views_clicks where id='".$id_ad."' and date_ad='".$today."' ");
        						$query->execute();
        						$nb = $query->fetchColumn(); 
          						if ($nb>0){   
									$con->exec('UPDATE hot_ads_views_clicks set nb_views=nb_views+1,nb_clicks=nb_clicks+1 where id='.$id_ad.' and date_ad="'.$today.'" ');
								}else{
								    $con->exec('INSERT INTO hot_ads_views_clicks  VALUES ('.$id_ad.',"'.$today.'",1,1)');
								} 
								if($link_ad!=null){
									echo "<script> window.open('".$link_ad."', '_blank'); </script>";
								} 

 							}  
 							if($there_is_ad){
 								$query = $con->prepare("SELECT count(*) FROM hot_ads_views_clicks where id='".$id_ad."' and date_ad='".$today."' ");
        						$query->execute();
        						$nb = $query->fetchColumn(); 
          						if ($nb>0){  
									$con->exec('UPDATE hot_ads_views_clicks set nb_views=nb_views+1 where id='.$id_ad.' and date_ad="'.$today.'" ');
								}else{
								    $con->exec('INSERT INTO hot_ads_views_clicks  VALUES ('.$id_ad.',"'.$today.'",1,1)');
								}   
 							}
 						 ?>   