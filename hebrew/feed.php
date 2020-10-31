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

function getrssfromsource($xSource, $src, $t, $signe, $hours)
{
    $domain = 'https://www.fyipress.net/hebrew/';
    //echo 'without src :: ' . $src . ' -- type :: ' . $t . '<br>';
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
                if ($src == 'calcalist' || $src == 'ynet' || $src == 'TGspot') {
                    $has_div = strpos($description, '</div>') !== false;
                    if ($has_div) {
                        $description = substr($description, strpos($description, "</div>") + 6);
                    }
                } else if ($src == '93fm' || $src == 'HWzone' || $src == 'srugim') {
                    $has_post = strpos($description, '</p>') !== false;
                    if ($has_post) {
                        $description = substr($description, 0, strpos($description, "</p>"));
                    }
                    $vowels = array("<p>", "</p>");
                    $description = str_replace($vowels, "", $description);
                } else if ($src == 'news-israel') {
                    $has_post = strpos($description, '<a') !== false;
                    if ($has_post) {
                        $description = substr($description, 0, strpos($description, "<a"));
                    }
                    $vowels = array("<p>", "</p>");
                    $description = str_replace($vowels, "", $description);
                } else if ($src == 'debka') {
                    $has_post = strpos($description, 'The post') !== false;
                    if ($has_post) {
                        $description = substr($description, 0, strpos($description, "The post"));
                    }
                    $vowels = array("<p>", "</p>");
                    $description = str_replace($vowels, "", $description);
                }


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
                            
                            $n->sendTopicNotification($src,$title, 'he-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'he');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   

                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('he-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
                                $link);

                            usleep(250000);
                        }
                    }
                }
            } // foreach
        }// xsourcefile

    } //status

} //func  


