<?php    
require_once('models/utilisateurs.model.php'); 
require_once('fyipanel/models/news_published.model.php');

  function sources()  { 
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("select * from rss_sources where id  between 1 and 100 group by source order by id");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;  
    } 
  
    function news($id){  
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("select distinct * from rss where favorite='".$id."' LIMIT 3");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab; 
    }    
  
    $variable=sources(); 
    foreach ($variable as $key => $value) {
    	 echo '<pre>id = '.$value['id'].'&#9;&#9;&#9;source = '.$value['source'].'&#9;&#9;&#9;type = '.$value['type'].'&#9;&#9;&#9;tw = '.$value['twitter'].'<br></pre>';
    	  $news=news($value['id']); 

    foreach ($news as $key => $v) {   
        $url=$v['link']; 
        $has_hashtag = strpos($url, '#') !== false;
        if($has_hashtag){
            $url = substr($url, 0,strpos($url, "#") );
        }   
        $link = "http://localhost/fyi8/project/russian/iframe2.php?link=".stripslashes($url)."&id=".$v['id'];
    	echo '<pre> <a target="_blank" href="'.$v['link'].'" > '.$v['title'].'</a><br></pre>';
    	echo '<pre> <a target="_blank" href="'.$link.'" > '.$link.'</a><br><br></pre>';
    }
    }
      
 ?>