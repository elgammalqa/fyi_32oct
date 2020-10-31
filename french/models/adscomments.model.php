<?php 
	class adscommentsModel {
		private $id;
    private $response; 
    private $media;  
    private $time;  
    private $id_ads;  
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
        public function getid_ads(){
          return $this->id_ads;
        }    
        public function getemail_user(){
          return $this->email_user;
        } 




        /* setters 	*/ 
    		public function setid($value){ 
    				$this->id = $value;
    	
    		} 
    		public function  setresponse($value){ 
    				$this->response = $value;
    			
    			
    		} 

          public function setmedia($value){ 
            $this->media = $value; 
            }

          public function settime($value){ 
            $this->time = $value; 
            }

        public function setid_ads($value){ 
            $this->id_ads = $value; 
        } 
        public function  setemail_user($value){ 
            $this->email_user = $value; 
        }  
            







             
        //v5
        public static function ads_comment_already_reported($id,$email){ 
            include("fyipanel/views/connect.php");
            $requete = $con->prepare('SELECT id FROM adsreport where id_comment='.$id.' and 
              (email_user_report="'.$email.'")');
            $requete->execute();
            $mail = $requete->fetchColumn();
            if($mail!=null){    return true;
            }else{ return false; } 
        } 
  
        public static function ads_reply_already_reported($id,$email){ 
            include("fyipanel/views/connect.php");
            $requete = $con->prepare('SELECT id FROM adsreport where id_reply='.$id.' and 
              (email_user_report="'.$email.'")');
            $requete->execute();
            $mail = $requete->fetchColumn();
            if($mail!=null){    return true;
            }else{ return false; } 
        }  

























               // count of news without images
            public static function countTotalOfComments($id_news){
              include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*)  FROM adscomments where id_ads='.$id_news);
              $requete->execute();
              $nb_res = $requete->fetchColumn();
              $rek = $con->prepare('SELECT COUNT(*)  FROM adsreplies where id_ads='.$id_news);
              $rek->execute();
              $nb_res2 = $rek->fetchColumn();
              $c=$nb_res+$nb_res2;
              return  $c ;
              }

                 //all_comments
                public static function commentsStartNbres($start,$nbrs,$id){
                $tab = array();      
                include("fyipanel/views/connect.php");
                $query=$con->query("SELECT * FROM adscomments where id_ads=".$id."  order by time DESC LIMIT ".$start.",".$nbrs);
                while ($data = $query->fetch())
                        $tab[] = $data;
                                return $tab;
                        }
  
   // count of news without images
            public static function HisComment($id,$email){
                  include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT email_user FROM adscomments where id='.$id);
              $requete->execute();
              $emailusers = $requete->fetchColumn();
              if ($emailusers==$email) {
                return true;
              }else{
                return false;
              }
              
              }

             public static function nbr_news_with_images(){
                  include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*) FROM adscomments where media!="" ');
                   $requete->execute();
              $nb_res = $requete->fetchColumn();
              return  $nb_res ;
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
         // add comments
        public function add_comments(){
          try{
          include("fyipanel/views/connect.php");
      $con->exec('INSERT INTO adscomments VALUES (NULL,"'.$this->response.'"
        ,"'.$this->media.'","'.$this->time.'",'.$this->id_ads.',"'.$this->email_user.'")');
            return true;
      } catch (PDOException $e) {
         return false;
      }
    } 

    public static function HisReply($id,$email){
                  include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT email_user FROM adsreplies where id='.$id);
              $requete->execute();
              $emailusers = $requete->fetchColumn();
              if ($emailusers==$email) {
                return true;
              }else{
                return false;
              }
              
              } 

    
      public static function delete_Comments_ad($id_c){ 
          include("../views/connect.php");
          $c=false;  
          $requete = $con->prepare('SELECT count(*) FROM adscomments where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) {
                  //v6 delete media
                  $requete = $con->prepare('SELECT media FROM adscomments where id='.$id_c);
                  $requete->execute();
                  $media = $requete->fetchColumn();
                  if($media!=null) unlink('../../ads/comments/'.$media);
                  // 
                 $con->exec('DELETE FROM adscomments where id='.$id_c);
                 $c=true;
                }  
          return  $c;
       } 
 
       public static function delete_replies_ad($id_c){ 
          include("../views/connect.php");
          $c=false;  
          $requete = $con->prepare('SELECT count(*) FROM adsreplies where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) { 
                  //v6 delete media
                  $requete = $con->prepare('SELECT media FROM adsreplies where id='.$id_c);
                  $requete->execute();
                  $media = $requete->fetchColumn();
                  if($media!=null) unlink('../../ads/replies/'.$media);
                  // 
                 $con->exec('DELETE FROM adsreplies where id='.$id_c);
                 $c=true;
                } 
          return  $c;
       }  

        public static function delete_Reports($id_c){ 
          include("../views/connect.php");
          $c=false; 
          $requete = $con->prepare('SELECT count(*) FROM adsreport where id='.$id_c);
          $requete->execute();
          $nbr_replies = $requete->fetchColumn();
                if ($nbr_replies>0) {
                 $con->exec('DELETE FROM adsreport where id='.$id_c);
                   $c=true;
                } 
          return  $c;
       } 
























       

     // add comments
        public static function delete_ReportsAndrepliesAndComments($id_c){ 
          include("fyipanel/views/connect.php");
          $c=false;  
          $requete = $con->prepare('SELECT count(*) FROM adscomments where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) {
                 $con->exec('DELETE FROM adscomments where id='.$id_c);
                 $c=true;
                } 
          return  $c;
       }  
  

       // add comments
        public static function delete_ReportsAndreplies($id_c){ 
          include("fyipanel/views/connect.php");
          $c=false; 
          $requete = $con->prepare('SELECT count(*) FROM adsreplies where id='.$id_c);
          $requete->execute();
          $nbr_replies = $requete->fetchColumn();
                if ($nbr_replies>0) {
                 $con->exec('DELETE FROM adsreplies where id='.$id_c);
                   $c=true;
                } 
          return  $c;
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

              

		}
?>
		
		
		