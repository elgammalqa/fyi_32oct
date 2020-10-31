<?php
/*
ini_set('error_reporting',E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log','LOG_feed.log');
ini_set('max_execution_time', 0);
ini_set('memory_limit','512M');
*/

function NbnewsBytitleInLastDate($date, $title, $fav)
{
    include("fyipanel/views/connect.php");
    $dt = new DateTime($date);
    $dateonly = $dt->format('Y-m-d');
    $title = str_replace("'", "\'", $title);
    $requete = $con->prepare('SELECT  count(*) FROM rss_tmp where  title="' . $title . '" and pubDate like "' . $dateonly . '%" and favorite=' . $fav);
    $requete->execute();
    $lastdate = $requete->fetchColumn();
    return $lastdate; 
}

function fill_rss_tmp()
{
    include("fyipanel/views/connect.php");
    $con->exec('delete from rss_tmp');
    date_default_timezone_set('GMT');
    $tomorrow = date("Y-m-d", strtotime("+1 day"));
    $today = date("Y-m-d");
    $yesterday = date("Y-m-d", strtotime("-1 day"));
    $con->exec('insert into rss_tmp SELECT  * FROM rss where pubDate like "' . $today . '%" or
        pubDate like "' . $tomorrow . '%"  or pubDate like "' . $yesterday . '%"');
}

function last_date_rss_all($favorite)
{
    include("fyipanel/views/connect.php");
    $requete = $con->prepare('SELECT  max(pubDate) FROM rss where favorite="' . $favorite . '"');
    $requete->execute();
    $lastdate = $requete->fetchColumn();
    return $lastdate;
}

function getIdOfRssSources($source, $xtype)
{
    include("fyipanel/views/connect.php");
    $requete = $con->prepare('select id from rss_sources  where source="' . $source . '" and type="' . $xtype . '" ');
    $requete->execute();
    $nbrfeeds = $requete->fetchColumn();
    return $nbrfeeds;
}

function getrsstime($d)
{
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

function getmonth($month)
{
    if ($month == "Jan") $monthreal = 1;
    if ($month == "Feb") $monthreal = 2;
    if ($month == "Mar") $monthreal = 3;
    if ($month == "Apr") $monthreal = 4;
    if ($month == "May") $monthreal = 5;
    if ($month == "Jun") $monthreal = 6;
    if ($month == "Jul") $monthreal = 7;
    if ($month == "Aug") $monthreal = 8;
    if ($month == "Sep") $monthreal = 9;
    if ($month == "Oct") $monthreal = 10;
    if ($month == "Nov") $monthreal = 11;
    if ($month == "Dec") $monthreal = 12;
    return $monthreal;
}

include 'models/utilisateurs.model.php';

require '../fcm/TopicNotification.php';

require '../fcm/WebFCMToTopic.php';
require_once 'fyipanel/models/news_published.model.php';


function getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes)
{
    $domain = 'https://www.fyipress.net/indian/';
    //echo 'without src :: '.$src.' -- type :: '.$t.'<br>';   
    if (utilisateursModel::get_source_status($src, $t) != null && utilisateursModel::get_source_status($src, $t) == 1) {
        if (!$xsourcefile = file_get_contents($xSource)) {
        } else {
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
                $d_last = date("Y-m-d H:i:s", strtotime("$sig{$hours} hours $sig{$mintes} minutes", strtotime($d1)));
                $d_last = strtotime($d_last);
            } else {
                $d_last = strtotime($d1);
            }
            foreach ($xml->channel->item as $item) {
                $date = getrsstime($item->pubDate);
                $d2 = date("Y-m-d H:i:s", strtotime("$signe{$hours} hours $signe{$mintes} minutes", strtotime($date)));
                $d_insert = strtotime($date);
                $title = addslashes($item->title);
                $description = addslashes($item->description);
                $has_Paragraph_img = strpos($description, '<img') !== false;
                $has_Paragraph = strpos($description, '</p>') !== false;
                if ($has_Paragraph_img || $has_Paragraph) $description = '';

                $has_hashtag = strpos($item->link, '#') !== false;
                if ($has_hashtag) {
                    $whatIWant = substr($item->link, 0, strpos($item->link, "#"));
                    $link = addslashes($whatIWant);
                } else {
                    $link = addslashes($item->link);
                }
                if ($d_insert > $d_last) {

                    if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0) {
                        $con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$media', $favorite, '$photo')");

                        if($t == 'News'){
                            $n = new TopicNotification();
                            $id = $con->lastInsertId();
                            $util = new utilisateursModel();
                            $src_row = $util->get_source_row($src);
                            $country = $src_row['country'];
                            
                            $n->sendTopicNotification($src,$title, 'in-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'in');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   
                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('in-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
                                $link);

                            usleep(250000);
                        }
                    }
                }
            } // foreach
        }// xsourcefile

    } //status

} //func 


function getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes)
{
    $domain = 'https://www.fyipress.net/indian/';
    //echo 'with src :: '.$src.' -- type :: '.$t.'<br>';    
    if (utilisateursModel::get_source_status($src, $t) != null && utilisateursModel::get_source_status($src, $t) == 1) {
        if (!$xsourcefile = file_get_contents($xSource)) {
        } else {
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
                $d_last = date("Y-m-d H:i:s", strtotime("$sig{$hours} hours $sig{$mintes} minutes", strtotime($d1)));
                $d_last = strtotime($d_last);
            } else {
                $d_last = strtotime($d1);
            }
            foreach ($xml->channel->item as $item) {
                $title = addslashes($item->title);
                $has_hashtag = strpos($item->link, '#') !== false;
                if ($has_hashtag) {
                    $whatIWant = substr($item->link, 0, strpos($item->link, "#"));
                    $link = addslashes($whatIWant);
                } else {
                    $link = addslashes($item->link);
                }
                $lin_has_questionMark = strpos($link, '?') !== false;
                if ($lin_has_questionMark) {
                    $link = substr($link, 0, strpos($link, "?"));
                }
                $lin_has_http = strpos($link, 'http://') !== false;
                $lin_has_https = strpos($link, 'https://') !== false;
                if (!$lin_has_http && !$lin_has_https) {
                    $link = str_replace('http:/', 'http://', $link);
                    $link = str_replace('https:/', 'https://', $link);
                }

                $description = addslashes($item->description);
                $has_Paragraph_img = strpos($description, '<img') !== false;
                $has_Paragraph = strpos($description, '</p>') !== false;
                if ($has_Paragraph_img || $has_Paragraph) $description = '';
                if ($src == "डेली न्यूज") {
                    $date = $item->pubDate;
                    $d2 = date("Y-m-d H:i:s", strtotime("$signe{$hours} hours $signe{$mintes} minutes", strtotime($date)));
                    $m = addslashes($item->image);
                } else {
                    $date = getrsstime($item->pubDate);
                    $d2 = date("Y-m-d H:i:s", strtotime("$signe{$hours} hours $signe{$mintes} minutes", strtotime($date)));
                    $m = addslashes($item->media["url"]);
                }
                $has_questionMark = strpos($m, '?') !== false;
                if ($has_questionMark) {
                    $m = substr($m, 0, strpos($m, "?"));
                }
                $m = str_replace("http://", "https://", $m);
                $d_insert = strtotime($date);
                if ($d_insert > $d_last) {
                    if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0) {
                        $con->exec("INSERT INTO `rss` VALUES (NULL, '$title' , '$description','$link', '$d2', '$m', $favorite, '$photo')");
                        if($t == 'News'){
                            $n = new TopicNotification();
                            $id = $con->lastInsertId();
                            $util = new utilisateursModel();
                            $src_row = $util->get_source_row($src);
                            $country = $src_row['country'];
                             
                            $n->sendTopicNotification($src,$title, 'in-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'in');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }    
                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('in-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
                                $link);

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
    // without media
    //NDTV Khabar
    $xSource = 'http://feeds.feedburner.com/ndtvkhabar-world';
    $src = 'NDTV Khabar';
    $t = 'News';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    $xSource = 'http://feeds.feedburner.com/ndtvkhabar-sports';
    $src = 'NDTV Khabar';
    $t = 'Sports';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    //Navbharat Times gmt
    $xSource = 'https://navbharattimes.indiatimes.com/world/rssfeedsection/2279801.cms';
    $src = 'Navbharat Times';
    $t = 'News';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    $xSource = 'https://navbharattimes.indiatimes.com/sports/rssfeedsection/2279790.cms';
    $src = 'Navbharat Times';
    $t = 'Sports';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    //अमर उजाला
    $xSource = 'https://www.amarujala.com/rss/india-news.xml';
    $src = 'अमर उजाला';
    $t = 'News';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    $xSource = 'https://www.amarujala.com/rss/technology.xml';
    $src = 'अमर उजाला';
    $t = 'Technology';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    $xSource = 'https://www.amarujala.com/rss/sports.xml';
    $src = 'अमर उजाला';
    $t = 'Sports';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    //देशबंधु
    $xSource = 'http://www.deshbandhu.co.in/rss/politics';
    $src = 'देशबंधु';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    $mintes = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    $xSource = 'http://www.deshbandhu.co.in/rss/sports';
    $src = 'देशबंधु';
    $t = 'Sports';
    $signe = '+';
    $hours = 0;
    $mintes = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    //वेबदुनिया
    $xSource = 'http://hindi.webdunia.com/rss/mobile-updates-10104.rss';
    $src = 'वेबदुनिया';
    $t = 'Technology';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);


    //v2
    //1
    $xSource = 'https://www.amarujala.com/rss/lifestyle.xml';
    $src = 'अमर उजाला';
    $t = 'General Culture';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    //2
    $xSource = 'https://navbharattimes.indiatimes.com/tech/gadgets-news/rssfeedsection/66130905.cms';
    $src = 'Navbharat Times';
    $t = 'Technology';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    //3
    $xSource = 'http://navbharattimes.indiatimes.com/travel/rssfeedsection/2355172.cms';
    $src = 'Navbharat Times';
    $t = 'General Culture';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    //4
    $xSource = 'https://zeenews.india.com/hindi/world.xml';
    $src = 'Zee News';
    $t = 'News';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    //5
    $xSource = 'https://zeenews.india.com/hindi/sports.xml';
    $src = 'Zee News';
    $t = 'Sports';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    
    //8
    $xSource = 'https://tarunmitra.in/feed';
    $src = 'तरुण मित्र';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    $mintes = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);
    //9
    $xSource = 'https://www.bhadas4media.com/feed/';
    $src = 'Bhadas4Media';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    $mintes = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours, $mintes);


    //with media
    //Oneindia -530
    $xSource = 'https://hindi.oneindia.com/rss/hindi-news-fb.xml';
    $src = 'Oneindia';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);
    $xSource = 'https://hindi.oneindia.com/rss/hindi-art-culture-fb.xml';
    $src = 'Oneindia';
    $word = 'enclosure';
    $t = 'General Culture';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);
    //डेली न्यूज -gmt
    $xSource = 'http://rss.dailynews360.com/rss/rss.php?q=category&v=news';
    $src = 'डेली न्यूज';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);
    $xSource = 'http://rss.dailynews360.com/rss/rss.php?q=category&v=sports';
    $src = 'डेली न्यूज';
    $word = 'enclosure';
    $t = 'Sports';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);
    //Filmibeat -530
    $xSource = 'https://hindi.filmibeat.com/rss/filmibeat-hindi-television-fb.xml';
    $src = 'Filmibeat';
    $word = 'enclosure';
    $t = 'Arts';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);
    //Gizbot Hindi -530
    $xSource = 'https://hindi.gizbot.com/rss/apps-fb.xml';
    $src = 'Gizbot Hindi';
    $word = 'enclosure';
    $t = 'Technology';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);
    $xSource = 'https://hindi.boldsky.com/rss/hindi-boldsky-beauty-fb.xml';
    $src = 'Gizbot Hindi';
    $word = 'enclosure';
    $t = 'General Culture';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);

    //प्रभासाक्षी
    $xSource = 'https://www.prabhasakshi.com/rss/international';
    $src = 'प्रभासाक्षी';
    $word = 'media:thumbnail';
    $t = 'News';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);
    $xSource = 'https://www.prabhasakshi.com/rss/technologyarticles';
    $src = 'प्रभासाक्षी';
    $word = 'media:thumbnail';
    $t = 'Technology';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);
    $xSource = 'https://www.prabhasakshi.com/rss/sports';
    $src = 'प्रभासाक्षी';
    $word = 'media:thumbnail';
    $t = 'Sports';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);
    //v2
    //1
    $xSource = 'https://www.prabhasakshi.com/rss/lifestyle';
    $src = 'प्रभासाक्षी';
    $word = 'media:thumbnail';
    $t = 'General Culture';
    $signe = '-';
    $hours = 5;
    $mintes = 30;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours, $mintes);


    require_once('ads.php');
} catch (Exception $e) {
} ?>