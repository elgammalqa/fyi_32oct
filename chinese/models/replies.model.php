<?php 
	class repliesModel {
		private $id;
    private $response; 
    private $media;  
    private $time;  
    private $id_news; 
    private $email_user; 
    private $id_comment;  
        
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
        public function getid_comment(){
          return $this->id_comment;
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
        //  if(!empty($value))
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
        public function  setid_comment($value){
          if(!empty($value))
            $this->id_comment = $value; 
        }  




        //v5
public static function rss_repliesStartNbres($start,$nbrs,$id_news,$id_comment){
  $tab = array();      
  include("fyipanel/views/connect.php");
  $query=$con->query("SELECT * FROM rss_replies where id_news=".$id_news." and id_comment=".$id_comment." order by time  LIMIT ".$start.",".$nbrs);
  while ($data = $query->fetch())
    $tab[] = $data;
  return $tab;
}

public function rss_add_replies(){
  try{
    include("fyipanel/views/connect.php");
    $con->exec('INSERT INTO rss_replies VALUES (NULL,"'.$this->response.'"
      ,"'.$this->media.'","'.$this->time.'",'.$this->id_news.',"'.$this->email_user.'",'.$this->id_comment.')');
    return true;
  } catch (PDOException $e) {
   return false;
 }
} 

public static function rss_nbr_news_with_images(){
  include("fyipanel/views/connect.php");
  $requete = $con->prepare('SELECT COUNT(*) FROM rss_replies where media!="" ');
  $requete->execute();
  $nb_res = $requete->fetchColumn();
  return  $nb_res ;
}











 
        // add comments
        public function add_replies(){ 
          try{
          include("fyipanel/views/connect.php");
      $con->exec('INSERT INTO replies VALUES (NULL,"'.$this->response.'"
        ,"'.$this->media.'","'.$this->time.'",'.$this->id_news.',"'.$this->email_user.'",'.$this->id_comment.')');
            return true;
      } catch (PDOException $e) {
         return false;
      }
    } 

  // count of news without images
            public static function nbr_news_with_images(){
                  include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*) FROM replies where media!="" ');
                   $requete->execute();
              $nb_res = $requete->fetchColumn();
              return  $nb_res ;
              }

               //all_comments
                public static function repliesStartNbres($start,$nbrs,$id_news,$id_comment){
                $tab = array();      
                include("fyipanel/views/connect.php");
                $query=$con->query("SELECT * FROM replies where id_news=".$id_news." and id_comment=".$id_comment." order by time  LIMIT ".$start.",".$nbrs);
                while ($data = $query->fetch())
                        $tab[] = $data;
                                return $tab;
                        }


 
 

		}
?>
		
		
		