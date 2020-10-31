<?php
 /*
ini_set('error_reporting',E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log','LOG_newsapi.log');
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

/* api methods */
function api_getrsstime($d)
{
    if ($d != "") {
        $d = trim($d);
        $parts = explode('T', $d);
        $date = $parts[0];
        $rest = explode('Z', $parts[1]);
        $time = $rest[0];
        $full_date = "$date $time";
        return $full_date;
    } else {
        return "";
    }
}

function api_get_source_status($id)
{
    include("fyipanel/views/connect.php");
    $requete = $con->prepare('SELECT  status FROM rss_sources where id="' . $id . '" ');
    $requete->execute();
    $status = $requete->fetchColumn();
    return $status;
}

function getFevorite($source, $t)
{
    $fav = 0;
    if ($source == 't-online.de') $fav = 49;
    if ($source == 'Merkur.de') $fav = 50;
    return $fav;
}

    require '../fcm/TopicNotification.php';
    require '../fcm/WebFCMToTopic.php';
    require_once 'fyipanel/models/news_published.model.php';
    require_once('models/utilisateurs.model.php'); 
    function api_get_source($id)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT  source FROM rss_sources where id="' . $id . '" ');
        $requete->execute();
        $source = $requete->fetchColumn();
        return $source;
    } 

function api_withmedia($url, $t, $country)
{ 

    $domain = 'https://www.fyipress.net/german/';
    $n = new TopicNotification();
    // echo 'type : '.$t.'<br>';
    if (!$json = file_get_contents($url)) {
    } else {
        $data = json_decode($json, true);
        $photo = "";
        include 'fyipanel/views/connect.php';
        foreach ($data as $news) {

            if (is_array($news) || is_object($news)) {
                foreach ($news as $item) {

                    foreach ($item as $source) {
                        $name = $source['name'];
                        $favorite = getFevorite($name, $t);
                        break;
                    }

                    if (api_get_source_status($favorite) != null && api_get_source_status($favorite) == 1) {
                        if ($favorite != 0) {

                            $title = 'Breaking News| '.addslashes($item['title']);
                            $description = addslashes($item['description']);
                            $link = addslashes($item['url']);
                            $has_hashtag = strpos($link, '#') !== false;
                            if ($has_hashtag) {
                                $link = substr($link, 0, strpos($link, "#"));
                            }
                            $media = addslashes($item['urlToImage']);
                            $media = str_replace("http://", "https://", $media); //ahram sports nn
                            $has_questionMark = strpos($media, '?') !== false;
                            if ($has_questionMark) {
                                $media = substr($media, 0, strpos($media, "?"));
                            }
                            $date = api_getrsstime($item['publishedAt']);
                            if ($date != "" && NbnewsBytitleInLastDate($date, $title, $favorite) == 0 && addOrNot($date)) {
                                $con->exec("INSERT INTO `rss` VALUES (NULL, '$title' ,'$description','$link', '$date', '$media',$favorite, '$photo')");
                                $id = $con->lastInsertId();
                                $n->sendTopicNotification($name,$title, 'ge-'.$country.'-'.str_replace(' ','__',$name), $id, $link,'ge');
 
                                 //zzz  
                                if (!news_publishedModel::source_not_open(api_get_source($favorite))) {//fyi
                                        $has_http = strpos($link,'http://') !== false;
                                        if($has_http){
                                            $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                                        }else{
                                             $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                                        }  
                                }  
                                $fcm = new WebFCMToTopic();
                                $fcm->sendWebNoification('ge-'.$country.'-'.str_replace(' ','__',$name), $name.' | '.$title, 'FYIPress', $link);
                                usleep(250000);  

                            }


                        }//favorite ok
                    }//status ok
                }//for items
            }//if is array
        }//for news arrays
    }//link ok
} //func


try {

    require_once('models/rssModel.php');
    fill_rss_tmp();
    $xSource = 'https://newsapi.org/v2/top-headlines?country=de&category=general&apiKey=4c04cc493d624781927e2b172ed8f72a';
    $t = 'News';
    api_withmedia($xSource, $t, 'German');

    require_once('ads.php');
} catch (Exception $e) {
} ?>
 