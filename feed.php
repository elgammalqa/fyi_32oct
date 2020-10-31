<?php 
/*
ini_set('error_reporting',E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log','LOG_feed.log');
ini_set('max_execution_time', 0);
ini_set('memory_limit','512M');
  */

function NbnewsBytitleInLastDate($date, $title, $fav){    
	include("fyipanel/views/connect.php");   
	$dt = new DateTime($date);    
	$dateonly = $dt->format('Y-m-d');    
	$title = str_replace("'", "\'", $title);    
	$requete = $con->prepare('SELECT  count(*) FROM rss_tmp where  title="' . $title . '" and pubDate like "' . $dateonly . '%" and favorite=' . $fav);    
	$requete->execute();    
	$lastdate = $requete->fetchColumn();   
	return $lastdate;
}  
function fill_rss_tmp(){   
	include("fyipanel/views/connect.php");   
	$con->exec('delete from rss_tmp');   
	date_default_timezone_set('GMT');   
	$tomorrow = date("Y-m-d", strtotime("+1 day"));    
	$today = date("Y-m-d");    
	$yesterday = date("Y-m-d", strtotime("-1 day"));    
	$con->exec('insert into rss_tmp SELECT  * FROM rss where pubDate like "' . $today . '%" or  pubDate like "' . $tomorrow . '%"  or pubDate like "' . $yesterday . '%"');
}
function last_date_rss_all($favorite){    
	include("fyipanel/views/connect.php");  
	$requete = $con->prepare('SELECT  max(pubDate) FROM rss where favorite="' . $favorite . '"');    $requete->execute();   
	$lastdate = $requete->fetchColumn();    
	return $lastdate;
}
function getIdOfRssSources($source, $xtype){
	include("fyipanel/views/connect.php");   
	$requete = $con->prepare('select id from rss_sources  where source="' . $source . '" and type="' . $xtype . '" ');   
	$requete->execute();    
	$nbrfeeds = $requete->fetchColumn();    
	return $nbrfeeds;}function getrsstime($d){    
		if ($d != "") {        
			$d = trim($d);        
			$parts = explode(' ', $d);        
			$month = $parts[2];        
			$monthreal = getmonth($month);        
			$time = explode(':', $parts[4]);        
			$date = "$parts[3]-$monthreal-$parts[1] $time[0]:$time[1]:$time[2]";        
			return $date;    
		} else {
		        return "";    
		}
	}
		function getmonth($month){    
			if ($month == "Jan") $monthreal = 1;    if ($month == "Feb") $monthreal = 2;    if ($month == "Mar") $monthreal = 3;    if ($month == "Apr") $monthreal = 4;    if ($month == "May") $monthreal = 5;    if ($month == "Jun") $monthreal = 6;    if ($month == "Jul" || $month == "July") $monthreal = 7;    if ($month == "Aug") $monthreal = 8;    if ($month == "Sep" || $month == "Sept") $monthreal = 9;    if ($month == "Oct") $monthreal = 10;    if ($month == "Nov") $monthreal = 11;    if ($month == "Dec") $monthreal = 12;    return $monthreal;
		}
		/* v5 */
		function todaygmt(){    
			date_default_timezone_set('GMT');    
			$today = date("Y-m-d H:i:s");    
			return $today;
		    
		}
			function addOrNot($d1){    
				$dateTimestamp1 = strtotime($d1);    
				$dateTimestamp2 = strtotime(todaygmt());    
				if ($dateTimestamp1 <= $dateTimestamp2) {        
					return true;    
				} else {        return false;    }
			}
			include 'models/utilisateurs.model.php';
			require 'fcm/TopicNotification.php';
			require 'fcm/WebFCMToTopic.php';
			require_once 'fyipanel/models/news_published.model.php';
			function getrssfromsource($xSource, $src, $t, $signe, $hours){    
				$domain = 'https://www.fyipress.net/';       
			 if (utilisateursModel::get_source_status($src, $t) != null && 
			 	utilisateursModel::get_source_status($src, $t) == 1) {        
			 	if (!$xsourcefile = file_get_contents($xSource)) {        
			 	} else {
				 //source ok            
				 $favorite = getIdOfRssSources($src, $t);            
				 $xml = simplexml_load_string($xsourcefile);            
				 $rss = new rssModel();            
				 $rss_date = new rssModel();            
				 include 'fyipanel/views/connect.php';            
				 $media = "";            
				 $photo = "";            
				 $d1 = last_date_rss_all($favorite);            
				 if ($hours != 0) {                
				 	if ($signe == "+") $sig = "-"; else $sig = "+";                
				 	$d_last = date("Y-m-d H:i:s", strtotime("$sig{$hours} hours", strtotime($d1)));                
					$d_last = strtotime($d_last);           
				 } else {                
					 $d_last = strtotime($d1);            
				}           
					 foreach ($xml->channel->item as $item) {                
						 $date = getrsstime($item->pubDate);               
						  $d2 = date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date)));                
						  $d_insert = strtotime($date);                
						  $title = addslashes($item->title);                
						  $description = addslashes($item->description);                
						  $has_http = strpos($description, 'http:') !== false;                
						  if ($has_http) {                    
						  $description = substr($description, 0, strpos($description, "http:"));                
						  }                
						  $has_Paragraph_img = strpos($description, '<img') !== false;                
						  $has_Paragraph = strpos($description, '</p>') !== false;                
						  if ($has_Paragraph || $has_Paragraph_img) $description = '';                
						  $has_hashtag = strpos($item->link, '#') !== false;                
						  if ($has_hashtag) {                    
						  $whatIWant = substr($item->link, 0, strpos($item->link, "#"));                    
						  $link = addslashes($whatIWant);                
						  } else {                    
						  $link = addslashes($item->link);                
						  }                
						  if ($d_insert > $d_last) {                    
						  if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {
						  $con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$media', $favorite,'$photo'  )");                        
						  if($t == 'News'){                            
						  $n = new TopicNotification();                            
						  $id = $con->lastInsertId();                            
						  $util = new utilisateursModel();                            
						  $src_row = $util->get_source_row($src);                            
						  $country = $src_row['country']; 
						                         
						  $n->sendTopicNotification($src,$title, 'en-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'en');
														  
							if (!news_publishedModel::source_not_open($src)) { 
								$has_http = strpos($link,'http://') !== false;
							if($has_http){
								$link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
							}else{
								$link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
							}  
							}   

						  $fcm = new WebFCMToTopic();                            
						  $fcm->sendWebNoification('en-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress', $link);                            
						  usleep(250000);                        
						  }                    
						  }                
						  }            
						  } // foreach       
						   }// xsourcefile    
						   } //status
						   } // func
						   
						   
						   function getrsswithmedia($xSource, $src, $t, $word, $signe, $hours){    
						   $domain = 'https://www.fyipress.net/';     
						    if (utilisateursModel::get_source_status($src, $t) != null && 
						    	utilisateursModel::get_source_status($src, $t) == 1) {        
						    	if (!$xsourcefile = file_get_contents($xSource)) {        } else {            
						    		$favorite = getIdOfRssSources($src, $t);            
						    		$xml2 = str_replace($word, 'media', $xsourcefile);            
						    		if ($src == 'abc7') {                
						    			$xml2 = str_replace('media:thumbnail', 'photo', $xml2);            
						    		} else {                
						    			$photo = "";            
						    		}            
						    		$xml = simplexml_load_string($xml2);            
						    		$rss = new rssModel();            
						    		$rss_date = new rssModel();            
						    		include 'fyipanel/views/connect.php';            
						    		$d1 = last_date_rss_all($favorite);            
						    		if ($hours != 0) {                
						    			if ($signe == "+") $sig = "-"; else $sig = "+";                
						    			$d_last = date("Y-m-d H:i:s", strtotime("$sig{$hours} hours", strtotime($d1)));
										$d_last = strtotime($d_last);            
									} else {                
										$d_last = strtotime($d1);            }            
										foreach ($xml->channel->item as $item) {                
											if ($src == 'abc7') $photo = addslashes($item->photo["url"]);                
											$m = addslashes($item->media["url"]);                
											$has_questionMark = strpos($m, '?') !== false;                
											if ($has_questionMark) {                    
												$m = substr($m, 0, strpos($m, "?"));                
											}                
											$m = str_replace("http://", "https://", $m);                
											$title = addslashes($item->title);                
											$description = addslashes($item->description);                
											$has_Paragraph_img = strpos($description, '<img') !== false;                
											$has_Paragraph = strpos($description, '</p>') !== false;                
											if ($has_Paragraph || $has_Paragraph_img) $description = '';                
											$has_hashtag = strpos($item->link, '#') !== false;                
											if ($has_hashtag) {                    
												$whatIWant = substr($item->link, 0, strpos($item->link, "#"));                    
												$link = addslashes($whatIWant);                
											} else {                    
												$link = addslashes($item->link);               
											}                
												$date = getrsstime($item->pubDate);                
												$d2 = date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date)));       
												$d_insert = strtotime($date);                
												if ($d_insert > $d_last) {                    
													if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {                         
														$con->exec("INSERT INTO `rss` VALUES (NULL, '$title' , '$description','$link', '$d2', '$m',$favorite, '$photo')");                        
														if($t == 'News'){                            
															$n = new TopicNotification();                            
															$id = $con->lastInsertId();                            
															$util = new utilisateursModel();                            
															$src_row = $util->get_source_row($src);                            
															$country = $src_row['country'];                            
															 
															$n->sendTopicNotification($src,$title, 'en-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'en');
														  
														if (!news_publishedModel::source_not_open($src)) { 
															$has_http = strpos($link,'http://') !== false;
														if($has_http){
															$link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
														}else{
															$link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
														}  
														}
 

						    $fcm = new WebFCMToTopic();                           
						     $fcm->sendWebNoification('en-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',$link);
						     usleep(250000);                        
						    }                    
						    }                
						    }            
						    } // foreach        
						    }// xsourcefile    
						    } //status
						    } //func 
						    
						    
						    
						    try {    
						    require_once('models/rssModel.php');    
						    fill_rss_tmp();      
						    //tass -3h    
						    $xSource = 'http://tass.com/rss/v2.xml';    
						    $src = 'tass';    $t = 'News';    $signe = '-';    $hours = 3;    
						    getrssfromsource($xSource, $src, $t, $signe, $hours);    
						    //bbc gmt    
						    $xSource = 'http://feeds.bbci.co.uk/news/world/rss.xml';    
						    $src = 'bbc';    $t = 'News';    $signe = '+';    $hours = 0;    
						    getrssfromsource($xSource, $src, $t, $signe, $hours);    
						    /* v2 */    
						    //1   
						    $xSource = 'https://www.dailymail.co.uk/news/index.rss';    
						    $src = 'daily mail';    $t = 'News';    $signe = '+';    $hours = 0;    
						    getrssfromsource($xSource, $src, $t, $signe, $hours);    
						    //2    
						    $xSource = 'https://www.dailymail.co.uk/sport/index.rss';    
						    $src = 'daily mail';    $t = 'Sports';    $signe = '+';    $hours = 0;    
						    getrssfromsource($xSource, $src, $t, $signe, $hours);    
						    //3    
						    $xSource = 'https://www.pressandjournal.co.uk/feed/';    
						    $src = 'press and journal';    $t = 'News';    $signe = '+';    $hours = 0;    
						    getrssfromsource($xSource, $src, $t, $signe, $hours);    
						    //4    
						    $xSource = 'https://www.eveningexpress.co.uk/feed/';    
						    $src = 'evening express';    $t = 'News';    $signe = '+';    $hours = 0;    
						    getrssfromsource($xSource, $src, $t, $signe, $hours);    
						    //with media    //independent gmt    
						    $xSource = 'http://www.independent.co.uk/sport/football/rss';    
						     $src = 'independent';    $word = 'media:thumbnail';    $t = 'Sports'; $signe = '+'; $hours = 0;    
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);  
						     //abc7 gmt    
						     $xSource = 'https://abc7.com/feed/';    
						     $src = 'abc7';    $word = 'enclosure';    $t = 'News';    $signe = '+';    $hours = 0;    
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						     //techradar gmt    
						     $xSource = 'https://www.techradar.com/rss/news/world-of-tech';    
						     $src = 'techradar';    $word = 'enclosure';    $t = 'Technology';    $signe = '+';    $hours = 0; 
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						     //independent gmt
						     $xSource = 'http://www.independent.co.uk/arts-entertainment/theatre-dance/rss';    
						     $src = 'independent';    $word = 'media:thumbnail';    $t = 'Arts';    $signe = '+';    $hours = 0; 
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						     //wired gmt    
						     $xSource = 'https://www.wired.com/feed/category/culture/latest/rss';    
						     $src = 'wired';    $word = 'media:thumbnail';    $t = 'General Culture';    $signe = '+';    $hours = 0;
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						     /* v2 */    
						     //1 slate +0 Arts
						     $xSource = 'https://slate.com/feeds/culture.rss';    
						     $src = 'slate';    $word = 'media:content';    $t = 'Arts';    $signe = '+';    $hours = 0;   
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						     //2 slate +0 Technology    
						     $xSource = 'https://slate.com/feeds/technology.rss';    
						     $src = 'slate';    $word = 'media:content';    $t = 'Technology';    $signe = '+';    $hours = 0;   
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						     //3 slate +0 News 
						     $xSource = 'https://slate.com/feeds/news-and-politics.rss';    
						     $src = 'slate';    $word = 'media:content';    $t = 'News';    $signe = '+';    $hours = 0;    
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);   
						      //4 slate +0 General    
						    $xSource = 'https://slate.com/feeds/human-interest.rss';    
						    $src = 'slate';    $word = 'media:content';    $t = 'General Culture';    $signe = '+';    $hours = 0;    
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						    //5    
						    $xSource = 'http://www.independent.co.uk/news/rss';    
						    $src = 'independent';    $word = 'media:thumbnai';    $t = 'News';    $signe = '+';    $hours = 0;    
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						    //6
						     $xSource = 'https://www.standard.co.uk/rss';    
						     $src = 'standard';    $word = 'media:content';    $t = 'News';    $signe = '+';    $hours = 0;    
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						     //7    
						     $xSource = 'https://www.thestar.co.uk/sport/rss';    
						     $src = 'the star';    $word = 'media:content';    $t = 'Sports';    $signe = '-';    $hours = 1;    
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						     //8
						     $xSource = 'https://www.thestar.co.uk/news/rss';    
						     $src = 'the star';    $word = 'media:content';    $t = 'News';    $signe = '-';    $hours = 1;    
						     getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						     //9    
						     $xSource = 'https://www.thestar.co.uk/lifestyle/rss';    
						     $src = 'the star';    $word = 'media:content';    $t = 'General Culture';    $signe = '-';    $hours = 1;
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						    //10
						    $xSource = 'https://www.walesonline.co.uk/news/?service=rss';    
						    $src = 'wales online';    $word = 'enclosure';    $t = 'News';    $signe = '+';    $hours = 0;    
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						    //11
						    $xSource = 'https://www.walesonline.co.uk/sport/?service=rss';    
						    $src = 'wales online';    $word = 'enclosure';    $t = 'Sports';    $signe = '+';    $hours = 0;    
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						        //12
						    $xSource = 'https://www.walesonline.co.uk/lifestyle/?service=rss';    
						    $src = 'wales online';    $word = 'enclosure';    $t = 'General Culture';    $signe = '+';    $hours = 0;
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						       //13
						    $xSource = 'https://www.dailypost.co.uk/news/?service=rss';    
						    $src = 'daily post';    $word = 'enclosure';    $t = 'News';    $signe = '+';    $hours = 0;    
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
					       //14
						    $xSource = 'https://www.dailypost.co.uk/sport/?service=rss';    
						    $src = 'daily post';    $word = 'enclosure';    $t = 'Sports';    $signe = '+';    $hours = 0;    
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						    //15 
						    $xSource = 'https://www.dailypost.co.uk/whats-on/?service=rss';    
						    $src = 'daily post';    $word = 'enclosure';    $t = 'General Culture';    $signe = '+';    $hours = 0;
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    
						    //16 
						    $xSource = 'https://www.infoworld.com/category/internet/index.rss';    
						    $src = 'info world';    $word = 'media:thumbnail';    $t = 'Technology';    $signe = '+';    $hours = 7;
						    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);    require_once('ads.php');
						                   
						                   } catch (Exception $e) {} 
				 ?> 