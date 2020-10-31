      

        <?php echo utilisateursModel::type($news->gettype()); ?>


					<?php if(v5newspublished::nbrVideos()>0){ ?>
						<div class="line"><div>You May Also Like</div></div>
						<div class="row">  
							<?php     
									$query=v5newspublished::videos(2);
                        			foreach($query as $news){   
                        			 		$thumbnail=$news['thumbnail'];
											$mediav='fyipanel/views/image_news/'.$news['media']; 
											$linkv="fyi_detail.php?id=".$news['id'];
											$typesectionv=utilisateursModel::type($news['type']); 
									
							?>     
					<div class="col-md-6 col-sm-6 col-xs-12"  >
						<article class="article-fw videoheighten" > 
								<div class="inner" > 
									<figure style="margin-bottom: 0px;">
										<a target="_blank" href="<?php echo $link; ?>" > 
									      <video preload="none" style="width: 100%; height: 100%" controls  
										<?php if ($thumbnail!=""){ echo 'poster="'.$thumbnail.'"'; } ?> >
										<source src="<?php echo $mediav; ?>"  >
										</video> 
										  </a> 
									</figure>
									<div class="details" style="background-color: white">
										<p>
											<a target="_blank" href="<?php echo $linkv; ?>" 
												class="newFontven" > 
										   <?php echo $news['title']; ?> </a>
									    </p> 
										<div class="detail  "   >
											<a class="xtypeen2">  
									          <?php echo $typesectionv; ?> </a>
										  	<span class="xdate" >
												<?php real_news_time($news['pubDate']); ?>  
										   </span>
										    <?php   if($log){
													if(v5newspublished::already_read($news['id'])){
													echo '<div class="xtypeen2" style="padding-left: 20px;"  ><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: green; " aria-hidden="true"></i></div>';
													}else{
													echo '<div class="xtypeen2" style="padding-left: 20px;"  ><i class="fa fa-circle" style=" padding-left: 15px; font-size: 10px; color: red; " aria-hidden="true"></i></div>';
													}
												}//log
										?>  
										</div>
									</div>
								</div> 
							</article> 
							</div>
							<?php }  ?> 
						</div>  
						<?php }  ?> 




						
					<div class="col-md-4 sidebar" id="sidebar"> 
						<?php  if(v5newspublished::nbrhotnews()>0){  ?>
						<aside>
							<br>
							<h1 class="aside-title">Recent News</h1>
							<div class="aside-body"> 
							<?php   $news=new news_publishedModel();   
									$query=v5newspublished::hotnews(4);
                        			foreach($query as $news){ 
											$media='fyipanel/views/image_news/'.$news['media']; 
											$link="fyi_detail.php?id=".$news['id'];
											$typesection4=utilisateursModel::type($news['type']);  
						    ?>   
							<article class="article-fw" style="padding-bottom: 40px;" >
								<div class="inner">
									<figure>
										<a  href="<?php echo $link; ?>" > 
										  <img width="100%" height="100%"  src="<?php echo $media; ?>" alt="Image">
										  </a> 
									</figure>   
									<div class="details">
										<h1 style="font-size: 15px;">
											<a   href="<?php echo $link; ?>" > 
										   <?php echo $news['title']; ?> </a>
									    </h1>
										<div class="detail" style="padding-top: 10px;" >
										 <div class="xtypeenhot">
										 	  <a >  <?php echo $typesection4; ?> </a>
										</div>
											<div class="time"  >
												<?php real_news_time($news['pubDate']); ?> 
										    </div>
										    <?php   if($log){
													if(v5newspublished::already_read($news['id'])){
													echo '<div class="xtypeenhot" style="padding-left: 20px;"  >
													<i class="fa fa-circle" style=" font-size: 10px; color: green; " aria-hidden="true"></i></div>';
													}else{
													echo '<div class="xtypeenhot" style="padding-left: 20px;">
													<i class="fa fa-circle" style=" font-size: 10px; color: red; " aria-hidden="true"></i></div>';
													}
												}//log
										?> 
										</div>
										 
									</div>  
									</div>
								</div>
							</article> 
						<?php } 	 ?> 
							</div> 
						</aside><?php }	 ?> 
					</div>