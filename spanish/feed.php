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
    $domain = 'https://www.fyipress.net/spanish/';
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
                $has_questionMark_link = strpos($link, '?') !== false;
                if ($has_questionMark_link) {
                    $link = substr($link, 0, strpos($link, "?"));
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
                            $n->sendTopicNotification($src,$title, 'sp-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'sp'); 
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   

                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('sp-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
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
    $domain = 'https://www.fyipress.net/spanish/';
    //echo 'with src :: '.$src.' -- type :: '.$t.'<br>';    
    if (utilisateursModel::get_source_status($src, $t) != null && utilisateursModel::get_source_status($src, $t) == 1) {
        if (!$xsourcefile = file_get_contents($xSource)) {
        } else {
            $favorite = getIdOfRssSources($src, $t);
            $xsourcefile = str_replace($word, 'media', $xsourcefile);
            $xml = simplexml_load_string($xsourcefile);
            $photo = "";
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
                $has_questionMark = strpos($m, '?') !== false;
                if ($has_questionMark) {
                    $m = substr($m, 0, strpos($m, "?"));
                }
                $m = str_replace("http://", "https://", $m);
                $title = addslashes($item->title);

                $description = addslashes($item->description);
                $has_Paragraph_img = strpos($description, '<img') !== false;
                if ($has_Paragraph_img) $description = '';

                if ($src == 'SPORT') {
                    $has_questionMark = strpos($description, '<a') !== false;
                    if ($has_questionMark) {
                        $description = substr($description, 0, strpos($description, "<a"));
                    }
                } else {
                    $has_Paragraph = strpos($description, '</p>') !== false;
                    if ($has_Paragraph) $description = '';
                }

                $has_hashtag = strpos($item->link, '#') !== false;
                if ($has_hashtag) {
                    $whatIWant = substr($item->link, 0, strpos($item->link, "#"));
                    $link = addslashes($whatIWant);
                } else {
                    $link = addslashes($item->link);
                }
                $has_questionMark_link = strpos($link, '?') !== false;
                if ($has_questionMark_link) {
                    $link = substr($link, 0, strpos($link, "?"));
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
                            $n->sendTopicNotification($src,$title, 'sp-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'sp');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }    

                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('sp-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
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
    /*
    //elnuevodia 0h
    $xSource = 'https://www.elnuevodia.com/rss/noticias';
    $src = 'elnuevodia';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //elnuevodia 0h
    $xSource = 'https://www.elnuevodia.com/rss/deportes';
    $src = 'elnuevodia';
    $t = 'Sports';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //elnuevodia 0h
    $xSource = 'https://www.elnuevodia.com/rss/tecnologia';
    $src = 'elnuevodia';
    $t = 'Technology';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    */
    //latinoamericano 0h
    $xSource = 'http://www.resumenlatinoamericano.org/feed/';
    $src = 'latinoamericano';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours); 
    //v2
    //1
    $xSource = 'https://est.zetaestaticos.com/aragon/rss/7_es.xml';
    $src = 'El Periódico';
    $t = 'Sports';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //2
    $xSource = 'https://est.zetaestaticos.com/aragon/rss/4_es.xml';
    $src = 'El Periódico';
    $t = 'News';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //3
    $xSource = 'https://est.zetaestaticos.com/aragon/rss/105_es.xml';
    $src = 'El Periódico';
    $t = 'General Culture';
    $signe = '-';
    $hours = 2;
    getrssfromsource($xSource, $src, $t, $signe, $hours);


    //with media 
    //elpais -1h
    $xSource = 'http://ep00.epimg.net/rss/deportes/portada.xml';
    $src = 'elpais';
    $t = 'Sports';
    $word = 'enclosure';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //elpais -1h
    $xSource = 'http://ep00.epimg.net/rss/internacional/portada.xml';
    $src = 'elpais';
    $t = 'News';
    $word = 'enclosure';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //elpais -1h
    $xSource = 'http://ep00.epimg.net/rss/tecnologia/portada.xml';
    $src = 'elpais';
    $t = 'Technology';
    $word = 'enclosure';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //clarin +3h
    $xSource = 'https://www.clarin.com/rss/mundo/';
    $src = 'clarin';
    $t = 'News';
    $word = 'enclosure';
    $signe = '+';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //clarin +3h
    $xSource = 'https://www.clarin.com/rss/cultura/';
    $src = 'clarin';
    $t = 'General Culture';
    $word = 'enclosure';
    $signe = '+';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //clarin +3h
    $xSource = 'https://www.clarin.com/rss/tecnologia/';
    $src = 'clarin';
    $t = 'Technology';
    $word = 'enclosure';
    $signe = '+';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //clarin +3h
    $xSource = 'https://www.clarin.com/rss/espectaculos/teatro/';
    $src = 'clarin';
    $t = 'Arts';
    $word = 'enclosure';
    $signe = '+';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //clarin +3h
    $xSource = 'https://www.clarin.com/rss/deportes/futbol/';
    $src = 'clarin';
    $t = 'Sports';
    $word = 'enclosure';
    $signe = '+';
    $hours = 3;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //eltiempo +0h
    $xSource = 'https://www.eltiempo.com/rss/mundo.xml';
    $src = 'eltiempo';
    $t = 'News';
    $word = 'enclosure';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //eltiempo +0h
    $xSource = 'https://www.eltiempo.com/rss/deportes.xml';
    $src = 'eltiempo';
    $t = 'Sports';
    $word = 'enclosure';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //eltiempo +0h
    $xSource = 'https://www.eltiempo.com/rss/cultura.xml';
    $src = 'eltiempo';
    $t = 'General Culture';
    $word = 'enclosure';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //eltiempo +0h
    $xSource = 'https://www.eltiempo.com/rss/tecnosfera.xml';
    $src = 'eltiempo';
    $t = 'Technology';
    $word = 'enclosure'; 
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //bbc +0h
    $xSource = 'http://feeds.bbci.co.uk/mundo/rss.xml';
    $src = 'bbc';
    $t = 'Technology';
    $word = 'media:thumbnail';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

    //v2 
    //8
    $xSource = 'https://www.sport.es/rss/futbol-internacional/rss.xml';
    $src = 'SPORT';
    $word = 'media:content';
    $t = 'Sports';
    $signe = '-';
    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);


    require_once('ads.php');
} catch (Exception $e) {
} ?>