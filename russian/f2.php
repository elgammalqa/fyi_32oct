<?php  
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
$xSource=''; 
 $xsourcefile = file_get_contents($xSource); 
    $xml = simplexml_load_string($xsourcefile ); 
      foreach ($xml->channel->item as $item) {  
     echo "title : ".$item->title."<br>"; 
     echo "description : ".$item->description."<br>";
      echo "pubDate : ".getrsstime($item->pubDate)."<br>"; ?>
      <img width="800" height="500" src="<?php echo $item->enclosure['url']; ?>"> <br>
      <a href="<?php echo $item->link; ?>">link</a> <br><br><br>
      <?php  }

      /*
       
         //1
        $xSource = 'https://www.vedomosti.ru/rss/rubric/politics';
        $src='ВЕДОМОСТИ'; $word='enclosure'; $t='News';$signe='-';$hours=3;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
         //2
        $xSource = 'https://www.vedomosti.ru/rss/rubric/lifestyle';
        $src='ВЕДОМОСТИ'; $word='enclosure'; $t='General Culture';$signe='-';$hours=3;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours);
         //3
        $xSource = 'https://vm.ru/rss/';
        $src='Вечерняя Москва'; $word='enclosure'; $t='News';$signe='-';$hours=3;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
         //4
        $xSource = 'https://www.dp.ru/rss';
        $src='Деловой Петербург'; $word='enclosure'; $t='News';$signe='-';$hours=3;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
        //5
        $xSource = 'http://portal-kultura.ru/rss/';
        $src='Культура'; $word='enclosure'; $t='Arts';$signe='-';$hours=3;
        getrsswithmedia($xSource,$src,$t,$word,$signe,$hours); 
 
      */ 
   
  //  echo '<pre>';  print_r($xml);   echo '</pre>';
  //https://rg.ru/xml/index.xml sports and news all  images not in all 
    ?>