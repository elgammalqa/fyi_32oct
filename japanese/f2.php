
<?php    

//福井新聞 -9  desc null media:thumbnail without url
//https://www.fukuishimbun.co.jp/list/feed/rss    news

//佐賀新聞 -9 desc null media:thumbnail without url
//https://www.saga-s.co.jp/list/feed/rss   sports

//イザ   -9  media:content url
//http://www.iza.ne.jp/feed/kiji/kiji-n.xml   news
 
//zakzak  -9 media:content url
//https://www.zakzak.co.jp/rss/news/politics.xml news 
//https://www.zakzak.co.jp/rss/news/sports.xml   sports
//https://www.zakzak.co.jp/rss/news/life.xml   culture

//サンケイビズ enclosure url -9
//https://www.sankeibiz.jp/rss/news/econome.xml news

//ギズモード  enclosure url -9
//https://www.gizmodo.jp/index.xml  tech

//ガジェット通信 image->original desc null gmt arts
//https://getnews.jp/feed/ext/orig 

//ログミー   enclosure url -9
//https://logmi.jp/feed/public.xml  tech
 
/*
福井新聞      news
佐賀新聞      sports
イザ           news
zakzak        news sports culture
サンケイビズ      news
ギズモード       technology
ログミー         technology
ガジェット通信 arts
*/

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
function getrsswithmedia($xSource,$src,$t,$word,$signe,$hours){

}
$xSource=''; 
 $xsourcefile = file_get_contents($xSource); 
 $xml=str_replace('enclosure','media', $xsourcefile); 
    $xml = simplexml_load_string($xml); 
      foreach ($xml->channel->item as $item) {  
     echo "title : ".$item->title."<br>"; 
     echo "description : ".$item->description."<br>";
      echo "pubDate : ".getrsstime($item->pubDate)."<br>"; ?>
      <img width="800" src="<?php echo $item->media['url']; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php  }

        //1
        $xSource = 'https://www.sankeibiz.jp/rss/news/infotech.xml';
        $src='サンケイビズ'; $word='enclosure'; $t='Technology';$signe='-';$hours=9;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
        //2
        $xSource = 'https://www.sankeibiz.jp/rss/news/life.xml';
        $src='サンケイビズ'; $word='enclosure'; $t='General Culture';$signe='-';$hours=9;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
        //3
        $xSource = 'https://www.lifehacker.jp/feed/index.xml';
        $src='ライフハッカー'; $word='enclosure'; $t='News';$signe='-';$hours=9;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
        
        //https://number.bunshun.jp/list/feed
  
    ?>