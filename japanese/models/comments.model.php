<?php 
	class commentsModel {
		private $id;
    private $response; 
    private $media;  
    private $time;  
    private $id_news; 
    private $email_user;  
        
        //getters
        public function getid()
        {
                return $this->id;
            } 
    		public function getresponse(){
    			return $this->response;
    		} 	 
        public function getmedia(){
          return $this->media;
        } 
        public function gettime(){
          return $this->time;
        }
        public function getid_news(){
          return $this->id_news;
        }    
        public function getemail_user(){
          return $this->email_user;
        } 




        /* setters 	*/ 
    		public function setid($value){
    			if(!empty($value))
    				$this->id = $value;
    	
    		} 
    		public function  setresponse($value){
    			if(!empty($value))
    				$this->response = $value;
    			
    			
    		} 

          public function setmedia($value){
          if(!empty($value))
            $this->media = $value; 
            }

          public function settime($value){
          if(!empty($value))
            $this->time = $value; 
            }

        public function setid_news($value){
          if(!empty($value))
            $this->id_news = $value; 
        } 
        public function  setemail_user($value){
          if(!empty($value))
            $this->email_user = $value; 
        }  
          
          
 










 



         //v5
public static function rss_countTotalOfComments($id_news){
  include("fyipanel/views/connect.php");
  $requete = $con->prepare('SELECT COUNT(*)  FROM rss_comments where id_news='.$id_news);
  $requete->execute();
  $nb_res = $requete->fetchColumn();
  $rek = $con->prepare('SELECT COUNT(*)  FROM rss_replies where id_news='.$id_news);
  $rek->execute();
  $nb_res2 = $rek->fetchColumn();
  $c=$nb_res+$nb_res2;
  return  $c ;
}

public static function nbHotNewsRss($id_news){
  include("fyipanel/views/connect.php");
  $hotnews=0;
  $requete = $con->prepare('SELECT COUNT(*)  FROM rss_comments where id_news='.$id_news.' and media="" ');
  $requete->execute();
  $nb_res = $requete->fetchColumn();
  $hotnews+=$nb_res;

  $requete = $con->prepare('SELECT COUNT(*)  FROM rss_replies where id_news='.$id_news.' and media="" ');
  $requete->execute();
  $nb_res = $requete->fetchColumn();
  $hotnews+=$nb_res; 
  $hotnews=ceil($hotnews/3)*2;

  $hotnews2=0;
  $requete = $con->prepare('SELECT COUNT(*)  FROM rss_comments where id_news='.$id_news.' and media!="" ');
  $requete->execute();
  $nb_res2 = $requete->fetchColumn();
  $hotnews2+=($nb_res2*2);
 
  $requete = $con->prepare('SELECT COUNT(*)  FROM rss_replies where id_news='.$id_news.' and media!="" ');
  $requete->execute();
  $nb_res2 = $requete->fetchColumn();
  $hotnews2+=($nb_res2*2); 
  return  $hotnews+$hotnews2 ;
} 
 



public static function rss_commentsStartNbres($start,$nbrs,$id){
  $tab = array();      
  include("fyipanel/views/connect.php");
  $query=$con->query("SELECT * FROM rss_comments where id_news=".$id."  order by time DESC LIMIT ".$start.",".$nbrs);
  while ($data = $query->fetch())
    $tab[] = $data;
  return $tab;
}

public static function rss_HisComment($id,$email){
  include("fyipanel/views/connect.php");
  $requete = $con->prepare('SELECT email_user FROM rss_comments where id='.$id);
  $requete->execute();
  $emailusers = $requete->fetchColumn();
  if ($emailusers==$email) {
    return true;
  }else{
    return false;
  }

}

public static function rss_HisReply($id,$email){
  include("fyipanel/views/connect.php");
  $requete = $con->prepare('SELECT email_user FROM rss_replies where id='.$id);
  $requete->execute();
  $emailusers = $requete->fetchColumn();
  if ($emailusers==$email) {
    return true;
  }else{
    return false;
  }

} 

 public static function rss_nbr_news_with_images(){
  include("fyipanel/views/connect.php");
  $requete = $con->prepare('SELECT COUNT(*) FROM rss_comments where media!="" ');
  $requete->execute();
  $nb_res = $requete->fetchColumn();
  return  $nb_res ;
}
 
public function rss_add_comments(){
  try{
    include("fyipanel/views/connect.php");
    $con->exec('INSERT INTO rss_comments VALUES (NULL,"'.$this->response.'"
      ,"'.$this->media.'","'.$this->time.'",'.$this->id_news.',"'.$this->email_user.'")');
    return true;
  } catch (PDOException $e) {
   return false;
 }
} 


        public static function comment_already_reported($id,$email){ 
            include("fyipanel/views/connect.php");
            $requete = $con->prepare('SELECT id FROM report where id_comment='.$id.' and 
              (email_user_report="'.$email.'")');
            $requete->execute();
            $mail = $requete->fetchColumn();
            if($mail!=null){    return true;
            }else{ return false; } 
        } 
  
        public static function reply_already_reported($id,$email){ 
            include("fyipanel/views/connect.php");
            $requete = $con->prepare('SELECT id FROM report where id_reply='.$id.' and 
              (email_user_report="'.$email.'")');
            $requete->execute();
            $mail = $requete->fetchColumn();
            if($mail!=null){    return true;
            }else{ return false; } 
        } 

        public static function rss_comment_already_reported($id,$email){ 
            include("fyipanel/views/connect.php");
            $requete = $con->prepare('SELECT id FROM rss_report where id_comment='.$id.' and 
              (email_user_report="'.$email.'")');
            $requete->execute();
            $mail = $requete->fetchColumn();
            if($mail!=null){    return true;
            }else{ return false; } 
        } 
 
        public static function rss_reply_already_reported($id,$email){ 
            include("fyipanel/views/connect.php");
            $requete = $con->prepare('SELECT id FROM rss_report where id_reply='.$id.' and 
              (email_user_report="'.$email.'")');
            $requete->execute();
            $mail = $requete->fetchColumn();
            if($mail!=null){    return true;
            }else{ return false; } 
        } 







































  
        // add comments
        public function add_comments(){
          try{
          include("fyipanel/views/connect.php");
      $con->exec('INSERT INTO comments VALUES (NULL,"'.$this->response.'"
        ,"'.$this->media.'","'.$this->time.'",'.$this->id_news.',"'.$this->email_user.'")');
            return true;
      } catch (PDOException $e) {
         return false;
      }
    } 

     // add comments
        public static function delete_ReportsAndrepliesAndComments($id_c){ 
          include("fyipanel/views/connect.php");
          $c=false;  
          $requete = $con->prepare('SELECT count(*) FROM comments where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) {
                 $con->exec('DELETE FROM comments where id='.$id_c);
                 $c=true;
                } 
          return  $c;
       } 
 

  // add comments
public static function delete_replies_ad($id_c){ 
  include("../views/connect.php");
  $c=false;  
  $requete = $con->prepare('SELECT count(*) FROM replies where id='.$id_c);
  $requete->execute();
  $nbr_comments = $requete->fetchColumn();
  if ($nbr_comments>0) {  
         //v6 delete media
          $requete = $con->prepare('SELECT media FROM replies where id='.$id_c);
          $requete->execute();
          $media = $requete->fetchColumn();
          if($media!=null) unlink('../../images/replies/'.$media);
          // 
   $con->exec('DELETE FROM replies where id='.$id_c);
   $c=true;
 } 
 return  $c;
} 
 

       // add comments
        public static function delete_ReportsAndreplies($id_c){ 
          include("fyipanel/views/connect.php");
          $c=false; 
          $requete = $con->prepare('SELECT count(*) FROM replies where id='.$id_c);
          $requete->execute();
          $nbr_replies = $requete->fetchColumn();
                if ($nbr_replies>0) {
                 $con->exec('DELETE FROM replies where id='.$id_c);
                   $c=true;
                } 
          return  $c;
       } 



           // add comments
public static function delete_Comments_ad($id_c){ 
  include("../views/connect.php");
  $c=false;  
  $requete = $con->prepare('SELECT count(*) FROM comments where id='.$id_c);
  $requete->execute();
  $nbr_comments = $requete->fetchColumn();
  if ($nbr_comments>0) {
         //v6 delete media
          $requete = $con->prepare('SELECT media FROM comments where id='.$id_c);
          $requete->execute();
          $media = $requete->fetchColumn();
          if($media!=null) unlink('../../images/comments/'.$media);
          // 
   $con->exec('DELETE FROM comments where id='.$id_c);
   $c=true;
 } 
 return  $c;
} 

        // add comments
        public static function delete_Reports($id_c){ 
          include("../views/connect.php");
          $c=false; 
          $requete = $con->prepare('SELECT count(*) FROM report where id='.$id_c);
          $requete->execute();
          $nbr_replies = $requete->fetchColumn();
                if ($nbr_replies>0) {
                 $con->exec('DELETE FROM report where id='.$id_c);
                   $c=true;
                } 
          return  $c;
       } 
 

  // count of news without images
            public static function nbr_news_with_images(){
                  include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*) FROM comments where media!="" ');
                   $requete->execute();
              $nb_res = $requete->fetchColumn();
              return  $nb_res ;
              }

               // count of news without images
            public static function HisComment($id,$email){
                  include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT email_user FROM comments where id='.$id);
              $requete->execute();
              $emailusers = $requete->fetchColumn();
              if ($emailusers==$email) {
                return true;
              }else{
                return false;
              }
              
              }

                 // count of news without images
            public static function HisReply($id,$email){
                  include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT email_user FROM replies where id='.$id);
              $requete->execute();
              $emailusers = $requete->fetchColumn();
              if ($emailusers==$email) {
                return true;
              }else{
                return false;
              }
              
              }


               // count of news without images
            public static function countTotalOfComments($id_news){
              include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*)  FROM comments where id_news='.$id_news);
              $requete->execute();
              $nb_res = $requete->fetchColumn();
              $rek = $con->prepare('SELECT COUNT(*)  FROM replies where id_news='.$id_news);
              $rek->execute();
              $nb_res2 = $rek->fetchColumn();
              $c=$nb_res+$nb_res2;
              return  $c ;
              }

                //all_comments
                public static function commentsStartNbres($start,$nbrs,$id){
                $tab = array();      
                include("fyipanel/views/connect.php");
                $query=$con->query("SELECT * FROM comments where id_news=".$id."  order by time DESC LIMIT ".$start.",".$nbrs);
                while ($data = $query->fetch())
                        $tab[] = $data;
                                return $tab;
                        }
 


               // get first and last name
            public static function nameReporter2($email){
                  include("fyipanel/views/connect.php");
             $requete = $con->prepare('SELECT  name
             FROM utilisateurs where email="'.$email.'"');
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ;
              }

               //get  typeOfMedia
            public static function typeOfMedia($str){ 
            $lastdot=strrpos($str,".");//
        $length=strlen($str);//
          $type=substr ($str,$lastdot+1, $length-$lastdot+1); 
          if ($type=="jpg"||$type=="JPG"||$type=="jpeg"||$type=="JPEG"||$type=="png"||$type=="PNG"||$type=="gif"||$type=="GIF") {  
            $media="image";
            }else  if ($type=="mp4"||$type=="webm"||$type=="flv"||$type=="mkv"||$type=="mpeg"
              ||$type=="MP4"||$type=="WEBM"||$type=="FLV"||$type=="MKV"||$type=="MPEG") { 
            $media="video"; 
              }else  if ($type=="mp3"||$type=="AC-3"||$type=="MP3"||$type=="ac-3") { 
                $media="audio";
        }
        return $media;
        }

		}
?>
		
		
		