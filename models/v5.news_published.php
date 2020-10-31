<?php  
class v5newspublished{   

  public static function getspecialfeeds($start,$nb){
    $tab = array();       
    include("fyipanel/views/connect.php"); 
    $query=$con->query("select `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
      FROM news_published  where   media=''  
      ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT  ".$start.",".$nb.""); 
    while ($data = $query->fetch())
      $tab[] = $data;
    return $tab;
  }

  public static function nbrfeeds2(){
    include("fyipanel/views/connect.php");  
    $requete = $con->prepare("select count(*) FROM news_published where media='' "); 
    $requete->execute();
    $nbrfeeds = $requete->fetchColumn();
    return  $nbrfeeds ;
  }
 

  public static function getspecialfeedsBySource($src,$start,$nb){
    $tab = array();      
    include("fyipanel/views/connect.php"); 
    $query=$con->query("select `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
      FROM news_published where type='".$src."' and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT ".$start.",".$nb.""); 
    while ($data = $query->fetch())
      $tab[] = $data;
    return $tab;
  }

 
  public static function nbrNewsBySourceindex($src){
    include("fyipanel/views/connect.php");  
    $requete = $con->prepare("select count(*) FROM news_published where  type='".$src."' and media!='' and media not like '%.pdf' and media not like '%.PDF' ");
    $requete->execute();
    $nbrfeeds = $requete->fetchColumn();
    return  $nbrfeeds ; 
  }

  public static function newsStartCountpdf(){ 
    include("fyipanel/views/connect.php");
    $tab = array();      
    $query=$con->query("SELECT * FROM news_published where (media like '%.PDF' || media like '%.pdf'  ) 
     order by pubDate desc LIMIT 10 ");
    while ($data = $query->fetch()){
      $tab[] = $data;
    }
    return $tab;  
  }

  public static function already_read_ads($id){
    include("fyipanel/views/connect.php");
    $emaill="";
    if(isset($_COOKIE['fyiuser_email'])&&isset($_COOKIE['fyiuser_email'])){
      $emaill=$_COOKIE['fyiuser_email']; 
    }else  if(isset($_SESSION['user_auth']['user_email'])&&isset($_SESSION['user_auth']['user_email'])){
      $emaill=$_SESSION['user_auth']['user_email']; 
    } 
    $requete = $con->prepare("SELECT * FROM user_ads where id=$id and email='$emaill' ");
    $requete->execute();
    if($requete->fetchColumn()!=null)  return  true ;
    else return false; 
  }

  public static function already_read($id){
    include("fyipanel/views/connect.php");
    $emaill="";
    if(isset($_COOKIE['fyiuser_email'])&&isset($_COOKIE['fyiuser_email'])){
      $emaill=$_COOKIE['fyiuser_email']; 
    }else  if(isset($_SESSION['user_auth']['user_email'])&&isset($_SESSION['user_auth']['user_email'])){
      $emaill=$_SESSION['user_auth']['user_email']; 
    } 
    $requete = $con->prepare("SELECT * FROM user_news where id=$id and email='$emaill' ");
    $requete->execute();
    if($requete->fetchColumn()!=null)  return  true ;
    else return false; 
  }
  public static function newsWithoutMedia($nb){
    include("fyipanel/views/connect.php");
    $tab=array();
    $query=$con->query("select `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
      FROM news_published  where   media=''  
      ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT ".$nb);
    while ($data = $query->fetch()){
      $tab[] = $data;
    }
    return $tab;    
  }  

  public static function  pdfcount(){
    include("fyipanel/views/connect.php");
    $requete = $con->prepare("SELECT count(*) FROM news_published 
      where (media like '%.PDF' || media like '%.pdf'  )  ");
    $requete->execute();
    $nbrss = $requete->fetchColumn();
    return  $nbrss ;
  }
  public static function nbr_news_without_images2(){
    include("fyipanel/views/connect.php");
    $requete = $con->prepare('SELECT COUNT(*) FROM news_published where media="" ');
    $requete->execute();
    $nb_res = $requete->fetchColumn();
    return  $nb_res ;
  }

  public static function getNewsRssByTypeCount($type,$s){
    include("fyipanel/views/connect.php");
    $tab=array(); 
    $query=$con->query("select `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` 
     FROM news_published  where type='".$type."' and media!='' 
     and media not like '%.pdf' and media not like '%.PDF'  
     ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT ".$s);
 
    while ($data = $query->fetch()){
      $tab[] = $data;
    }
    return $tab;  
  }  
   
  public static function add_user_news($id){ 
    include("fyipanel/views/connect.php");
    $emaill="";
    if(isset($_COOKIE['fyiuser_email'])&&isset($_COOKIE['fyiuser_email'])){
      $emaill=$_COOKIE['fyiuser_email']; 
    }else  if(isset($_SESSION['user_auth']['user_email'])&&isset($_SESSION['user_auth']['user_email'])){
      $emaill=$_SESSION['user_auth']['user_email']; 
    } 
    $requete = $con->prepare("select * from user_news where email='".$emaill."' and id='".$id."'");
    $requete->execute();
    if($requete->fetchColumn()==null) {
    $con->exec('INSERT INTO user_news VALUES ("'.$emaill.'","'.$id.'")');
    }
  }

  public static function add_user_ads($id){ 
    include("fyipanel/views/connect.php");
    $emaill="";
    if(isset($_COOKIE['fyiuser_email'])&&isset($_COOKIE['fyiuser_email'])){
      $emaill=$_COOKIE['fyiuser_email']; 
    }else  if(isset($_SESSION['user_auth']['user_email'])&&isset($_SESSION['user_auth']['user_email'])){
      $emaill=$_SESSION['user_auth']['user_email']; 
    } 
    $requete = $con->prepare("select * from user_ads where email='".$emaill."' and id='".$id."'");
    $requete->execute();
    if($requete->fetchColumn()==null) {
    $con->exec('INSERT INTO user_ads VALUES ("'.$emaill.'","'.$id.'")');
    }
  }

  public static function videos($nb){ 
    include("fyipanel/views/connect.php");
    $tab = array();       
    $query=$con->query("select `id`,`title`,`description`,`type`,`media`,`content`,`pubDate`,`thumbnail`  FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT ".$nb); 
    while ($data = $query->fetch()){
      $tab[] = $data;
    }
    return $tab;  
  } 


  public static function nbrVideos(){ 
    include("fyipanel/views/connect.php");  
    $requete = $con->prepare("select count(*) FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) ");

    $requete->execute();
    $nbrfeeds = $requete->fetchColumn();
    return  $nbrfeeds ;
  } 
 

  public static function hotnews($nb){ 
    include("fyipanel/views/connect.php");
    $tab = array();     
    $query=$con->query("select `id`,`title`,`description`,`type`,`media`,`content`,`pubDate`  from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )    ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT ".$nb); 
    while ($data = $query->fetch()){
      $tab[] = $data;
    } 
    return $tab; 
  }


  public static function typeOfMedia($str){ 
            $lastdot=strrpos($str,".");//
        $length=strlen($str);//
        $type=substr ($str,$lastdot+1, $length-$lastdot+1); 
        if ($type=="jpg"||$type=="JPG"||$type=="jpeg"||$type=="JPEG"||$type=="png"||$type=="PNG"||$type=="gif"||$type=="GIF") {  
          $media="image";
        }else  if ($type=="mp4"||$type=="webm"||$type=="flv"||$type=="mkv"||$type=="mpeg"
          ||$type=="MP4"||$type=="WEBM"||$type=="FLV"||$type=="MKV"||$type=="MPEG") { 
          $media="video"; 
        }  
        return $media;
      }
      public static function ads(){
        include("fyipanel/views/connect.php");
        $tab=array();
        $query=$con->query("SELECT * FROM ads order by pubDate desc ");
        while ($data = $query->fetch()){
          $tab[] = $data;
        }
        return $tab;  
      } 

      public static function timToContinue(){
       include 'fyipanel/views/connect.php';
       $requete = $con->prepare('select numberofs from settings where id=2');
       $requete->execute();
       $nb = $requete->fetchColumn();
       return $nb;  
     }

     public static function nbr_ads2(){
      include("fyipanel/views/connect.php");   
      $requete = $con->prepare('select count(*) from ads ');
      $requete->execute();
      $id = $requete->fetchColumn();
      return  $id ; 

    }

    public static function NbreNewsToShow(){ 
     include 'fyipanel/views/connect.php';
     $requete = $con->prepare('select numberofs from settings where id=1');
     $requete->execute();
     $nb = $requete->fetchColumn();
     return $nb;   
   }


   public static function nbrhotnews(){ 
    include("fyipanel/views/connect.php");   
    $requete = $con->prepare("select count(*) from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png'   || media like '%.JPEG' || media like '%.PNG'  || media like '%.JPG' )  "); 
    $requete->execute();
    $nbrfeeds = $requete->fetchColumn();
    return  $nbrfeeds ;
  }


  public static function NewsToShow($nb){  
    include("fyipanel/views/connect.php");  
    $tab=array();     
    $query=$con->query("select id,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` FROM news_published where media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT ".$nb);
    while ($data = $query->fetch()){
     $tab[] = $data;
   }
   return $tab;  
 } 




}