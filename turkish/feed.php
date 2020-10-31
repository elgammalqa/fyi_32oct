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

function getSignePart($d)
{
    if ($d != "") {
        $d = trim($d);
        $parts = explode(' ', $d);
        $string = $parts[5];
        return $string;
    } else {
        return "";
    }
}

/* v5 */
function todaygmt()
{
    date_default_timezone_set('GMT');
    $today = date("Y-m-d H:i:s");
    return $today;
}

function addOrNot($d1)
{
    $dateTimestamp1 = strtotime($d1);
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

function getrssfromsource($xSource, $src, $t)
{
    $domain = 'https://www.fyipress.net/turkish/';
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
            $ok = true;
            foreach ($xml->channel->item as $item) {
                if ($ok) {
                    $sPart = getSignePart($item->pubDate);
                    if ($sPart == 'GMT' || $sPart == 'Z') {
                        $signe = '+';
                        $hours = 0;
                    } else {
                        $signe = substr($sPart, 0, 1);
                        if ($signe == "+") $signe = "-"; else $signe = "+";
                        $hours = substr($sPart, 2, 1);
                    }
                    $ok = false;
                } else {
                    break;
                }
            }
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

                $has_hashtag = strpos($item->link, '#') !== false;
                if ($has_hashtag) {
                    $whatIWant = substr($item->link, 0, strpos($item->link, "#"));
                    $link = addslashes($whatIWant);
                } else {
                    $link = addslashes($item->link);
                }
                $has_img = strpos($description, '<img') !== false;
                if ($has_img) {
                    $description = '';
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
                            $n->sendTopicNotification($src,$title, 'tu-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'tu');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   
                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('tu-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
                                $link);

                            usleep(250000);
                        }
                    }
                }
            } // foreach
        }// xsourcefile
    } //status
} //func 


