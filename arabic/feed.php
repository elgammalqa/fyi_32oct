<?php
/*
ini_set('error_reporting',E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log','LOG_feed.log');
ini_set('max_execution_time', 0);
ini_set('memory_limit','512M');
  */
function NbnewsBytitleInLastDate($date,$title,$fav){
    include("fyipanel/views/connect.php");
    $dt = new DateTime($date);
    $dateonly = $dt->format('Y-m-d');
    $title=str_replace("'", "\'", $title);
    $requete = $con->prepare('SELECT  count(*) FROM rss_tmp where  title="'.$title.'" and pubDate like "'.$dateonly.'%" and favorite='.$fav);
    $requete->execute();
    $lastdate = $requete->fetchColumn();
    return  $lastdate ;
}
  
function fill_rss_tmp(){
    include("fyipanel/views/connect.php");
    $con->exec('delete from rss_tmp');
    date_default_timezone_set('GMT');
    $tomorrow = date("Y-m-d", strtotime("+1 day"));
    $today = date("Y-m-d") ;
    $yesterday = date("Y-m-d", strtotime("-1 day"));
    $con->exec('insert into rss_tmp SELECT  * FROM rss where pubDate like "'.$today.'%" or
        pubDate like "'.$tomorrow.'%"  or pubDate like "'.$yesterday.'%"');
}

function last_date_rss_all($favorite){
    include("fyipanel/views/connect.php");
    $requete = $con->prepare('SELECT  max(pubDate) FROM rss where favorite="'.$favorite.'"');
    $requete->execute();
    $lastdate = $requete->fetchColumn();
    return  $lastdate ;
}

function getIdOfRssSources($source,$xtype)
{
    include("fyipanel/views/connect.php");
    $requete = $con->prepare('select id from rss_sources  where source="'.$source.'" and type="'.$xtype.'" ');
    $requete->execute();
    $nbrfeeds = $requete->fetchColumn();
    return  $nbrfeeds ;
}

function getrsstime($d)
{
    if($d!=""){
        $d=trim($d);
        $parts=explode(' ',$d);
        $month=$parts[2];
        $monthreal=getmonth($month);
        $time=explode(':',$parts[4]);
        $date="$parts[3]-$monthreal-$parts[1] $time[0]:$time[1]:$time[2]";
        return $date;
    }else{
        return "";
    }
}

function getmonth($month){
    if($month=="Jan") $monthreal=1; if($month=="Feb") $monthreal=2; if($month=="Mar") $monthreal=3;
    if($month=="Apr") $monthreal=4;  if($month=="May") $monthreal=5;  if($month=="Jun") $monthreal=6;
    if($month=="Jul") $monthreal=7;  if($month=="Aug") $monthreal=8; if($month=="Sep") $monthreal=9;
    if($month=="Oct") $monthreal=10;  if($month=="Nov") $monthreal=11; if($month=="Dec") $monthreal=12;
    return $monthreal;
}

/* v5 */
function todaygmt(){
    date_default_timezone_set('GMT');
    $today = date("Y-m-d H:i:s") ;
    return $today;
}
  
function addOrNot($d2)
{
    $dateTimestamp1 = strtotime($d2);
    $dateTimestamp2 = strtotime(todaygmt());
    if($dateTimestamp1<=$dateTimestamp2){
        return true;
    }else{
        return false;
    }
}

include 'models/utilisateurs.model.php';

require '../fcm/TopicNotification.php';
require '../fcm/Notification.php';

require '../fcm/WebFCMToTopic.php';

require_once 'fyipanel/models/news_published.model.php';

function getrssfromsource($xSource,$src,$t,$signe,$hours){
    $domain = 'https://www.fyipress.net/arabic/';
    // echo 'src : '.$src.' type : '.$t.'<br>';
    if(utilisateursModel::get_source_status($src,$t)!=null&&utilisateursModel::get_source_status($src,$t)==1){
        if (!$xsourcefile = file_get_contents($xSource)) { }
        else{
            $favorite=getIdOfRssSources($src,$t);
            $xml = simplexml_load_string($xsourcefile );
            $rss = new rssModel();
            $rss_date = new rssModel();
            include 'fyipanel/views/connect.php' ;
            $media="";
            $photo="";
            if ($src=='alwatanvoice') $description="";
            $d1=last_date_rss_all($favorite);
            if ($hours!=0) {
                if($signe=="+") $sig="-";  else $sig="+";
                $d_last=date("Y-m-d H:i:s", strtotime("$sig{$hours} hours", strtotime($d1)));
                $d_last=strtotime($d_last);
            }
            else{
                $d_last=strtotime($d1);
            }
            foreach ($xml->channel->item as $item) {
                $date=getrsstime($item->pubDate);
                $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date)));
                $d_insert=strtotime($date);
                $title=addslashes($item->title);
                if ($src!='alwatanvoice') {
                    $vowels = array("<p>", "</p>");
                    $description=str_replace($vowels, "", $item->description);
                    $description=addslashes($description);
                }
                $has_hashtag = strpos($item->link, '#') !== false;
                if($has_hashtag){
                    $whatIWant = substr($item->link, 0,strpos($item->link, "#") );
                    $link=addslashes($whatIWant);
                }
                else{
                    $link=addslashes($item->link);
                }
                if ($d_insert > $d_last){
                    if($date!=""&&NbnewsBytitleInLastDate($d2,$title,$favorite)==0&&addOrNot($d2)){
                        $con->exec("INSERT INTO `rss`  VALUES (NULL, '$title' , '$description','$link', '$d2', '$media',$favorite, '$photo')");

                        if($t == 'News'){
                            $n = new TopicNotification();
                            $n2 = new TopicNotification2();
                            $id = $con->lastInsertId();
                            $util = new utilisateursModel();
                            $src_row = $util->get_source_row($src);
                            $country = $src_row['country'];

                            $n->sendTopicNotification($util::source($src),$title, 'ar-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'ar');
                            $n2->sendTopicNotification2($util::source($src),$title, 'ar-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'ar');

                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   
                           

                             
                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('ar-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $util::source($src).' | '.$title, 'FYIPress',
                            $link);

                            usleep(250000);
                        }

                    }
                }
            } // foreach
        }// xsourcefile

    }
} //func

