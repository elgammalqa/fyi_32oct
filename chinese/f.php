<?php 
    //中国新闻
//http://www.chinanews.com/rss/world.xml tdlp   news  2018-11-11 15:23:11 
//http://www.chinanews.com/rss/culture.xml tdlp   arts  2018-11-11 15:23:11 
//http://www.chinanews.com/rss/sports.xml  tdlp   sports  2018-11-11 15:23:11 
//http://www.chinanews.com/rss/life.xml tdlp culture 2018-11-11 15:23:11 
   
        //中国数字时代 
//https://chinadigitaltimes.net/chinese/category/level-2-article/feed/ tdlp news gmt
   
           //今日新聞 
//https://www.nownews.com/rss/ tdlp gmt news 
 
//中国新闻   news arts sports culture dateok
//中国数字时代  news gmt 
//今日新聞  news gmt
//聯合新聞網  news culture arts -8 desc null

// 聯合新聞網   tlp desc null  -8
//https://udn.com/rssfeed/news/2/6638?ch=news    news
//https://udn.com/rssfeed/news/2/6649?ch=news   culture 
//https://udn.com/rssfeed/news/2/6649?ch=news   arts
 
//路透中文网
//https://cn.reuters.com/rssFeed/   news -8

 
//看中國  gmt
//https://www.secretchina.com/news/gb/p9.xml news
//https://www.secretchina.com/news/gb/p7.xml culture 

 function getrssfromsource($xSource,$src,$t,$signe,$hours){}

  function getrsstime2($d) 
{  
    if($d!=""){
    $d=trim($d);
    $parts=explode('T',$d);   
    $year=$parts[0];  
    $minutes=$parts[1];  
    $time=explode('Z',$minutes);  
    $date="$year $time[0]"; 
     return $date;
 }else{ 
     return "";
 }
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

//
$xSource='';
 $xsourcefile = file_get_contents($xSource); 
    $xml = simplexml_load_string($xsourcefile);  
   // $xml=str_replace('dc:date','pubDate', $xml2);  
    foreach ($xml->channel->item as $item) {  
    //foreach ($xml->item as $item) {   
        $dc = $item->children('http://purl.org/dc/elements/1.1/'); 
        echo "pubDate : ".getrsstime($item->pubDate)."<br>";   
        echo "title : ".$item->title."<br>";   
        echo "description : ".$item->description."<br>";  ?>
        <a href="<?php echo $item->link ?>">link</a><br>  
        <?php
    } 
    /*
   
   //1
    $xSource = 'https://theinitium.com/newsfeed/';
    $src='端傳媒'; $t='News'; $signe='-';$hours=8;
    getrssfromsource($xSource,$src,$t,$signe,$hours); 
    //4
    $xSource = 'https://china.kyodonews.net/rss/news.xml';
    $src='共同网'; $t='News'; $signe='-';$hours=9;
    getrssfromsource($xSource,$src,$t,$signe,$hours);  
    //5
    $xSource = 'https://zh.cn.nikkei.com/rss.html';
    $src='日經中文網'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //6 exist 
    $xSource = 'https://cn.reuters.com/rssFeed/chinaNews/';
    $src='路透中文网'; $t='Technology'; $signe='-';$hours=8;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //7 exist 
    $xSource = 'http://cn.reuters.com/rssFeed/CNEntNews';
    $src='路透中文网'; $t='Sports'; $signe='-';$hours=8;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
        //8 exist 
    $xSource = 'http://cn.reuters.com/rssFeed/vbc_livestyle_landing/';
    $src='路透中文网'; $t='General Culture'; $signe='-';$hours=8;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //9
    $xSource = 'http://jiaren.org/feed/';
    $src='佳人'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //10 nnnnnnnnnnnnnnn
    $xSource = 'http://www.dxy.cn/bbs/rss/2.0/all.xml'; 
    //11
    $xSource = 'https://www.appinn.com/feed/';
    $src='小众软件'; $t='Technology'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //12
    $xSource = 'https://rsshub.app/eeo/17';
    $src='经济观察网'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //13
    $xSource = 'http://www.4sbooks.com/feed';
    $src='四季书评'; $t='General Culture'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //14
    $xSource = 'https://sobooks.cc/feed';
    $src='SoBooks'; $t='General Culture'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //15
    $xSource = 'https://epubw.com/feed';
    $src='ePUBw'; $t='General Culture'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //16
    $xSource = 'http://www.qijieshuzhai001.com/?feed=rss2';
    $src='七街书斋'; $t='General Culture'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    
    






    /* v7
    //foreach ($xml->item as $item) {
    //2019-08-16T15:37:25Z
    $dc = $item->children('http://purl.org/dc/elements/1.1/'); 
    echo "pubDate : ".getrsstime2($dc->date)."<br>";   

    //2
    $xSource = 'http://rss.dw.com/rdf/rss-chi-cul';
    $src='德国之声'; $t='General Culture'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //3
    $xSource = 'http://rss.dw.com/rdf/rss-chi-sci';
    $src='德国之声'; $t='Technology'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours); 

    //v3
    //1
    $xSource = 'http://haijiaoshi.com/feed';
    $src='海交史'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours); 
    //2
    $xSource = 'https://storystudio.tw/feed/';
    $src='故事'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //3
    $xSource = 'https://plausistory.blog/feed/';
    $src='清言'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    //4
    $xSource = 'http://southasiawatch.tw/feed';
    $src='南亞觀察'; $t='News'; $signe='+';$hours=0;
    getrssfromsource($xSource,$src,$t,$signe,$hours);
    
    */  

    //http://bbs.gxsd.com.cn/forum.php?mod=rss&auth=0
    
    //https://doyj.com/feed/ xx  
   // echo '<pre>';  print_r($xml);   echo '</pre>';


 
    ?>