function getrsswithmedia($xSource, $src, $t, $word)
{
    $domain = 'https://www.fyipress.net/turkish/';
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
            $ok = true;
            $hours=0;
            foreach ($xml->channel->item as $item) {
                if ($ok) {
                    $sPart = getSignePart($item->pubDate);
                    if ($sPart == 'GMT' || $sPart == 'Z') {
                        $signe = '+';
                        $hours = 0;
                    } else {
                        $signe = substr($sPart, 0, 1);
                        if ($signe == "+") $signe = "-"; else $signe = "+";
                        $hours = substr($sPart, 2, 1);
                    }
                    $ok = false;
                } else {
                    break;
                }
            }
            if ($hours != 0) {
                if ($signe == "+") $sig = "-"; else $sig = "+";
                $d_last = date("Y-m-d H:i:s", strtotime("$sig{$hours} hours", strtotime($d1)));
                $d_last = strtotime($d_last);
            } else {
                $d_last = strtotime($d1);
            }
            foreach ($xml->channel->item as $item) {
                if ($src == 'yenisafak') {
                    $m = addslashes($item->image->url);
                } else {
                    $m = addslashes($item->media["url"]);
                }
                if ($src == 'sabah') {
                    $has_questionMark = strpos($m, '?u=') !== false;
                    if ($has_questionMark) {
                        $m = substr($m, strpos($m, "?u=") + 3);
                    }
                } else {
                    $has_questionMark = strpos($m, '?') !== false;
                    if ($has_questionMark) {
                        $m = substr($m, 0, strpos($m, "?"));
                    }
                }

                $m = str_replace("http://", "https://", $m);
                $title = addslashes($item->title);
                $description = addslashes($item->description);
                $has_img = strpos($description, '<img') !== false;
                if ($has_img) {
                    $description = '';
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
                if ($d_insert > $d_last) {
                    if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {
                        $con->exec("INSERT INTO `rss` VALUES (NULL, '$title' , '$description','$link', '$d2', '$m', $favorite, '$photo')");

                        if($t == 'News'){
                            $n = new TopicNotification();
                            $id = $con->lastInsertId();
                            $util = new utilisateursModel();
                            $src_row = $util->get_source_row($src);
                            $country = $src_row['country'];
                            $n->sendTopicNotification($src,$title, 'tu-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'tu');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   
                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('tu-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
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
    //gercekgundem -3h
    $xSource = 'https://www.gercekgundem.com/rss';
    $src = 'gercek gundem';
    $t = 'News';
    getrssfromsource($xSource, $src, $t);
    //hurriyet gmt
    $xSource = 'http://www.hurriyet.com.tr/rss/spor';
    $src = 'hurriyet';
    $t = 'Sports';
    getrssfromsource($xSource, $src, $t);
    //hurriyet gmt
    $xSource = 'http://www.hurriyet.com.tr/rss/dunya';
    $src = 'hurriyet';
    $t = 'News';
    getrssfromsource($xSource, $src, $t);
    //hurriyet gmt
    $xSource = 'http://www.hurriyet.com.tr/rss/teknoloji';
    $src = 'hurriyet';
    $t = 'Technology';
    getrssfromsource($xSource, $src, $t);
    //skor sozcu gmt
    $xSource = 'http://skor.sozcu.com.tr/feed';
    $src = 'skor sozcu';
    $t = 'Sports';
    getrssfromsource($xSource, $src, $t);
    //aktif haber -3
    $xSource = 'http://aktifhaber.com/rss/post/2.xml';
    $src = 'aktif haber';
    $t = 'News';
    getrssfromsource($xSource, $src, $t);
    //aktif haber -3
    $xSource = 'http://aktifhaber.com/rss/post/4.xml';
    $src = 'aktif haber';
    $t = 'Technology';
    getrssfromsource($xSource, $src, $t);
    //aktif haber -3
    $xSource = 'http://aktifhaber.com/rss/post/5.xml';
    $src = 'aktif haber';
    $t = 'Sports';
    getrssfromsource($xSource, $src, $t);
    //aktif haber -3
    $xSource = 'http://aktifhaber.com/rss/post/6.xml';
    $src = 'aktif haber';
    $t = 'Arts';
    getrssfromsource($xSource, $src, $t);

    //v2
    //1
    $xSource = 'http://www.sozcu.com.tr/feed';
    $src = 'sozcu';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //2
    $xSource = 'https://www.birgun.net/xml/rss.xml';
    $src = 'BirGün';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);


    //with media
    //star gmt
    $xSource = 'http://www.star.com.tr/rss/rss.asp?cid=18';
    $src = 'star';
    $word = 'enclosure';
    $t = 'General Culture';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'http://www.star.com.tr/rss/rss.asp?cid=16';
    $src = 'star';
    $word = 'enclosure';
    $t = 'Sports';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'http://www.star.com.tr/rss/rss.asp?cid=17';
    $src = 'star';
    $word = 'enclosure';
    $t = 'News';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'http://www.star.com.tr/rss/rss.asp?cid=19';
    $src = 'star';
    $word = 'enclosure';
    $t = 'Arts';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'http://www.star.com.tr/rss/rss.asp?cid=124';
    $src = 'star';
    $word = 'enclosure';
    $t = 'Technology';
    getrsswithmedia($xSource, $src, $t, $word);
    //haber turk gmt
    $xSource = 'https://www.haberturk.com/rss/spor.xml';
    $src = 'haber turk';
    $word = 'enclosure';
    $t = 'Sports';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'https://www.haberturk.com/rss/kategori/dunya.xml';
    $src = 'haber turk';
    $word = 'enclosure';
    $t = 'News';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'https://www.haberturk.com/rss/kategori/kultur-sanat.xml';
    $src = 'haber turk';
    $word = 'enclosure';
    $t = 'General Culture';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'https://www.haberturk.com/rss/kategori/sinema.xml';
    $src = 'haber turk';
    $word = 'enclosure';
    $t = 'Arts';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'https://www.haberturk.com/rss/kategori/teknoloji.xml';
    $src = 'haber turk';
    $word = 'enclosure';
    $t = 'Technology';
    getrsswithmedia($xSource, $src, $t, $word);
    //sabah gmt
    $xSource = 'https://www.sabah.com.tr/rss/spor.xml';
    $src = 'sabah';
    $word = 'enclosure';
    $t = 'Sports';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'https://www.sabah.com.tr/rss/dunya.xml';
    $src = 'sabah';
    $word = 'enclosure';
    $t = 'News';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'https://www.sabah.com.tr/rss/teknoloji.xml';
    $src = 'sabah';
    $word = 'enclosure';
    $t = 'Technology';
    getrsswithmedia($xSource, $src, $t, $word);
    $xSource = 'https://www.sabah.com.tr/rss/kultur-sanat.xml';
    $src = 'sabah';
    $word = 'enclosure';
    $t = 'Arts';
    getrsswithmedia($xSource, $src, $t, $word);

    //v2
    //1
    $xSource = 'https://www.milligazete.com.tr/rss';
    $src = 'Milli Gazete';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //2
    $xSource = 'https://www.yenisafak.com/rss?xml=teknoloji';
    $src = 'yenisafak';
    $word = 'enclosurex';
    $t = 'Technology';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //3
    $xSource = 'https://www.yenisafak.com/rss?xml=spor';
    $src = 'yenisafak';
    $word = 'enclosurex';
    $t = 'Sports';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //4
    $xSource = 'https://www.yenisafak.com/rss?xml=dunya';
    $src = 'yenisafak';
    $word = 'enclosurex';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

    //5
    $xSource = 'https://www.yenisafak.com/rss?xml=hayat';
    $src = 'yenisafak';
    $word = 'enclosurex';
    $t = 'General Culture';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);


    require_once('ads.php');
} catch (Exception $e) {
} ?>