
<?php      
// -9 tdlp   ニフティ ニュース
//  https://news.nifty.com/rss/topics_world.xml mews
 // https://news.nifty.com/rss/topics_technology.xml tech 
//https://news.nifty.com/rss/topics_sports.xml sports
//サンスポ  -9
//https://www.sanspo.com/rss/chumoku/news/allsports-n.xml  sports
//財経新聞 -9
//http://www.zaikei.co.jp/rss/sections/it.xml tech
//秋田 -9
//http://feeds.feedburner.com/akita_news   news
//日本新聞協会 -9
//https://www.pressnet.or.jp/feed/headline.xml    news
//WIRED -9
//https://wired.jp/rssfeeder/ tech

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
function getrssfromsource($xSource,$src,$t,$signe,$hours){}


$xSource='https://horror2.jp/feed';
 $xsourcefile = file_get_contents($xSource); 
    $xml = simplexml_load_string($xsourcefile ); 
    foreach ($xml->channel->item as $item) {  
        echo "pubDate : ".getrsstime($item->pubDate)."<br>";   
        echo "title : ".$item->title."<br>";   
        echo "description : ".$item->description."<br>";  
        echo "link : ".$item->link."<br><br><br>"; 
    }   

    	//1
        $xSource = 'https://www.iwanichi.co.jp/feed/';
        $src='岩手日日'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    	//2
        $xSource = 'https://www.kyodo.co.jp/feed/';
        $src='KYODO'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
    	//3
        $xSource = 'http://www.nankainn.com/feed';
        $src='南海日日新聞'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);  
        //4 already exist in rss sources
        $xSource = 'https://www.sanspo.com/rss/flash/news/flash-n.xml';
        $src='サンスポ'; $t='News'; $signe='-';$hours=9;
        getrssfromsource($xSource,$src,$t,$signe,$hours); 
    	//5
        $xSource = 'http://rss.shikoku-np.co.jp/rss/flash.aspx';
        $src='四国新聞社'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    	//6
        $xSource = 'https://ubenippo.co.jp/feed/';
        $src='宇部日報'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
    	//7
        $xSource = 'https://www.tokyo-sports.co.jp/feed/';
        $src='東スポWeb'; $t='Sports'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);
        //8
        $xSource = 'http://www.zaikei.co.jp/rss/sections/life.xml';
        $src='財経新聞'; $t='General Culture'; $signe='-';$hours=9;
        getrssfromsource($xSource,$src,$t,$signe,$hours);  
        //9
        $xSource = 'https://otajo.jp/feed';
        $src='オタ女'; $t='News'; $signe='+';$hours=0;
        getrssfromsource($xSource,$src,$t,$signe,$hours);

 
 		

    ?>