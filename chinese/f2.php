<?php
//美国之音  
//https://www.voachinese.com/api/z__yoerrvp news -8
//https://www.voachinese.com/api/zjyyveyqvr technology -8
//https://www.voachinese.com/api/zu_y_eprvt culture -8
//https://www.voachinese.com/api/z$yyretqvo sports -8
   
//BBC
//http://feeds.bbci.co.uk/zhongwen/simp/rss.xml news  media:thumbnail  gmt 
 
// 联合国新闻   arts +5
//https://news.un.org/feed/subscribe/zh/news/topic/culture-and-education/feed/rss.xml
 
//美国之音 news technology sports culture -8
//BBC news media:thumbnail gmt
//联合国新闻  culture +5
 
 //中国新闻   news arts sports culture dateok
//中国数字时代  news gmt 
//今日新聞  news gmt 
//聯合新聞網  news culture arts -8 desc null
//路透中文网 news -8 
//看中國 news culture gmt
 function getrsswithmedia($xSource,$src,$t,$word,$signe,$hours){}

$xSource=''; 
 $xsourcefile = file_get_contents($xSource); 
 $xml=str_replace('enclosure','media', $xsourcefile); 
        $xml = simplexml_load_string($xml); 
        foreach ($xml->channel->item as $item) {  
	      echo "title : ".$item->title."<br>"; 
	      echo "description : ".$item->description."<br>";
	      echo "pubDate : ".$item->pubDate."<br>"; ?>
	      <img width="800" src="<?php echo $item->media['url']; ?>"> <br>
	      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
<?php   }

	//1
	$xSource = 'https://www.rfa.org/mandarin/rss2.xml';
    $src='自由亚洲电台'; $word='media:content'; $t='News';$signe='+';$hours=0;
    getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
	