function getrsswithmedia($xSource,$src,$t,$word,$signe,$hours){
    $domain = 'https://www.fyipress.net/arabic/';
    //echo 'src : '.$src.' type : '.$t.'<br>';
    if(utilisateursModel::get_source_status($src,$t)!=null&&utilisateursModel::get_source_status($src,$t)==1){
        if (!$xsourcefile = file_get_contents($xSource)) { }else{
            $favorite=getIdOfRssSources($src,$t);
            $xml2=str_replace($word,'media', $xsourcefile);
            $photo="";
            $xml = simplexml_load_string($xml2);
            $rss = new rssModel();
            $rss_date = new rssModel();
            include 'fyipanel/views/connect.php';
            if ($src=='alwatanvoice' || $src=='alsopar') $description="";
            $d1=last_date_rss_all($favorite);
            if ($hours!=0) {
                if($signe=="+") $sig="-";  else $sig="+";
                $d_last=date("Y-m-d H:i:s", strtotime("$sig{$hours} hours", strtotime($d1)));
                $d_last=strtotime($d_last);
            }else{
                $d_last=strtotime($d1);
            }
            foreach ($xml->channel->item as $item) {
                if($src=='Anadolu Agency'){
                    $m=addslashes($item->image);
                }else if($src=='yenisafak'){
                    $m=addslashes($item->image->url);
                }else{
                    $m=addslashes($item->media["url"]);
                }

                $has_questionMark = strpos($m, '?') !== false;
                if($has_questionMark){
                    $m = substr($m, 0,strpos($m, "?") );
                }
                $m=str_replace("http://","https://",$m);

                $title=addslashes($item->title);
                if ($src!='alwatanvoice'&&$src!='alsopar'&&$src!='alblaad') {
                    $vowels = array("<p>", "</p>");
                    $description=str_replace($vowels, "", $item->description);
                    $description=addslashes($description);
                }
                if ($src=='alblaad') {
                    $vowels = array('<p dir="rtl" align=right>', "</p>");
                    $description=str_replace($vowels, "", $item->description);
                    $description=addslashes($description);
                }
                $has_hashtag = strpos($item->link, '#') !== false;
                if($has_hashtag){
                    $whatIWant = substr($item->link, 0,strpos($item->link, "#") );
                    $link=addslashes($whatIWant);
                }else{
                    $link=addslashes($item->link);
                }


                $date=getrsstime($item->pubDate);
                $d2=date("Y-m-d H:i:s", strtotime("$signe{$hours} hours", strtotime($date)));
                $d_insert=strtotime($date);
                if ($d_insert > $d_last){
                    if($date!=""&&NbnewsBytitleInLastDate($d2,$title,$favorite)==0&&addOrNot($d2)){
                        $con->exec("INSERT INTO `rss` VALUES (NULL, '$title' , '$description','$link', '$d2', '$m',$favorite, '$photo')");

                        if($t == 'News'){
                            $n = new TopicNotification();
                            $n2 = new TopicNotification2();
                            $id = $con->lastInsertId();
                            $util = new utilisateursModel();
                            $src_row = $util->get_source_row($src);
                            $country = $src_row['country'];

                            $n->sendTopicNotification($util::source($src),$title, 'ar-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'ar');
                            $n2->sendTopicNotification2($util::source($src),$title, 'ar-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $id, $link, 'ar');
                                                          
                            if (!news_publishedModel::source_not_open($src)) { 
                                $has_http = strpos($link,'http://') !== false;
                            if($has_http){
                                $link=utilisateursModel::getLink("http_link")."/iframe.php?link=".$link."&id=".$id;
                            }else{
                                $link=utilisateursModel::getLink("https_link")."/iframe.php?link=".$link."&id=".$id;
                            }  
                            }   
 
                            $fcm = new WebFCMToTopic();
                            $fcm->sendWebNoification('ar-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src), $util::source($src).' | '.$title, 'FYIPress', $link);

                            usleep(250000);
                        }
                    }
                }
            } // foreach
        }// xsourcefile
    }

} //func

try{
    require_once('models/rssModel.php');
    fill_rss_tmp();
    // without media
    //cnn 0h
    $xSource = 'https://arabic.cnn.com/api/v1/rss/rss.xml';
    $src='cnn'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //cnn 0h
    $xSource = 'https://arabic.cnn.com/api/v1/rss/sport/rss.xml';
    $src='cnn'; $t='Sports'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //aljazeera 0h
    $xSource = 'https://www.aljazeera.net/aljazeerarss/a7c186be-1baa-4bd4-9d80-a84db769f779/73d0e1b4-532f-45ef-b135-bfdff8b8cab9';
    $src='aljazeera'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //cnn 0h
    $xSource = 'https://arabic.cnn.com/api/v1/rss/tech/rss.xml';
    $src='cnn'; $t='Technology'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //alraimedia 0h
    $xSource = 'https://www.alraimedia.com/rss.aspx?id=7648e854-aa14-4351-94d0-5bbd2854b386';
    $src='alraimedia'; $t='General Culture'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //aawsat 0h
    $xSource = 'https://aawsat.com/feed/arts';
    $src='aawsat'; $t='Arts'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //aawsat 0h
    $xSource = 'https://aawsat.com/feed/sport';
    $src='aawsat'; $t='Sports'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //aawsat 0h
    $xSource = 'https://aawsat.com/feed/information-technology';
    $src='aawsat'; $t='Technology'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //v2
    $xSource = 'https://arabicpost.net/feed/';
    $src='arabicpost'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);

    $xSource = 'https://www.skynewsarabia.com/rss';
    $src='skynewsarabia'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);

 
//with media arabic
    //alwatanvoice -3h
    $xSource='https://feeds.alwatanvoice.com/ar/world.xml';
    $src='alwatanvoice';  $word='media:content';   $t='News';$signe='-';$hours=3;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //alwatanvoice -3h
    $xSource='https://feeds.alwatanvoice.com/ar/sport.xml';
    $src='alwatanvoice';  $word='media:content';   $t='Sports';$signe='-';$hours=3;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //alwatanvoice -3h
    $xSource='https://feeds.alwatanvoice.com/ar/entertainment.xml';
    $src='alwatanvoice';  $word='media:content';   $t='Arts';$signe='-';$hours=3;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //alwatanvoice -3h
    $xSource='https://feeds.alwatanvoice.com/ar/lifestyle.xml';
    $src='alwatanvoice';  $word='media:content';   $t='General Culture';$signe='-';$hours=3;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //bbc +0h
    $xSource='http://feeds.bbci.co.uk/arabic/rss.xml';
    $src='bbc';  $word='media:thumbnail';   $t='News';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //radiosawa +0h 
    //1
    $xSource='https://arabic.rt.com/rss/';
    $src='RT Arabic';  $word='enclosure';   $t='News';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //2
    $xSource='https://arabi21.com/feed';
    $src='arabi21';  $word='enclosure';   $t='News';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //3  image au lieu de enclosure url
    $xSource='https://www.aa.com.tr/ar/rss/default?cat=live';
    $src='Anadolu Agency';  $word='imagex';   $t='News';$signe='-';$hours=3;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //4
    $xSource='https://www.alarab.qa/rss';
    $src='alarab_qa';  $word='enclosure';   $t='News';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //5 image->url
    $xSource='https://www.yenisafak.com/ar/rss';
    $src='yenisafak';  $word='imagex';   $t='News';$signe='-';$hours=2;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //6
    $xSource='https://arabia.as.com/rssFeed/55';
    $src='As Arabia';  $word='media:content';   $t='Sports';$signe='-';$hours=3;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //7 desc null
    $xSource='http://www.alsopar.com/rss-action-feed-m-news-id-0-feed-rss20.xml';
    $src='alsopar';  $word='enclosure';   $t='Sports';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //8
    $xSource='http://www.alblaad.com/rss/9/%D8%B1%D9%8A%D8%A7%D8%B6%D8%A9/';
    $src='alblaad';  $word='enclosure';   $t='Sports';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //9
    $xSource='http://www.alblaad.com/rss/20/%D9%81%D9%86-%D9%88-%D8%AB%D9%82%D8%A7%D9%81%D8%A9/';
    $src='alblaad';  $word='enclosure';   $t='Arts';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //10
    $xSource='http://www.alblaad.com/rss/17/%D8%B9%D9%84%D9%88%D9%85-%D9%88-%D8%AA%D9%83%D9%86%D9%88%D9%84%D9%88%D8%AC%D9%8A%D8%A7/';
    $src='alblaad';  $word='enclosure';   $t='Technology';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //11
    $xSource='http://www.alblaad.com/rss/16/%D8%A7%D9%84%D8%B5%D8%AD%D9%87-%D9%88-%D8%A7%D9%84%D8%AC%D9%85%D8%A7%D9%84/';
    $src='alblaad';  $word='enclosure';   $t='General Culture';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
    //12
    $xSource='http://www.alblaad.com/rss/25/%D8%B9%D9%80%D8%B1%D8%A8%D9%8A-%D9%88-%D8%B9%D9%80%D8%A7%D9%84%D9%85%D9%8A/';
    $src='alblaad';  $word='enclosure';   $t='News';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);

    require_once ('ads.php');

}

catch(Exception $e){ }  ?>
 