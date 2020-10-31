<?php
  
ini_set('error_reporting',E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log','LOG_feed.log');
ini_set('max_execution_time', 0);
ini_set('memory_limit','512M');
 
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

function getrsstime2($d)
{
    if ($d != "") {
        $d = trim($d);
        $parts = explode('T', $d);
        $year = $parts[0];
        $minutes = $parts[1];
        $time = explode('Z', $minutes);
        $date = "$year $time[0]";
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
    $domain = 'https://www.fyipress.net/chinese/';
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
            if ($src == '德国之声') {
                foreach ($xml->item as $item) {
                    $dc = $item->children('http://purl.org/dc/elements/1.1/');
                    $date = getrsstime2($dc->date);
                    $d2 = date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date)));
                    $d_insert = strtotime($date);
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
                    if ($d_insert > $d_last) {
                        if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {
                            $con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$media',  $favorite, '$photo')");
                            if ($t == 'News') {
                                $n = new TopicNotification();
                                $id = $con->lastInsertId();
                                $util = new utilisateursModel();
                                $src_row = $util->get_source_row($src);
                                $country = $src_row['country'];
                                
                                $n->sendTopicNotification($src, $title, 'ch-'.str_replace(' ', '__', $country) . '-' . str_replace(' ', '__', $src), $id, $link, 'ch');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   
                                $fcm = new WebFCMToTopic();
                                $fcm->sendWebNoification('ch-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
                                    $link); 
                                usleep(250000);
                            }
                        }
                    }
                } // foreach

            } else {

                foreach ($xml->channel->item as $item) {
                    $date = getrsstime($item->pubDate);
                    $d2 = date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date)));
                    $d_insert = strtotime($date);
                    $title = addslashes($item->title);
                    $description = addslashes($item->description);
                    $has_Paragraph_img = strpos($description, '<img') !== false;
                    $has_Paragraph = strpos($description, '</p>') !== false;
                    if ($has_Paragraph || $has_Paragraph_img) $description = '';
                    if ($src == '海交史' || $src == '清言' || $src == '南亞觀察') {
                        $has_Paragraph_a = strpos($description, '<a') !== false;
                        if ($has_Paragraph_a) {
                            $description = substr($description, 0, strpos($description, "<a"));
                        }
                    }
                    $has_hashtag = strpos($item->link, '#') !== false;
                    if ($has_hashtag) {
                        $whatIWant = substr($item->link, 0, strpos($item->link, "#"));
                        $link = addslashes($whatIWant);
                    } else {
                        $link = addslashes($item->link);
                    }
                    if ($d_insert > $d_last) {
                        if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {
                            $con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$media',  $favorite, '$photo')");
                            if ($t == 'News') {
                                $n = new TopicNotification();
                                $id = $con->lastInsertId();
                                $util = new utilisateursModel();
                                $src_row = $util->get_source_row($src);
                                $country = $src_row['country'];
                                 
                                $n->sendTopicNotification($src, $title, 'ch-'.str_replace(' ', '__', $country) . '-' . str_replace(' ', '__', $src), $id, $link, 'ch');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   

                                $fcm = new WebFCMToTopic();
                                $fcm->sendWebNoification('ch-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
                                    $link); 
                                usleep(250000);
                            }
                        }
                    }
                } // foreach

            }//german


        }// xsourcefile

    } //status

} //func 

