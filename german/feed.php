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

/* v5 */
function todaygmt()
{
    date_default_timezone_set('GMT');
    $today = date("Y-m-d H:i:s");
    return $today;
}

function addOrNot($d2)
{
    $dateTimestamp1 = strtotime($d2);
    $dateTimestamp2 = strtotime(todaygmt());
    if ($dateTimestamp1 <= $dateTimestamp2) {
        return true;
    } else {
        return false;
    }
}

include 'models/utilisateurs.model.php';

require '../fcm/TopicNotification.php';

require '../fcm/WebFCMToTopic.php';

require_once 'fyipanel/models/news_published.model.php';

function getrssfromsource($xSource, $src, $t, $signe, $hours)
{
    $domain = 'https://www.fyipress.net/german/';
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
                $has_Paragraph = strpos($description, '<img') !== false;
                if ($has_Paragraph) $description = '';
                $has_hashtag = strpos($item->link, '#') !== false;
                if ($has_hashtag) {
                    $whatIWant = substr($item->link, 0, strpos($item->link, "#"));
                    $link = addslashes($whatIWant);
                } else {
                    $link = addslashes($item->link);
                }
                if ($d_insert > $d_last) {

                    if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {
                        $con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$media', $favorite, '$photo')");

                        if($t == 'News'){
                            $n = new TopicNotification();
                            $id = $con->lastInsertId();
                            $util = new utilisateursModel();
                            $src_row = $util->get_source_row($src);
                            $country = $src_row['country'];
                            
                            $n->sendTopicNotification($src,$title, 'ge-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'ge');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   
 
                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('ge-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
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
    $domain = 'https://www.fyipress.net/german/';
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
                $d_last = date("Y-m-d H:i:s", strtotime("$sig{$hours} hours", strtotime($d1)));
                $d_last = strtotime($d_last);
            } else {
                $d_last = strtotime($d1);
            }
            foreach ($xml->channel->item as $item) {
                $m = addslashes($item->media["url"]);
                $title = addslashes($item->title);
                $description = addslashes($item->description);
                $has_questionMark = strpos($m, '?') !== false;
                if ($has_questionMark) {
                    $m = substr($m, 0, strpos($m, "?"));
                }
                $m = str_replace("http://", "https://", $m);
                $has_Paragraph = strpos($description, '<img') !== false;
                if ($has_Paragraph) $description = '';
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
                        $con->exec("INSERT INTO `rss` VALUES (NULL, '$title' , '$description','$link', '$d2', '$m', $favorite, '$photo')");
 
                        if($t == 'News'){
                            $n = new TopicNotification();
                            $id = $con->lastInsertId();
                            $util = new utilisateursModel();
                            $src_row = $util->get_source_row($src);
                            $country = $src_row['country'];
                            
                            $n->sendTopicNotification($src,$title, 'ge-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'ge');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   
                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('ge-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
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
    //JUNGE FREIHEIT 0h
    $xSource = 'https://jungefreiheit.de/feed/';
    $src = 'JUNGE FREIHEIT';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //Motorsport -1h
    $xSource = 'https://www.motorsport-magazin.com/rss/alle-rennserien.xml';
    $src = 'Motorsport';
    $t = 'Sports';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //COMPUTER BILD -1h
    $xSource = 'https://www.computerbild.de/rssfeed_2261.html?node=10';
    $src = 'COMPUTER BILD';
    $t = 'Technology';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //PC-WELT -1h
    $xSource = 'https://www.pcwelt.de/rss/ratgeberfeed.xml';
    $src = 'PC-WELT';
    $t = 'Technology';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //v2
    //1
    $xSource = 'https://www.sportschau.de//sportschauindex100~_type-rss.feed';
    $src = 'Sportschau';
    $t = 'Sports';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //2
    $xSource = 'https://www.neues-deutschland.de/rss/kultur.xml';
    $src = 'neues deutschland';
    $t = 'General Culture';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);


    //with media
    //stern gmt
    $xSource = 'https://www.stern.de/feed/standard/politik/';
    $src = 'stern';
    $word = 'enclosure';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.stern.de/feed/standard/sport/';
    $src = 'stern';
    $word = 'enclosure';
    $t = 'Sports';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.stern.de/feed/standard/kultur/';
    $src = 'stern';
    $word = 'enclosure';
    $t = 'Arts';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'http://www.stern.de/feed/standard/lifestyle/';
    $src = 'stern';
    $word = 'enclosure';
    $t = 'General Culture';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //RP ONLINE -1
    $xSource = 'https://rp-online.de/politik/feed.rss';
    $src = 'RP ONLINE';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://rp-online.de/sport/feed.rss';
    $src = 'RP ONLINE';
    $word = 'enclosure';
    $t = 'Sports';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://rp-online.de/kultur/feed.rss';
    $src = 'RP ONLINE';
    $word = 'enclosure';
    $t = 'General Culture';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://rp-online.de/digitales/feed.rss';
    $src = 'RP ONLINE';
    $word = 'enclosure';
    $t = 'Technology';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //ksta -1
    $xSource = 'https://www.ksta.de/blueprint/servlet/xml/ksta/23699296-asYahooFeed.xml';
    $src = 'ksta';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.ksta.de/blueprint/servlet/xml/ksta/23699302-asYahooFeed.xml';
    $src = 'ksta';
    $word = 'enclosure';
    $t = 'Arts';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    /*
    //Berliner Zeitung -1
    $xSource = 'https://www.berliner-zeitung.de/blueprint/servlet/xml/berliner-zeitung/23699614-asYahooFeed.xml';
    $src = 'Berliner Zeitung';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.berliner-zeitung.de/blueprint/servlet/xml/berliner-zeitung/23699874-asYahooFeed.xml';
    $src = 'Berliner Zeitung';
    $word = 'enclosure';
    $t = 'Sports';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.berliner-zeitung.de/blueprint/servlet/xml/berliner-zeitung/23700020-asYahooFeed.xml';
    $src = 'Berliner Zeitung';
    $word = 'enclosure';
    $t = 'General Culture';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.berliner-zeitung.de/blueprint/servlet/xml/berliner-zeitung/23700594-asYahooFeed.xml';
    $src = 'Berliner Zeitung';
    $word = 'enclosure';
    $t = 'Technology';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    */
    //GALA -1
    $xSource = 'http://www.gala.de/feed/standard-rss/';
    $src = 'GALA';
    $word = 'enclosure';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //v2
    //1
    $xSource = 'https://www.wiwo.de/contentexport/feed/rss/technologie';
    $src = 'WiWo';
    $word = 'enclosure';
    $t = 'Technology';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //2
    $xSource = 'https://www.wiwo.de/contentexport/feed/rss/politik';
    $src = 'WiWo';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //3
    $xSource = 'https://www.wiwo.de/contentexport/feed/rss/lifestyle';
    $src = 'WiWo';
    $word = 'enclosure';
    $t = 'General Culture';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //4
    $xSource = 'https://bnn.de/nachrichten/kultur/feed';
    $src = 'BNN';
    $word = 'enclosure';
    $t = 'General Culture';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //5
    $xSource = 'https://bnn.de/nachrichten/sport/feed';
    $src = 'BNN';
    $word = 'enclosure';
    $t = 'Sports';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //6
    $xSource = 'https://bnn.de/nachrichten/politik/feed';
    $src = 'BNN';
    $word = 'enclosure';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //7
    $xSource = 'https://www.noz.de/rss/ressort/Sport';
    $src = 'NOZ';
    $word = 'enclosure';
    $t = 'Sports';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //8
    $xSource = 'https://www.noz.de/rss/ressort/Politik';
    $src = 'NOZ';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //9
    $xSource = 'https://www.noz.de/rss/ressort/Kultur';
    $src = 'NOZ';
    $word = 'enclosure';
    $t = 'Arts';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);


    require_once('ads.php');
} catch (Exception $e) {
} ?>