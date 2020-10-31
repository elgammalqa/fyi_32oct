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
    $domain = 'https://www.fyipress.net/japanese/';
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
                            
                            $n->sendTopicNotification($src,$title, 'jp-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'jp');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   

                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('jp-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',
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
    $domain = 'https://www.fyipress.net/japanese/';
    //echo 'with src :: '.$src.' -- type :: '.$t.'<br>';    
    if (utilisateursModel::get_source_status($src, $t) != null && utilisateursModel::get_source_status($src, $t) == 1) {
        if (!$xsourcefile = file_get_contents($xSource)) {
        } else {
            $favorite = getIdOfRssSources($src, $t);
            $xml2 = str_replace($word, 'media', $xsourcefile);
            $xml = simplexml_load_string($xml2);
            $rss = new rssModel();
            $rss_date = new rssModel();
            include 'fyipanel/views/connect.php';
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

                if ($src == "福井新聞" || $src == "佐賀新聞") {
                    $m = addslashes($item->media);
                } else if ($src == "ガジェット通信") {
                    $m = addslashes($item->media->original);
                } else {
                    $m = addslashes($item->media["url"]);
                }
                $has_questionMark = strpos($m, '?') !== false;
                if ($has_questionMark) {
                    $m = substr($m, 0, strpos($m, "?"));
                }

                if ($src == "福井新聞" || $src == "佐賀新聞" || $src == "ガジェット通信") {
                    $description = " ";
                } else {
                    $description = addslashes($item->description);
                }
                $has_Paragraph = strpos($description, '<img') !== false;
                if ($has_Paragraph) $description = '';
                $m = addslashes($item->media["url"]);
                $has_questionMark = strpos($m, '?') !== false;
                if ($has_questionMark) {
                    $m = substr($m, 0, strpos($m, "?"));
                }
                $m = str_replace("http://", "https://", $m);
                $title = addslashes($item->title);
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
                            
                            $n->sendTopicNotification($src,$title, 'jp-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'jp');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }    

                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('jp-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',$link); 
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
    //ニフティ ニュース -9
    $xSource = 'https://news.nifty.com/rss/topics_world.xml';
    $src = 'ニフティ ニュース';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    $xSource = 'https://news.nifty.com/rss/topics_technology.xml';
    $src = 'ニフティ ニュース';
    $t = 'Technology';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    $xSource = 'https://news.nifty.com/rss/topics_sports.xml';
    $src = 'ニフティ ニュース';
    $t = 'Sports';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //サンスポ -9
    $xSource = 'https://www.sanspo.com/rss/chumoku/news/allsports-n.xml';
    $src = 'サンスポ';
    $t = 'Sports';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //財経新聞 -9
    $xSource = 'http://www.zaikei.co.jp/rss/sections/it.xml';
    $src = '財経新聞';
    $t = 'Technology';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //秋田 -9
    $xSource = 'http://feeds.feedburner.com/akita_news';
    $src = '秋田';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //日本新聞協会 -9
    $xSource = 'https://www.pressnet.or.jp/feed/headline.xml';
    $src = '日本新聞協会';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //WIRED -9
    $xSource = 'https://wired.jp/rssfeeder/';
    $src = 'WIRED';
    $t = 'Technology';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);

    //v2
    //1
    $xSource = 'https://www.iwanichi.co.jp/feed/';
    $src = '岩手日日';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //2
    $xSource = 'https://www.kyodo.co.jp/feed/';
    $src = 'KYODO';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //3
    $xSource = 'http://www.nankainn.com/feed';
    $src = '南海日日新聞';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //4 already exist in rss sources
    $xSource = 'https://www.sanspo.com/rss/flash/news/flash-n.xml';
    $src = 'サンスポ';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //5
    $xSource = 'http://rss.shikoku-np.co.jp/rss/flash.aspx';
    $src = '四国新聞社';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //6
    $xSource = 'https://ubenippo.co.jp/feed/';
    $src = '宇部日報';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //7
    $xSource = 'https://www.tokyo-sports.co.jp/feed/';
    $src = '東スポWeb';
    $t = 'Sports';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //8
    $xSource = 'http://www.zaikei.co.jp/rss/sections/life.xml';
    $src = '財経新聞';
    $t = 'General Culture';
    $signe = '-';
    $hours = 9;
    getrssfromsource($xSource, $src, $t, $signe, $hours);
    //9
    $xSource = 'https://otajo.jp/feed';
    $src = 'オタ女';
    $t = 'News';
    $signe = '+';
    $hours = 0;
    getrssfromsource($xSource, $src, $t, $signe, $hours);


    //with media
    //福井新聞 -9
    $xSource = 'https://www.fukuishimbun.co.jp/list/feed/rss';
    $src = '福井新聞';
    $word = 'media:thumbnail';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //佐賀新聞 -9
    $xSource = 'https://www.saga-s.co.jp/list/feed/rss';
    $src = '佐賀新聞';
    $word = 'media:thumbnail';
    $t = 'Sports';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //イザ -9
    $xSource = 'http://www.iza.ne.jp/feed/kiji/kiji-n.xml';
    $src = 'イザ';
    $word = 'media:content';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //zakzak -9
    $xSource = 'https://www.zakzak.co.jp/rss/news/politics.xml';
    $src = 'zakzak';
    $word = 'media:content';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.zakzak.co.jp/rss/news/sports.xml';
    $src = 'zakzak';
    $word = 'media:content';
    $t = 'Sports';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    $xSource = 'https://www.zakzak.co.jp/rss/news/life.xml';
    $src = 'zakzak';
    $word = 'media:content';
    $t = 'General Culture';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //サンケイビズ -9
    $xSource = 'https://www.sankeibiz.jp/rss/news/world.xml';
    $src = 'サンケイビズ';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //ギズモード -9
    $xSource = 'https://www.gizmodo.jp/index.xml';
    $src = 'ギズモード';
    $word = 'enclosure';
    $t = 'Technology';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //ログミー -9
    $xSource = 'https://logmi.jp/feed/public.xml';
    $src = 'ログミー';
    $word = 'enclosure';
    $t = 'Technology';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //ガジェット通信 -9
    $xSource = 'https://getnews.jp/feed/ext/orig';
    $src = 'ガジェット通信';
    $word = 'image';
    $t = 'Arts';
    $signe = '+';
    $hours = 0;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);

    //v2
    //1
    $xSource = 'https://www.sankeibiz.jp/rss/news/infotech.xml';
    $src = 'サンケイビズ';
    $word = 'enclosure';
    $t = 'Technology';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //2
    $xSource = 'https://www.sankeibiz.jp/rss/news/life.xml';
    $src = 'サンケイビズ';
    $word = 'enclosure';
    $t = 'General Culture';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //3
    $xSource = 'https://www.lifehacker.jp/feed/index.xml';
    $src = 'ライフハッカー';
    $word = 'enclosure';
    $t = 'News';
    $signe = '-';
    $hours = 9;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);


    require_once('ads.php');
} catch (Exception $e) {
} ?>