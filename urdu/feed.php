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
		$today = date("Y-m-d");    $yesterday = date("Y-m-d", strtotime("-1 day"));
		$con->exec('insert into rss_tmp SELECT  * FROM rss where pubDate like "' . $today . '%" or        pubDate like "' . $tomorrow . '%"  or pubDate like "' . $yesterday . '%"');
	}

	function last_date_rss_all($favorite){
		include("fyipanel/views/connect.php");
		$requete = $con->prepare('SELECT  max(pubDate) FROM rss where favorite="' . $favorite . '"');
		$requete->execute();
		$lastdate = $requete->fetchColumn();
		return $lastdate;
	}

	function getIdOfRssSources($source, $xtype){
		include("fyipanel/views/connect.php");
		$requete = $con->prepare('select id from rss_sources  where source="' . $source . '" and type="' . $xtype . '" ');
		$requete->execute();
		$nbrfeeds = $requete->fetchColumn();
		return $nbrfeeds;
	}

	function getrsstime($d){
		if ($d != "") {
			$d = trim($d);
			$parts = explode(' ', $d);
			$month = $parts[2];
			$monthreal = getmonth($month);
			$time = explode(':', $parts[4]);
			$date = "$parts[3]-$monthreal-$parts[1] $time[0]:$time[1]:$time[2]";
			return $date;
		} else {        return "";    }
	}

	function getmonth($month){
		if ($month == "Jan") $monthreal = 1;    if ($month == "Feb") $monthreal = 2;
		if ($month == "Mar") $monthreal = 3;    if ($month == "Apr") $monthreal = 4;
		if ($month == "May") $monthreal = 5; if ($month == "Jun") $monthreal = 6;
		if ($month == "Jul") $monthreal = 7;    if ($month == "Aug") $monthreal = 8;
		if ($month == "Sep") $monthreal = 9;    if ($month == "Oct") $monthreal = 10;
		if ($month == "Nov") $monthreal = 11;    if ($month == "Dec") $monthreal = 12;
		return $monthreal;
	}/* v5 */
	function todaygmt(){
		date_default_timezone_set('GMT');
		$today = date("Y-m-d H:i:s");
		return $today;
	}

	function addOrNot($d2){
		$dateTimestamp1 = strtotime($d2);
		$dateTimestamp2 = strtotime(todaygmt());
		if ($dateTimestamp1 <= $dateTimestamp2) { return true;  } else { return false; }
	}

	include 'models/utilisateurs.model.php';
	require '../fcm/TopicNotification.php';
	require '../fcm/WebFCMToTopic.php';
	require_once 'fyipanel/models/news_published.model.php';
	function getrssfromsource($xSource, $src, $t, $signe, $hours){
		$domain = 'https://www.fyipress.net/urdu/';
		//echo 'without src : '.$src.' type : '.$t.'<br><br><br>';
		if (utilisateursModel::get_source_status($src, $t) != null
			&& utilisateursModel::get_source_status($src, $t) == 1) {
			if (!$xsourcefile = file_get_contents($xSource)) { } else {
				$favorite = getIdOfRssSources($src, $t);
				if ($src == 'Chitral Times') {
					$xsourcefile = str_replace('This post was written by Saif Ur Rehman This post was written by Saif Ur Rehman', '', $xsourcefile);
					$xsourcefile = str_replace('Check out WPBeginner', '', $xsourcefile);
				}
				$xml = simplexml_load_string($xsourcefile);
				$rss = new rssModel();
				$rss_date = new rssModel();
				include 'fyipanel/views/connect.php';
				$media = "";            $photo = "";
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
					 if ($src == 'Bhatkallys') {
					 $has_post = strpos($description, 'The post') !== false;
					 if ($has_post) {
					      $description = substr($description, 0, strpos($description, "The post"));
					  }
						 $vowels = array("<p>", "</p>");
						 $description = str_replace($vowels, "", $item->description);
					 } else if ($src == 'Aaj Kal' || $src == 'Juraat' || $src == 'Daily Universal') {
						 $has_post = strpos($description, '<a') !== false;
					 if ($has_post) {
					 $description = substr($description, 0, strpos($description, "<a"));
					 }
					 $vowels = array("<p>", "</p>");
					 $description = str_replace($vowels, "", $description);
					 } else if ($src == 'Zama Swat' || $src == 'Daily Taqat' || $src == 'Ummat') {
					 $has_post = strpos($description, '</div>') !== false;
					 if ($has_post) {
					 $description = substr($description, strpos($description, "</div>") + 6);
					 }
					 } else {
					 $has_img = strpos($description, '<img') !== false;
					 $has_para = strpos($description, '</p>') !== false;
					 if ($has_img || $has_para) {
					 $description = '';
					 }
					 }
					 if ($description == '') continue;
					 $link = addslashes($item->link);
					 $has_hashtag = strpos($link, '#') !== false;
					 if ($has_hashtag) { 
					 $link = substr($link, 0, strpos($link, "#"));
					 }
					 if ($d_insert > $d_last) {
						 if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {
							 $con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$media',$favorite, '$photo')");
							 if($t == 'News'){
								 $n = new TopicNotification();
								 $id = $con->lastInsertId();
								 $util = new utilisateursModel();
								 $src_row = $util->get_source_row($src);
							 $country = $src_row['country'];
							 $n->sendTopicNotification($src,$title, 'ur-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'ur');
														  
							if (!news_publishedModel::source_not_open($src)) { 
								$has_http = strpos($link,'http://') !== false;
							if($has_http){
								$link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
							}else{
								$link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
							}  
							}   
							 $fcm = new WebFCMToTopic();
							 $fcm->sendWebNoification('ur-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',                                $link);                            usleep(250000);                        }                    }                }            } // foreach
					}// xsourcefile
				}
			} //func

			function getrsswithmedia($xSource, $src, $t, $word, $signe, $hours){
				$domain = 'https://www.fyipress.net/urdu/';
				//echo 'with src : '.$src.' type : '.$t.'<br><br><br>';
				if (utilisateursModel::get_source_status($src, $t) != null && utilisateursModel::get_source_status($src, $t) == 1) {
					if (!$xsourcefile = file_get_contents($xSource)) { } else {
						$favorite = getIdOfRssSources($src, $t);
						$xml2 = str_replace($word, 'media', $xsourcefile);
						$photo = "";
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
							$d_last = strtotime($d1);
						}
						foreach ($xml->channel->item as $item) { 
							$m = addslashes($item->media["url"]); 
							$title = addslashes($item->title);
							$description = addslashes($item->description);
							$has_img = strpos($description, '<img') !== false;
							$has_para = strpos($description, '</p>') !== false;
							if ($has_img || $has_para) {
								$description = '';
							}
							$link = addslashes($item->link);
							$has_hashtag = strpos($link, '#') !== false;
							if ($has_hashtag) {
								$link = substr($link, 0, strpos($link, "#"));
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
										$n->sendTopicNotification($src,$title, 'ur-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'ur');
														  
							if (!news_publishedModel::source_not_open($src)) { 
								$has_http = strpos($link,'http://') !== false;
							if($has_http){
								$link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
							}else{
								$link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
							}  
							}   
										$fcm = new WebFCMToTopic();
										$fcm->sendWebNoification('ur-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',$link);
										usleep(250000);
									}
								}
							}
						} // foreach
			}// xsourcefile
		}
	} //func 
	try {
		require_once('models/rssModel.php');    fill_rss_tmp();
		 // without media
		  //samaa tv 0h ok
		$xSource = 'https://www.samaa.tv/urdu/feed/';
		$src = 'samaa tv';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		//Daily Adalat 0h ok
		$xSource = 'http://dailyadalat.com/feed';
		$src = 'Daily Adalat';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);  
		//Daily kashmir 0h ok
		$xSource = 'https://dailykashmirlink.com/feed/';
		$src = 'Daily kashmir';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		//v2
		//1 ok
		$xSource = 'http://dailyaag.com/phase2/feed/';
		$src = 'dailyaag';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		//2 aaa the post ok
		$xSource = 'http://www.bhatkallys.com/ur/feed/';
		$src = 'Bhatkallys';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		
		//4  bbb <a   ok
		$xSource = 'http://aajkal.com.pk/feed/';
		$src = 'Aaj Kal';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		//5 ccc ok
		$xSource = 'https://zamaswat.com/feed/';
		$src = 'Zama Swat';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		//6  not open
		$xSource = 'https://www.jasarat.com/feed/';
		$src = 'Jasarat';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		//7 bbb ok
		$xSource = 'http://juraat.com/feed/';
		$src = 'Juraat';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		//8 ok
		$xSource = 'http://dailymussalman.com/?feed=rss2';
		$src = 'Daily Mussalman';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours); 
		//10   ddd ok
		$xSource = 'https://chitraltimes.com/feed/';
		$src = 'Chitral Times';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		 //11 ok
		$xSource = 'https://www.nawaiwaqt.com.pk/rss/international';
		$src = 'Nawaiwaqt';    $t = 'News';    $signe = '-';    $hours = 5;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		 //12  ok
		$xSource = 'http://boltapakistan.com.pk/feed/';
		$src = 'Bolta';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		 //13    //13 ccc ok
		$xSource = 'https://dailytaqat.com/feed/';
		$src = 'Daily Taqat';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		 //14 ccc ok
		$xSource = 'https://ummat.net/feed/';
		$src = 'Ummat';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		 //15 bbb ok
		$xSource = 'http://dailyuniversal.com.pk/feed';
		$src = 'Daily Universal';    $t = 'News';    $signe = '+';    $hours = 0;
		getrssfromsource($xSource, $src, $t, $signe, $hours);
		 //with media
		 //Express News 0h ok
		$xSource = 'https://www.express.pk/world/feed/';
		$src = 'Express News';    $word = 'media:content';    $t = 'News';    $signe = '+';    $hours = 0;
		getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

		$xSource = 'https://www.express.pk/science/feed/';
		$src = 'Express News';    $word = 'media:content';    $t = 'Technology';    $signe = '+';    $hours = 0;
		getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

		$xSource = 'https://www.express.pk/saqafat/feed/';
		$src = 'Express News';    $word = 'media:content'; $t = 'General Culture';    $signe = '+';    $hours = 0;
		getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

		$xSource = 'https://www.express.pk/sports/feed/';
		$src = 'Express News';    $word = 'media:content';    $t = 'Sports';    $signe = '+';    $hours = 0;
		getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

		 //BBC 0h ok
		$xSource = 'http://feeds.bbci.co.uk/urdu/rss.xml';
		$src = 'BBC';    $word = 'media:thumbnail';    $t = 'News';    $signe = '+';    $hours = 0;
		getrsswithmedia($xSource, $src, $t, $word, $signe, $hours); 
		 //VOA -5h ok
		$xSource = 'https://www.urduvoa.com/api/zoot_egkty';
		$src = 'VOA';    $word = 'enclosure';    $t = 'News';    $signe = '-';    $hours = 5;
		getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

		$xSource = 'https://www.urduvoa.com/api/zuytpepqum';
		$src = 'VOA';    $word = 'enclosure';    $t = 'Sports';    $signe = '-';    $hours = 5;
		getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

		$xSource = 'https://www.urduvoa.com/api/zg_tte_rut';
		$src = 'VOA';    $word = 'enclosure';    $t = 'Arts';    $signe = '-';    $hours = 5;
		getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

		$xSource = 'https://www.urduvoa.com/api/zoytmegru_';
		$src = 'VOA';    $word = 'enclosure';    $t = 'Technology';    $signe = '-';    $hours = 5;
		getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

		require_once('ads.php');
	} catch (Exception $e) {

	}
	?>
