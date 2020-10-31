<?php 
	class adsrepliesModel {
		private $id;
    private $response; 
    private $media;  
    private $time;  
    private $id_ads; 
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
        public function getid_ads(){
          return $this->id_ads;
        }    
        public function getemail_user(){
          return $this->email_user;
        }   
        public function getid_comment(){
          return $this->id_comment;
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
        public function  setid_comment($value){ 
            $this->id_comment = $value; 
        }  
          
          public static function nbr_news_with_images(){
                  include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*) FROM adsreplies where media!="" ');
                   $requete->execute();
              $nb_res = $requete->fetchColumn();
              return  $nb_res ;
              }
      
        public function add_replies(){ 
          try{  include("fyipanel/views/connect.php");
      $con->exec('INSERT INTO adsreplies VALUES (NULL,"'.$this->response.'"
        ,"'.$this->media.'","'.$this->time.'",'.$this->id_ads.',"'.$this->email_user.'",'.$this->id_comment.')');
            return true;
      } catch (PDOException $e) {
         return false;
      }
    } 
 
        //all_comments
                public static function repliesStartNbres($start,$nbrs,$id_news,$id_comment){
                $tab = array();      
                include("fyipanel/views/connect.php");
                $query=$con->query("SELECT * FROM adsreplies where id_ads=".$id_news." and id_comment=".$id_comment." order by time  LIMIT ".$start.",".$nbrs);
                while ($data = $query->fetch())
                        $tab[] = $data;
                                return $tab;
                        }












 
 

             
 
 

		}
?>
		
		
		