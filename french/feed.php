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
  $today = date("Y-m-d");
  $yesterday = date("Y-m-d", strtotime("-1 day"));
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
if ($month == "Jan") $monthreal = 1;    if ($month == "Feb") $monthreal = 2;    if ($month == "Mar") $monthreal = 3;
if ($month == "Apr") $monthreal = 4;    if ($month == "May") $monthreal = 5;    if ($month == "Jun") $monthreal = 6;
if ($month == "Jul") $monthreal = 7;    if ($month == "Aug") $monthreal = 8;    if ($month == "Sep") $monthreal = 9;
if ($month == "Oct") $monthreal = 10;    if ($month == "Nov") $monthreal = 11;    if ($month == "Dec") $monthreal = 12;
return $monthreal;
}
/* v5 */
function getSignePart($d){
if ($d != "") {
$d = trim($d);
$parts = explode(' ', $d);
$string = $parts[5];
return $string;
} else {        return "";    }
}

/* v5 */
function todaygmt(){
date_default_timezone_set('GMT');
$today = date("Y-m-d H:i:s");
return $today;
}

function addOrNot($d2){
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

function getrssfromsource($xSource, $src, $t){
$domain = 'https://www.fyipress.net/french/';
//echo ' without src : '.$src.'  type : '.$t.'<br>';
if (utilisateursModel::get_source_status($src, $t) != null && utilisateursModel::get_source_status($src, $t) == 1) {
if (!$xsourcefile = file_get_contents($xSource)) {        } else {
$favorite = getIdOfRssSources($src, $t);
$xml = simplexml_load_string($xsourcefile);
$rss = new rssModel();
$rss_date = new rssModel();
include 'fyipanel/views/connect.php';
$media = "";            $photo = "";
$d1 = last_date_rss_all($favorite);
$ok = true;
foreach ($xml->channel->item as $item) {
if ($ok) {
$sPart = getSignePart($item->pubDate);
$signe = substr($sPart, 0, 1);
if ($signe == "+") $signe = "-"; else $signe = "+";
$hours = substr($sPart, 2, 1);
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
if ($d_insert > $d_last) {
if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {
$con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$media', $favorite, '$photo')");
if ($t == 'News') {
$n = new TopicNotification();
$id = $con->lastInsertId();
$util = new utilisateursModel();
$src_row = $util->get_source_row($src);
$country = $src_row['country'];
 
$n->sendTopicNotification($src, $title, 'fr-'.str_replace(' ', '__', $country) . '-' . str_replace(' ', '__', $src), $id, $link, 'fr');
                              
              if (!news_publishedModel::source_not_open($src)) { 
                $has_http = strpos($link,'http://') !== false;
              if($has_http){
                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
              }else{
                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
              }  
              }   

$fcm = new WebFCMToTopic();
$fcm->sendWebNoification('fr-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress', $link);
usleep(250000);
}
}
}
} // foreach
}// xsourcefile
} //status
} //func
function getrsswithmedia($xSource, $src, $t, $word){
$domain = 'https://www.fyipress.net/french/';
//echo ' with src : '.$src.'  type : '.$t.'<br>';
if (utilisateursModel::get_source_status($src, $t) != null && utilisateursModel::get_source_status($src, $t) == 1) {
if (!$xsourcefile = file_get_contents($xSource)) {        } else {
$favorite = getIdOfRssSources($src, $t);
 $xml2 = str_replace($word, 'media', $xsourcefile);
if ($src == 'abc7') {
$xml2 = str_replace('media:thumbnail', 'photo', $xml2);
} else {
  $photo = "";
}
 $xml = simplexml_load_string($xml2);
$rss = new rssModel();
$rss_date = new rssModel();
include 'fyipanel/views/connect.php';
$d1 = last_date_rss_all($favorite);
$ok = true;
foreach ($xml->channel->item as $item) {
if ($ok) {
$sPart = getSignePart($item->pubDate);
$signe = substr($sPart, 0, 1);
if ($signe == "+") $signe = "-"; else $signe = "+";
$hours = substr($sPart, 2, 1);
$ok = false;
} else { break;  }
}
if ($hours != 0) {
  if ($signe == "+") $sig = "-"; else $sig = "+";
  $d_last = date("Y-m-d H:i:s", strtotime("$sig{$hours} hours", strtotime($d1)));
  $d_last = strtotime($d_last);
} else { $d_last = strtotime($d1); }
foreach ($xml->channel->item as $item) {
  // $video=addslashes($item->enclosure['url']);
  if ($src == 'abc7') $photo = addslashes($item->photo["url"]);
  $m = addslashes($item->media["url"]);
  $title = addslashes($item->title);
  $description = addslashes($item->description);
  $has_hashtag = strpos($item->link, '#') !== false;
  if ($has_hashtag) {
    $whatIWant = substr($item->link, 0, strpos($item->link, "#"));
    $link = addslashes($whatIWant);
  } else {
    $link = addslashes($item->link);
  }
  $has_questionMark = strpos($m, '?') !== false;
  if ($has_questionMark) {
    $m = substr($m, 0, strpos($m, "?"));
  }
  $m = str_replace("http://", "https://", $m);
  $date = getrsstime($item->pubDate);
  $d2 = date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date)));
  $d_insert = strtotime($date);
  if ($d_insert > $d_last) {
    if ($date != "" && NbnewsBytitleInLastDate($d2, $title, $favorite) == 0 && addOrNot($d2)) {
      $con->exec("INSERT INTO `rss` VALUES (NULL, '$title' , '$description','$link', '$d2', '$m', $favorite, '$photo')");
      if ($t == 'News') { 
        $n = new TopicNotification();
        $id = $con->lastInsertId();
        $util = new utilisateursModel();
        $src_row = $util->get_source_row($src);
        $country = $src_row['country'];
        
        $n->sendTopicNotification($src, $title, 'fr-'.str_replace(' ', '__', $country) . '-' . str_replace(' ', '__', $src), $id, $link, 'fr');
                              
              if (!news_publishedModel::source_not_open($src)) { 
                $has_http = strpos($link,'http://') !== false;
              if($has_http){
                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
              }else{
                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
              }  
              }   
        $fcm = new WebFCMToTopic();
        $fcm->sendWebNoification('fr-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $src.' | '.$title, 'FYIPress',$link);
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
  //le figaro -1h
  $xSource = 'http://www.lefigaro.fr/rss/figaro_secteur_high-tech.xml';
  $src = 'le figaro';    $t = 'Technology';
  getrssfromsource($xSource, $src, $t);

  $xSource = 'http://www.lefigaro.fr/rss/figaro_culture.xml';
  $src = 'le figaro';    $t = 'General Culture';
  getrssfromsource($xSource, $src, $t);

  $xSource = 'http://sport24.lefigaro.fr/rssfeeds/sport24-accueil.xml';
  $src = 'le figaro';    $t = 'Sports';
  getrssfromsource($xSource, $src, $t);
  //sud-ouest -1h
  $xSource = 'https://www.sudouest.fr/unes/sports/rss.xml';
  $src = 'sud-ouest';    $t = 'Sports';
  getrssfromsource($xSource, $src, $t);

  $xSource = 'https://www.sudouest.fr/culture/cinema/rss.xml';
  $src = 'sud-ouest';    $t = 'General Culture';
  getrssfromsource($xSource, $src, $t);

  $xSource = 'https://www.sudouest.fr/essentiel/rss.xml';
  $src = 'sud-ouest';    $t = 'News';
  getrssfromsource($xSource, $src, $t);
  /*v2 */
  //1 media part -2 news
  $xSource = 'https://www.mediapart.fr/articles/feed';
  $src = 'media part';    $t = 'News';    $signe = '-';    $hours = 2;
  getrssfromsource($xSource, $src, $t, $signe, $hours);
  //2 lexpress -2 news
  $xSource = 'https://www.lexpress.fr/rss/monde.xml';
  $src = 'lexpress';    $t = 'News';    $signe = '-';    $hours = 2;
  getrssfromsource($xSource, $src, $t, $signe, $hours);

  $xSource = 'https://www.lexpress.fr/rss/sport.xml';
  $src = 'lexpress';    $t = 'Sports';    $signe = '-';    $hours = 2;
  getrssfromsource($xSource, $src, $t, $signe, $hours);

  $xSource = 'https://www.lexpress.fr/rss/culture.xml';
  $src = 'lexpress';    $t = 'General Culture';    $signe = '-';    $hours = 2;
  getrssfromsource($xSource, $src, $t, $signe, $hours);

  //with media
   //L'equipe -1
   $xSource = 'https://www.lequipe.fr/rss/actu_rss.xml';
   $src = "L'equipe";    $word = 'enclosure';    $t = 'Sports';
   getrsswithmedia($xSource, $src, $t, $word);
   //peut etre va supprimer
    //L'OBS -1
    $xSource = 'http://www.nouvelobs.com/culture/rss.xml';
    $src = "L'OBS";    $word = 'enclosure';    $t = 'General Culture';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'http://o.nouvelobs.com/high-tech/rss.xml';
    $src = "L'OBS";    $word = 'enclosure';    $t = 'Technology';
    getrsswithmedia($xSource, $src, $t, $word);
    //le monde -1
    $xSource = 'https://www.lemonde.fr/m-actu/rss_full.xml';
    $src = "le monde";    $word = 'enclosure';    $t = 'News';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.lemonde.fr/culture/rss_full.xml';
    $src = "le monde";    $word = 'enclosure';    $t = 'General Culture';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.lemonde.fr/sport/rss_full.xml';
    $src = "le monde";    $word = 'enclosure';    $t = 'Sports';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.lemonde.fr/technologies/rss_full.xml';
    $src = "le monde";    $word = 'enclosure';    $t = 'Technology';
    getrsswithmedia($xSource, $src, $t, $word);
    //le point -1
    $xSource = 'https://www.lepoint.fr/monde/rss.xml';
    $src = "le point";    $word = 'enclosure';    $t = 'News';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.lepoint.fr/sport/rss.xml';
    $src = "le point";    $word = 'enclosure';    $t = 'Sports';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.lepoint.fr/culture/rss.xml';
    $src = "le point";    $word = 'enclosure';    $t = 'General Culture';
    getrsswithmedia($xSource, $src, $t, $word);
    //france info -1
    $xSource = 'https://www.francetvinfo.fr/monde.rss';
    $src = "france info";    $word = 'enclosure';    $t = 'News';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.francetvinfo.fr/culture/cinema.rss';
    $src = "france info";    $word = 'enclosure';    $t = 'Arts';
    getrsswithmedia($xSource, $src, $t, $word);
    //la presse -1
    $xSource = 'https://www.lapresse.ca/rss/216.xml';
    $src = "la presse";    $word = 'enclosure';    $t = 'Arts';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.lapresse.ca/rss/179.xml';
    $src = "la presse";    $word = 'enclosure';    $t = 'News';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.lapresse.ca/rss/229.xml';
    $src = "la presse";    $word = 'enclosure';    $t = 'Sports';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.lapresse.ca/rss/238.xml';
    $src = "la presse";    $word = 'enclosure';    $t = 'General Culture';
    getrsswithmedia($xSource, $src, $t, $word);

    $xSource = 'https://www.lapresse.ca/rss/53.xml';
    $src = "la presse";    $word = 'enclosure';    $t = 'Technology';
    getrsswithmedia($xSource, $src, $t, $word);
    /* v2 */
    //1  challenges News -2
    $xSource = 'https://www.challenges.fr/monde/rss.xml';
    $src = 'challenges';    $word = 'enclosure';    $t = 'News';    $signe = '-';    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //2  challenges Technology -2
    $xSource = 'https://www.challenges.fr/high-tech/rss.xml';
    $src = 'challenges';    $word = 'enclosure';    $t = 'Technology';    $signe = '-';    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //3
    $xSource = 'https://www.challenges.fr/patrimoine/rss.xml';
    $src = 'challenges';    $word = 'enclosure';    $t = 'General Culture';    $signe = '-';    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    //4  courrierinternational
    $xSource = 'https://www.courrierinternational.com/feed/all/rss.xml';
    $src = 'courrier international';    $word = 'enclosure';    $t = 'News';    $signe = '-';    $hours = 2;
    getrsswithmedia($xSource, $src, $t, $word, $signe, $hours);
    require_once('ads.php');
  } catch (Exception $e) {

  } 
  ?>
  
 