function getrsswithmedia($xSource, $src, $t, $word, $signe, $hours)
{
    $domain = 'https://www.fyipress.net/hebrew/';
    //echo 'with src :: ' . $src . ' -- type :: ' . $t . '<br>';
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
                $d_last = date("Y-m-d H:i:s", strtotime("$sig{$hours} hours", strtotime($d1))); 
                $twoDaysAfter = strtotime($d_last."+ 2 days"); 
                $d_last = strtotime($d_last);  
            } else {
                $d_last = strtotime($d1);
            }
            foreach ($xml->channel->item as $item) {
                $title = addslashes($item->title);
                $description = addslashes($item->description);
                if ($src == "mako") {
                    $m = addslashes($item->media);
                    $has_para = strpos($description, '<p>') !== false;
                    if ($has_para) {
                        $description = substr($description, 0, strpos($description, "<p>"));
                    }
                } else if ($src == 'Israel Hayom') {
                    $has_div = strpos($description, '</div>') !== false;
                    if ($has_div) {
                        $description = '';
                    }
                    $m = addslashes($item->image);
                } else {
                    $m = addslashes($item->media["url"]);
                }
                $has_questionMark = strpos($m, '?') !== false;
                if ($has_questionMark) {
                    $m = substr($m, 0, strpos($m, "?"));
                }

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
                if ($d_insert > $d_last && $d_insert < $twoDaysAfter) { 
                    if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0) {
                        $con->exec("INSERT INTO `rss` VALUES (NULL, '$title' , '$description','$link', '$d2', '$m', $favorite, '$photo')");
                        if($t == 'News'){
                            $n = new TopicNotification();
                            $id = $con->lastInsertId();
                            $util = new utilisateursModel();
                            $src_row = $util->get_source_row($src);
                            $country = $src_row['country'];
                            
                            $n->sendTopicNotification($src,$title, 'he-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'he');
                             
                        
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }    
                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('he-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
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

 
    //haaretz 0  zzz
    $xSource = 'https://www.haaretz.co.il/cmlink/1.1410478';
    $src = 'haaretz';
    $t = 'News';
    $signe = '-';
    $hours = 3;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    $xSource = 'https://www.haaretz.co.il/cmlink/1.1410698';
    $src = 'haaretz';
    $t = 'Sports';
    $signe = '-';
    $hours = 3;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    $xSource = 'https://www.haaretz.co.il/cmlink/1.1617760';
    $src = 'haaretz';
    $t = 'General Culture';
    $signe = '-';
    $hours = 3;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //themarker  zzz
    $xSource = 'http://www.themarker.com/cmlink/1.605659';
    $src = 'themarker';
    $t = 'Technology';
    $signe = '-';
    $hours = 3;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //globes zzz
    $xSource = 'https://www.globes.co.il/webservice/rss/rssfeeder.asmx/FeederNode?iID=9758';
    $src = 'globes';
    $t = 'News';
    $signe = '-';
    $hours = 3;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //6  zzz
    $xSource = 'http://www.epochtimes.co.il/et/feed';
    $src = 'epochtimes';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);


    //v2
    //calcalist zzz
    $xSource = 'https://www.calcalist.co.il/GeneralRSS/0,16335,L-3778,00.xml';
    $src = 'calcalist';
    $t = 'Technology';
    $signe = '-';
    $hours = 3;
    getrssfromsource($xSource, $src, $t, $signe, $hours);

    $xSource = 'https://www.calcalist.co.il/GeneralRSS/0,16335,L-13,00.xml';
    $src = 'calcalist';
    $t = 'News';
    $signe = '-';
    $hours = 3;
    getrssfromsource($xSource, $src, $t, $signe, $hours);

    $xSource = 'https://www.calcalist.co.il/GeneralRSS/0,16335,L-18,00.xml';
    $src = 'calcalist';
    $t = 'Sports';
    $signe = '-';
    $hours = 3;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //10  zzz
    $xSource = 'http://www.ynet.co.il/Integration/StoryRss545.xml';
    $src = 'ynet';
    $t = 'Technology';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    $xSource = 'http://www.ynet.co.il/Integration/StoryRss3.xml';
    $src = 'ynet';
    $t = 'Sports';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    $xSource = 'http://www.ynet.co.il/Integration/StoryRss538.xml';
    $src = 'ynet';
    $t = 'General Culture';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    $xSource = 'http://www.ynet.co.il/Integration/StoryRss2.xml';
    $src = 'ynet';
    $t = 'News';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);

    //tgspot  zzz
    $xSource = 'https://www.tgspot.co.il/category/software/feed/';
    $src = 'TGspot';
    $t = 'Technology';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //zzz
    $xSource = 'https://www.debka.co.il/feed/';
    $src = 'debka';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //16 zzz
    $xSource = 'http://www.news-israel.net/feed/';
    $src = 'news-israel';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //zzz
    $xSource = 'https://www.srugim.co.il/feed';
    $src = 'srugim';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //zzz
    $xSource = 'https://hwzone.co.il/feed/';
    $src = 'HWzone';
    $t = 'Technology';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //zzz
    $xSource = 'http://www.93fm.co.il/feed/';
    $src = '93fm';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //20   zzz
    $xSource = 'http://www.themarker.com/cmlink/1.146';
    $src = 'themarker';
    $t = 'News';
    $signe = '-';
    $hours = 3;
    getrssfromsource($xSource, $src, $t, $signe, $hours);

    //with media
    //globes gmt  zzz
    $xSource = 'https://www.globes.co.il/webservice/rss/rssfeeder.asmx/FeederNode?iID=1225';
    $src = 'globes';
    $word = 'media:content';
    $t = 'Technology';
    $signe = '-';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //mako -2   zzz
    $xSource = 'http://rcs.mako.co.il/rss/news-world.xml';
    $src = 'mako';
    $word = 'image624X383';
    $t = 'News';
    $signe = '-';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'http://rcs.mako.co.il/rss/46bbe76404864110VgnVCM1000004801000aRCRD.xml';
    $src = 'mako';
    $word = 'image624X383';
    $t = 'Arts';
    $signe = '-';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
     
    $xSource = 'http://rcs.mako.co.il/rss/c7a987610879a310VgnVCM2000002a0c10acRCRD.xml';
    $src = 'mako';
    $word = 'image624X383';
    $t = 'General Culture';
    $signe = '-';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
     
    $xSource = 'http://rcs.mako.co.il/rss/cd0c4e8fc83b8310VgnVCM2000002a0c10acRCRD.xml';
    $src = 'mako';
    $word = 'image624X383';
    $t = 'Technology';
    $signe = '-';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'http://rcs.mako.co.il/rss/87b50a2610f26110VgnVCM1000005201000aRCRD.xml';
    $src = 'mako';
    $word = 'image435X329';
    $t = 'Sports';
    $signe = '-';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);


    //v2
    //27  zzz
    $xSource = 'https://www.globes.co.il/webservice/rss/rssfeeder.asmx/FeederNode?iid=9010';
    $src = 'globes';
    $word = 'media:content';
    $t = 'General Culture';
    $signe = '-';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //28  zzz
    $xSource = 'https://www.israelhayom.co.il/rss.xml';
    $src = 'Israel Hayom';
    $word = 'media:content';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //29 zzz
    $xSource = 'https://www.davar1.co.il/feed/';
    $src = 'Davar news';
    $word = 'media:content';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //30  zzz
    $xSource = 'https://www.hazofe.co.il/feed/';
    $src = 'hazofe';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);


    require_once('ads.php');
     
} catch (Exception $e) {
} ?>