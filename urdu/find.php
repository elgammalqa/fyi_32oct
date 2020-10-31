<?php  
	include 'fyipanel/views/connect.php';
	include 'fyipanel/models/news_published.model.php';  
	include 'models/utilisateurs.model.php';   
	$output = '';  
	if (isset($_POST['searchVal'])) {
		$searchq = $_POST['searchVal'];
		//$searchq = preg_replace("#[^0-9a-z]#i", "", $searchq); 
		 $requete = $con->prepare("select count(*) from (select id 
                from rss where title LIKE '%$searchq%' OR description LIKE '%$searchq%' OR pubDate LIKE '%$searchq%' group by title 
                UNION select id FROM news_published where title LIKE '%$searchq%' OR description LIKE '%$searchq%' OR pubDate LIKE '%$searchq%' )x");
              $requete->execute();
              $count = $requete->fetchColumn();  
              $new=new news_publishedModel();
              $query=$new->find_search($searchq);
		if ($count == 0) {
			$output = 'تلاش کے اختیارات سے نمٹنے کے کوئی نتائج نہیں ہیں';
		}else if($searchq==""){
			$output = ''; 
	    }else{ 

	    	 foreach($query as $row){ 
	    	 	if($row['rank']==1){ 
						 $linkv="detail.php?id=".$row['id'];
					     $source="FYI PRESS";   
				                }else{ 
					     $linkv="iframe.php?link=".stripslashes($row['link']);
						 $source=$row['Source']; 
			    } 
				$title = $row['title'];
				$description = $row['description'];
				$pubDate = $row['pubDate'];
				$type = $row['type']; 
				$id = $row['id'];  
				 $output .= '<div class="row">
							 <article class="col-md-11" style="padding-bottom:20px;" >
								   <div class="details">
										 <h6>
										 	<a href="'.$linkv.'" target="_blank" style="color: #000; font-weight: bold; font-size: 18px; " >'.$title.'
										     </a>
										 </h6>
										 <p style="font-size: 17px; " >'.$description.'</p>
										<div class="detail float_right">  
										  <span  style="color:#F73F52; padding-right:10px; font-size: 17px; " >
										  غرينيتش 
										  </span>
										     <div class="time padding-top:10px; " style="color:#F73F52; font-size: 17px;"> '.$pubDate.'   </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										       <div class="time  " style="color:#F73F52; font-size: 17px;">'.utilisateursModel::type($type).'</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class="time " style="color:#F73F52; font-size: 17px;" >'.utilisateursModel::source($source).'</div>
									    </div> 
						            </div>
							    </article>
                        </div>';
			} 
		}
	}
	echo ($output);
?>
