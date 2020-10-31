<?php 
	class newsModel {
		private $id;
		private $title; 
		private $description;
		private $type; 
		private $media; 
		private $content; 
		private $pubDate;
    private $employee;
    private $status;
    private $thumbnail;
        
        //getters
        public function getid()
        {
                return $this->id;
        } 
		public function gettitle(){
			return $this->title;
		} 	
		public function getdescription(){
			return $this->description;
		} 
		public function gettype(){
			return $this->type;
		} 
		public function getmedia(){
			return $this->media;
		} 	
		public function getcontent(){
			return $this->content;
		} 		
		public function getpubDate(){
			return $this->pubDate;
		} 	
 	    public function getemployee(){
			return $this->employee;
        }
 	    public function getstatus(){
			return $this->status;
        }
      public function getthumbnail(){
      return $this->thumbnail;
        }
         
        /* setters 	*/ 
		public function setid($value){ 
				$this->id = $value; 
		} 
		public function settitle($value){ 
				$this->title = $value; 
        	}
		public function setdescription($value){ 
				$this->description = $value;
			
		}
		public function settype($value){ 
				$this->type = $value;
			
		}
		public function setmedia($value){ 
				$this->media = $value;
			
		}
        public function setcontent($value){ 
				$this->content = $value;
			
        }
        public function setpubDate($value){ 
				$this->pubDate = $value;
			
        }
        
        public function setemployee($value){ 
				$this->employee = $value;
			
        }

         public function setstatus($value){ 
				$this->status = $value;
			 
        }
 
         public function setthumbnail($value){  
        $this->thumbnail = $value;
      
        }
           // all 
    public function newsSentOrWrittenByHeadOfBranch($email){ 
      include("../views/connect.php");
            $tab = array();      
            $query=$con->query('select * from news where employee="'.$email.'" and (status=1 or status=-1) order by pubDate desc');
            while ($data = $query->fetch()){
              $tab[] = $data;
            }
              return $tab; 
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
              }else  if ($type=="pdf"||$type=="PDF" ) { 
                $media="pdf";
				}
				return $media;
		    }

        public function add_news(){
            try {
                include("../views/connect.php");
                $con->exec('INSERT INTO news  VALUES (null,"'.$this->title.'","'.$this->description.'","'.
                    $this->type.'","'.$this->media.'","'.$this->content.'","'.$this->pubDate.'","'.$this->employee.'",0,"'.$this->thumbnail.'", 0)');
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function add_news2(){
            try {
                include("../views/connect.php");
                $con->exec('INSERT INTO news  VALUES (null,"'.$this->title.'","'.$this->description.'","'.
                    $this->type.'","'.$this->media.'","'.$this->content.'","'.$this->pubDate.'","'.$this->employee.'",1,"'.$this->thumbnail.'", 0)');
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

         
            //  
        public function update_news($id){
        try {
          include("../views/connect.php"); 
			  $con->exec('UPDATE news  set title="'.$this->title.'",description="'.$this->description.'",type="'.$this->type.'",media="'.$this->media.'",content="'.$this->content.'" ,thumbnail="'.$this->thumbnail.'" where id='.$id);
			  return true;
			} catch (PDOException $e) {
			   return false;
			} 
          
          }
          
          //   
          public static function last_id(){
          include("../views/connect.php");   
			    $requete = $con->prepare('select max(id) from news ');
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ; 
          
          }

          public static function get_media_by_id($id){
          include("../views/connect.php");   
          $requete = $con->prepare('select media from news where id='.$id);
             $requete->execute();
              $media = $requete->fetchColumn();
              return  $media ; 
          
          }

          public static function get_thumbnail_by_id($id){
          include("../views/connect.php");   
          $requete = $con->prepare('select thumbnail from news where id='.$id);
             $requete->execute();
              $media = $requete->fetchColumn();
              return  $media ; 
          
          }




               //  
        public function update_status($id){
        try {
          include("../views/connect.php"); 
			  $con->exec('UPDATE news  set status=1 where id='.$id);
			  return true;
			} catch (PDOException $e) {
			   return false;
			} 
          
          }
         

             // delete_news
        public function delete_news($id){
        try {
          include("../views/connect.php"); 
			  $con->exec('DELETE FROM news where id='.$id);
			  return true;
			} catch (PDOException $e) {
			   return false;
			} 
       }

           // count of news without images
            public static function nbr_news_with_images(){
                  include("../views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*) FROM news where media!="" ');
                   $requete->execute();
              $nb_res = $requete->fetchColumn();
              return  $nb_res ;
              }

           public static function nbr_total_of_news(){
                  include("../views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*) FROM news  ');
                   $requete->execute();
              $nb_res = $requete->fetchColumn();
              return  $nb_res ;
              }
               public static function nbr_news_with_imagesthumbnail(){
                  include("../views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*) FROM news where thumbnail!="" ');
                   $requete->execute();
              $nb_res = $requete->fetchColumn();
              return  $nb_res ;
              }

                // count of news without images
            public static function nbr_news_with_images2(){
              include("fyipanel/views/connect.php");
              $requete = $con->prepare('SELECT COUNT(*) FROM news where media!="" ');
                   $requete->execute();
              $nb_res = $requete->fetchColumn();
              return  $nb_res ;
              }


               // find news by id ***
			public function findnews($id){
	            include("../views/connect.php");
	            $rqt=$con->query("SELECT * FROM news where id=".$id);
				if($data = $rqt->fetch()){
				$this->id=$data['id'];
	            $this->title=$data['title'];
	            $this->description=$data['description'];
	             $this->type=$data['type'];
	            $this->pubDate=$data['pubDate'];
	            $this->media=$data['media'];
	            $this->content=$data['content'];
	            $this->employee=$data['employee'];
              $this->status=$data['status'];
              $this->thumbnail=$data['thumbnail'];
	            return $this;
				}else{
	                return null;

	            }
				
	        }



	           // find news by id ***
			public function getOneNews($start){
	            include("fyipanel/views/connect.php");
	            $rqt=$con->query("SELECT * FROM news where media!='' order by pubDate desc limit ".$start.",1");
				if($data = $rqt->fetch()){
				$this->id=$data['id'];
	            $this->title=$data['title'];
	            $this->description=$data['description'];
	            $this->type=$data['type'];
	            $this->pubDate=$data['pubDate'];
	            $this->media=$data['media'];
	            $this->content=$data['content'];
	            $this->employee=$data['employee'];
	            $this->status=$data['status'];
	            return $this;
				}else{
	                return null;

	            }
				
	        }   




	    

	           // find news by type ***
			public function getNewsByType($type){
	            include("fyipanel/views/connect.php");
	            $tab=array();
	            $query=$con->query("SELECT * FROM news where type='".$type."' and media!='' and  (media like '%.jpg' || media like '%.jpeg' ||
            	media like '%.png' ||  media like '%.gif' || media like '%.mp4' || media like '%.webm' ||
            	media like '%.flv' ||  media like '%.mkv'  ||  media like '%.mpeg' ) order by pubDate desc 
	            	limit 0,4");
				while ($data = $query->fetch()){
            	$tab[] = $data;
	            }
	              return $tab;  
		        } 
 

	        	   // get first and last name
            public static function nameReporter2($email){
                  include("fyipanel/views/connect.php");
             $requete = $con->prepare('SELECT concat(First_name," ",Last_name) as name
             FROM users where Email="'.$email.'"');
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ;
              }


	        	   // get func
            public static function getFunctionEmployee($email){
                  include("../views/connect.php");
             $requete = $con->prepare('SELECT Function  FROM users where Email="'.$email.'"');
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ;
              }


          

              // get first and last name
            public static function nameReporter($email){
             include("../views/connect.php");
             $requete = $con->prepare('SELECT concat(First_name," ",Last_name) as name
             FROM users where Email="'.$email.'"');
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ;
              }

               // getReporterByidNews
            public static function getReporterByidNews($id){
             include("../views/connect.php");
             $requete = $con->prepare('SELECT employee FROM news where id='.$id);
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ;
              }


              // all news
		public function news(){ 
			include("../views/connect.php");
            $tab = array();      
            $query=$con->query('select * from news order by pubDate desc');
            while ($data = $query->fetch()){
            	$tab[] = $data;
            }
              return $tab; 
        }


          // all 
		public function newsNotSentByReporter($email){ 
			include("../views/connect.php");
            $tab = array();      
            $query=$con->query('select * from news where status=0 and employee="'.$email.'"  order by pubDate desc');
            while ($data = $query->fetch()){
            	$tab[] = $data;
            }
              return $tab; 
        }


         // getReporterByidNews
            public static function getTotalNews($email){
             include("../views/connect.php");
             $requete = $con->prepare('SELECT count(*) FROM news where employee="'.$email.'"');
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ;
              }


               // getReporterByidNews
            public static function getTotalNewsNotSent($email){
             include("../views/connect.php");
             $requete = $con->prepare('SELECT count(*) FROM news where status=0 and employee="'.$email.'"');
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ;
              } 

               // getReporterByidNews
            public static function getTotalNewsSent($email){
             include("../views/connect.php");
             $requete = $con->prepare('SELECT count(*) FROM news where status=1 and employee="'.$email.'"');
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ;
              }

              // getReporterByidNews
            public static function getTotalNewsPublished($email){
             include("../views/connect.php");
             $requete = $con->prepare('SELECT count(*) FROM news where status=-1 and employee="'.$email.'"');
             $requete->execute();
              $name = $requete->fetchColumn();
              return  $name ;
              }


         // all 
		public function newsSentByReporter($email){ 
			include("../views/connect.php");
            $tab = array();      
            $query=$con->query('select * from news where status=1 and employee="'.$email.'" order by pubDate desc ');
            while ($data = $query->fetch()){
            	$tab[] = $data;
            }
              return $tab; 
        }

       

          // all 
		public function newsByReporter($email){ 
			include("../views/connect.php");
            $tab = array();      
            $query=$con->query('select * from news where  employee="'.$email.'"  order by pubDate desc ');
            while ($data = $query->fetch()){
            	$tab[] = $data;
            }
              return $tab; 
        }
 


         // all 
		public function newsToSent(){ 
			include("../views/connect.php");
            $tab = array();      
            $query=$con->query('select * from news where status=1 order by pubDate desc ');
            while ($data = $query->fetch()){
            	$tab[] = $data;
            }
              return $tab; 
        }















      }

          ?>