function getrsswithmedia($xSource, $src, $t, $word, $signe, $hours)
{
    $domain = 'https://www.fyipress.net/chinese/';
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
                if ($src == '自由亚洲电台') {
                    $link = addslashes($item->guid);
                } else {
                    $link = addslashes($item->link);
                }
                $has_hashtag = strpos($link, '#') !== false;
                if ($has_hashtag) {
                    $link = substr($link, 0, strpos($link, "#"));
                }
                $date = getrsstime($item->pubDate);
                $d2 = date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date)));
                $d_insert = strtotime($date);
                if ($d_insert > $d_last) {

                    if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {
                        $con->exec("INSERT INTO `rss` VALUES (NULL, '$title' , '$description','$link', '$d2', '$m',  $favorite, '$photo')");
                        if ($t == 'News') {
                            $n = new TopicNotification();
                            $id = $con->lastInsertId();
                            $util = new utilisateursModel();
                            $src_row = $util->get_source_row($src);
                            $country = $src_row['country'];
                            $n->sendTopicNotification($src, $title, 'ch-'.str_replace(' ', '__', $country) . '-' . str_replace(' ', '__', $src), $id, $link, 'ch');

                            $stmt = $con->prepare("select count(*) as total from source_not_open where source = '$src'");
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if($row['total'] == 0){
                                $link = $domain."iframe.php?link=".$link."&id=".$id;
                            }

                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('ch-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
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
    //路透中文网 -8 zzz
    $xSource = 'http://cn.reuters.com/rssFeed/chinaNews/';
    $src = '路透中文网';
    $t = 'News';
    $signe = '-';
    $hours = 8;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    */
    //看中國 -8  zzz
    $xSource = 'https://www.secretchina.com/news/gb/p9.xml';
    $src = '看中國';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    $xSource = 'https://www.secretchina.com/news/gb/p7.xml';
    $src = '看中國';
    $t = 'General Culture';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);

    //v2
    //1 fff
    $xSource = 'https://theinitium.com/newsfeed/';
    $src = '端傳媒';
    $t = 'News';
    $signe = '-';
    $hours = 8;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //4  zzz
    $xSource = 'https://china.kyodonews.net/rss/news.xml';
    $src = '共同网';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //5  fff
    $xSource = 'https://zh.cn.nikkei.com/rss.html';
    $src = '日經中文網';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    /*
    //6 exist
    $xSource = 'https://cn.reuters.com/rssFeed/chinaNews/';
    $src = '路透中文网';
    $t = 'Technology';
    $signe = '-';
    $hours = 8;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    
    //7 exist
    $xSource = 'http://cn.reuters.com/rssFeed/CNEntNews';
    $src = '路透中文网';
    $t = 'Sports';
    $signe = '-';
    $hours = 8;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //8 exist
    $xSource = 'http://cn.reuters.com/rssFeed/vbc_livestyle_landing/';
    $src = '路透中文网';
    $t = 'General Culture';
    $signe = '-';
    $hours = 8;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    */
    //9  zzz
    $xSource = 'http://jiaren.org/feed/';
    $src = '佳人';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //11 zzz
    $xSource = 'https://www.appinn.com/feed/';
    $src = '小众软件';
    $t = 'Technology';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //12 zzz
    $xSource = 'https://rsshub.app/eeo/17';
    $src = '经济观察网';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //13 fff
    $xSource = 'http://www.4sbooks.com/feed';
    $src = '四季书评';
    $t = 'General Culture';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours); 
    //16   zzz
    $xSource = 'http://www.qijieshuzhai001.com/?feed=rss2';
    $src = '七街书斋';
    $t = 'General Culture';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //v3
    //2 ok
    $xSource = 'http://rss.dw.com/rdf/rss-chi-cul';
    $src = '德国之声';
    $t = 'General Culture';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //3 ok
    $xSource = 'http://rss.dw.com/rdf/rss-chi-sci';
    $src = '德国之声';
    $t = 'Technology';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);

    //1 okk
    $xSource = 'http://haijiaoshi.com/feed';
    $src = '海交史';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //2 ok
    /*
    $xSource = 'https://storystudio.tw/feed/';
    $src = '故事';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    */
    //3 ok
    $xSource = 'https://plausistory.blog/feed/';
    $src = '清言';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //4 ok
    $xSource = 'http://southasiawatch.tw/feed';
    $src = '南亞觀察';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);


    //with media
    //美国之音 -8   zzz
    $xSource = 'https://www.voachinese.com/api/z__yoerrvp';
    $src = '美国之音';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 8;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.voachinese.com/api/zjyyveyqvr';
    $src = '美国之音';
    $word = 'enclosure';
    $t = 'Technology';
    $signe = '-';
    $hours = 8;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.voachinese.com/api/zu_y_eprvt';
    $src = '美国之音';
    $word = 'enclosure';
    $t = 'General Culture';
    $signe = '-';
    $hours = 8;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.voachinese.com/api/z$yyretqvo';
    $src = '美国之音';
    $word = 'enclosure';
    $t = 'Sports';
    $signe = '-';
    $hours = 8;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //BBC gmt  zzz
    $xSource = 'http://feeds.bbci.co.uk/zhongwen/simp/rss.xml';
    $src = 'BBC';
    $word = 'media:thumbnail';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours); 
    //v2
    //1 fff
    $xSource = 'https://www.rfa.org/mandarin/rss2.xml';
    $src = '自由亚洲电台';
    $word = 'media:content';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);


    require_once('ads.php'); 
} catch (Exception $e) {
} ?>