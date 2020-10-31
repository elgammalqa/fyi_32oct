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
    if ($t == 'Sports') {
        if ($source == 'Youm7.com') $fav = 33;
        else if ($source == 'Elbalad.news') $fav = 34;
        else if ($source == 'RT') $fav = 35;
        else if ($source == 'Yallakora.com') $fav = 36;
        else if ($source == 'Masrawy.com') $fav = 37;
        else if ($source == 'Akhbaralaan.net') $fav = 38;
        else if ($source == 'Elwatannews.com') $fav = 39;
    } else if ($t == 'Technology') {
        if ($source == 'E3rfkora.news') $fav = 40;
        else if ($source == 'Masrawy.com') $fav = 41;
        else if ($source == 'Alarabiya.net') $fav = 42;
        else if ($source == 'Tech-wd.com') $fav = 43;
        else if ($source == 'Elwatannews.com') $fav = 44;
        else if ($source == 'RT') $fav = 45;
        else if ($source == 'Elbalad.news') $fav = 46;
        else if ($source == 'Akhbarelyom.com') $fav = 47;
        else if ($source == '218tv.net') $fav = 48;
        else if ($source == 'Almasryalyoum.com') $fav = 49;
    } else if ($t == 'Arts') {
        if ($source == 'Elbalad.news') $fav = 50;
        else if ($source == 'Masrawy.com') $fav = 51;
        else if ($source == 'Aljaras.com') $fav = 52;
        else if ($source == 'CNN') $fav = 53; 
        else if ($source == 'Youm7.com') $fav = 54;
        else if ($source == 'Filfan.com') $fav = 55;
        else if ($source == 'Arabnn.net') $fav = 56;
        else if ($source == 'Skynewsarabia.com') $fav = 57;
        else if ($source == 'Elwatannews.com') $fav = 58;
    } else if ($t == 'News') {
        if ($source == 'Elwatannews.com') $fav = 59;
        else if ($source == 'Misr-alan.com') $fav = 60;
        else if ($source == 'Mubasher.info') $fav = 61;
        else if ($source == 'Elbalad.news') $fav = 62;
        else if ($source == 'CNN') $fav = 63;
        else if ($source == 'Ngmisr.com') $fav = 64;
        else if ($source == 'Youm7.com') $fav = 65;
        else if ($source == 'Hapijournal.com') $fav = 66;
        else if ($source == 'Vetogate.com') $fav = 67;
        else if ($source == 'Akhbarelyom.com') $fav = 68;
        else if ($source == 'Alyuwm.com') $fav = 69;
        else if ($source == 'Masrawy.com') $fav = 70;


    } 
    return $fav;
}
    
    require '../fcm/Notification.php';
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
    $domain = 'https://www.fyipress.net/arabic/';
    $n = new TopicNotification();
    $n2 = new TopicNotification2();
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
                            $title = addslashes($item['title']);
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

                                $n->sendTopicNotification($name,$title, 'ar-'.$country.'-'.str_replace(' ','__',$name), $id, $link, 'ar');
                                $n2->sendTopicNotification2($name,$title, 'ar-'.$country.'-'.str_replace(' ','__',$name), $id, $link, 'ar');

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
                                $fcm->sendWebNoification('ar-'.$country.'-'.str_replace(' ','__',$name), $name.' | '.$title, 'FYIPress', $link);
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
    /* apix  egypt sports*/
    $xSource = 'https://newsapi.org/v2/top-headlines?country=eg&category=sports&apiKey=57ef1cc283884e60bd3e526a6447b8e4';
    $t = 'Sports'; 
    api_withmedia($xSource, $t, 'Egypt');
    $xSource = 'https://newsapi.org/v2/top-headlines?country=eg&category=technology&apiKey=c7a245e00dfb48139ba91510fb29c116';
    $t = 'Technology';
    api_withmedia($xSource, $t, 'Egypt');
    $xSource = 'https://newsapi.org/v2/top-headlines?country=eg&category=entertainment&apiKey=3f192d889b984273be6d826d559f8551';
    $t = 'Arts';
    api_withmedia($xSource, $t, 'Egypt');
    $xSource = 'https://newsapi.org/v2/top-headlines?country=eg&category=business&apiKey=00ed0174122f4ad9bb6aa23438efd4a4';
    $t = 'News';
    api_withmedia($xSource, $t, 'Egypt');


    require_once('ads.php');
} catch (Exception $e) {
} ?>
 