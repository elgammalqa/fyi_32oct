<?php 
	class adsModel {
		private $id; 
		private $title; 
		private $description;
		private $media; 
		private $pdf;
		private $content; 
		private $pubDate;
		private $finDate;
        private $employee; 
        private $thumbnail; 


        //l5
        public static function lastid_hot_ads(){
            include("../views/connect.php");   
            $requete = $con->prepare('select max(id) from hot_ads ');
            $requete->execute();
            $id = $requete->fetchColumn();
            return  $id ;  
        } 
        
        public static function add_hot_ad($id_photo,$id_photo2,$link,$findate,$fyipEmail,$pubDate,$fit,$d){
           try {
                include("../views/connect.php");
                $con->exec('INSERT INTO hot_ads  VALUES (null,"'.$id_photo.'","'.$id_photo2.'"
                    ,"'.$link.'","'.$pubDate.'",'.$findate.',"'.$fyipEmail.'","'.$fit.'","'.$d.'","'.$pubDate.'",1,0)');
                return true;
              } catch (PDOException $e) {
                 return false;
              }  
        }

        public static function get_data_condition($link,$table,$cond,$value){  
            include($link); $tab = array();      
            $query=$con->query('select * from '.$table.' where '.$cond.'="'.$value.'" ');
            while ($data = $query->fetch())  $tab[] = $data; 
            return $tab; 
        } 

        public static function delete_ad_hot($id){ 
          try {
            include("fyipanel/views/connect.php");
            $con->exec('DELETE from hot_ads where id='.$id);
              return true;
          } catch (PDOException $e) {
               return false;
          }  
        }

        public static function delete($link,$table,$cond1,$val1){ 
              include($link);
              $q=$con->prepare('delete from '.$table.' where '.$cond1.'="'.$val1.'"');
              $q->execute();
              return $q->rowCount();
        }  
 
        public static function get_data($link,$table){  
            include($link); $tab = array();      
            $query=$con->query('select * from '.$table);
            while ($data = $query->fetch())  $tab[] = $data; 
            return $tab; 
        } 
        public static function check_exist($link,$table,$cond,$value){
          include($link);
          $query = $con->prepare("SELECT count(*) FROM ".$table." where ".$cond."='".$value."' ");
          $query->execute();
          $nb = $query->fetchColumn(); 
            if ($nb>0)  return true;
            else  return false;
      }
        public static function check_time_exist($link,$t1,$t2){  
            include($link);   
            $query=$con->query('select count(*) from times_hot_ads where "'.$t1.'" between ad_from and ad_to or "'.$t2.'" between ad_from and ad_to ');
             $count = $query->fetchColumn();  
           if($count>0) return true;
           else return 0;
        } 
        public static function get_ad_id($link,$t){  
            include($link);   
            $query=$con->query('select id_add from times_hot_ads where "'.$t.'" between ad_from and ad_to');
            $id = $query->fetchColumn();  
            return $id;
        }   

         public static function add_times_hot_ads($link,$id,$ad_from,$ad_to,$pubDate,$fyipEmail){
            try {
                include($link);  
                $con->exec('INSERT INTO times_hot_ads  VALUES (null,"'.$id.'","'.$ad_from.'"
                    ,"'.$ad_to.'","'.$pubDate.'","'.$fyipEmail.'")');
                return true;
              } catch (PDOException $e) {
                 return false;
              }    
         }
           

            public static function update_default_hot_ad($id_photo,$link,$fit){
                include('../views/connect.php');
                $con->exec("UPDATE default_hot_ad set media='".$id_photo."',link='".$link."',fit='".$fit."' where id=1"); 
            }  

            public static function update_hot_ads($l,$link,$fit,$id,$descad){
                include($l);
                $con->exec("UPDATE hot_ads set link='".$link."',fit='".$fit."',description='".$descad."' where id= '".$id."' "); 
            }  



      public static function check_exist2($link,$table,$cond1,$val1,$cond2,$val2){
        include($link);
        $query = $con->prepare("SELECT count(*) FROM ".$table." where ".$cond1."='".$val1."' and ".$cond2."='".$val2."' ");
        $query->execute();
        $nb = $query->fetchColumn(); 
          if ($nb>0)  return true;
          else  return false;
  } 
        

public static function get_attr_condition2($link,$attr,$table,$cond,$value,$cond2,$value2){
      include($link);
      $query = $con->prepare("SELECT ".$attr." FROM ".$table." where ".$cond."='".$value."' and ".$cond2."='".$value2."' ");
      $query->execute();
      $nb = $query->fetchColumn();  
      return $nb;
  } 

public static function get_attr_condition($link,$attr,$table,$cond,$value){
      include($link);
      $query = $con->prepare("SELECT ".$attr." FROM ".$table." where ".$cond."='".$value."'");
      $query->execute();
      $nb = $query->fetchColumn();  
      return $nb;
  } 

public static function get_count_condition($link,$table,$cond,$value){
      include($link);
      $query = $con->prepare("SELECT count(*) FROM ".$table." where ".$cond."='".$value."' ");
      $query->execute();
      $nb = $query->fetchColumn(); 
      return $nb;
  } 


public static function repeat_hot_ads($link,$pubDate,$id,$finDate,$e){
  try {
    include($link); 
    $con->exec("UPDATE hot_ads set pubDate='".$pubDate."',status=1,nb_rep=nb_rep+1 where id='".$id."' "); 
    $con->exec('INSERT INTO repetition  VALUES (null,"'.$id.'","'.$pubDate.'"
                    ,"'.$finDate.'","'.$e.'")');
     return true;
  } catch (PDOException $e) {
         return false;
  }     
  }  


 public static function update_condition($link,$table,$attr,$val,$cond,$cond_val){
      include($link);
      $con->exec("UPDATE ".$table." set ".$attr."='".$val."' where ".$cond."='".$cond_val."' "); 
  }  
  




















  
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
		public function getmedia(){
			return $this->media;
		}
		public function getpdf(){
			return $this->pdf;
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
 	    public function getfinDate(){
			return $this->finDate;
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
		public function setpdf($value){ 
				$this->pdf = $value; 
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
         public function setfinDate($value){  
				$this->finDate = $value; 
        }


         public function setthumbnail($value){  
             $this->thumbnail = $value; 
        }
         public static function last_id(){
          include("../views/connect.php");   
			    $requete = $con->prepare('select max(id) from ads ');
             $requete->execute();
              $id = $requete->fetchColumn();
              return  $id ; 
           
          } 


             public static function getthumbnail_ads2($id){
          include("../views/connect.php");   
          $requete = $con->prepare('select thumbnail from ads  where id='.$id);
             $requete->execute();
              $id = $requete->fetchColumn(); 
              return  $id ;  
          }

       public static function getpdf_ads2($id){
          include("../views/connect.php");   
          $requete = $con->prepare('select pdf from ads  where id='.$id);
             $requete->execute();
              $id = $requete->fetchColumn();
              return  $id ;  
          }
         public static function getmedia_ads($id){
          include("../views/connect.php");   
          $requete = $con->prepare('select media from ads  where id='.$id);
             $requete->execute();
              $id = $requete->fetchColumn();
              return  $id ;  
          }

          public static function delete_ad2($id){ 
            try {
            include("../views/connect.php");
            $con->exec('DELETE from ads where id='.$id);
              return true;
            } catch (PDOException $e) {
               return false;
            }  
           }



          public static function nbr_ads(){
          include("../views/connect.php");   
			    $requete = $con->prepare('select count(*) from ads ');
             $requete->execute();
              $id = $requete->fetchColumn();
              return  $id ; 
          
          }
 
           public static function nbr_ads_with_thumbnails(){
          include("../views/connect.php");   
          $requete = $con->prepare('select count(*) from ads where thumbnail!="" ');
             $requete->execute();
              $id = $requete->fetchColumn();
              return  $id ; 
          
          }

           public static function nbr_ads2(){
          include("fyipanel/views/connect.php");   
			    $requete = $con->prepare('select count(*) from ads ');
             $requete->execute();
              $id = $requete->fetchColumn();
              return  $id ; 
          
          }


       public static function getid_ads($f){
          include("fyipanel/views/connect.php");   
          $requete = $con->prepare('select id from ads  where media="'.$f.'"');
             $requete->execute();
              $id = $requete->fetchColumn();
              return  $id ;  
          }

        public static function getthumbnail_ads($id){
          include("fyipanel/views/connect.php");   
          $requete = $con->prepare('select thumbnail from ads  where id='.$id);
             $requete->execute();
              $id = $requete->fetchColumn();
              return  $id ;  
          }

           public static function getpdf_ads($id){
          include("fyipanel/views/connect.php");   
          $requete = $con->prepare('select pdf from ads  where id='.$id);
             $requete->execute();
              $id = $requete->fetchColumn();
              return  $id ;  
          }

          public static function getfinDates($f){
          include("fyipanel/views/connect.php");   
          $requete = $con->prepare('select finDate from ads  where media="'.$f.'"');
             $requete->execute();
              $finDate = $requete->fetchColumn();
              return  $finDate ;  
          }

           public static function get_pdf_by_id2($id){
          include("fyipanel/views/connect.php");   
          $requete = $con->prepare('select pdf from ads where id='.$id);
             $requete->execute();
              $media = $requete->fetchColumn();
              return  $media ; 
          
          } 
    public function add_ad(){ 
      try {
      include("../views/connect.php");
          $con->exec('INSERT INTO ads  VALUES 
          	(null,"'.$this->title.'","'.$this->description.'"
          	,"'.$this->media.'","'.$this->pdf.'"
          	,"'.$this->content.'","'.$this->pubDate.'",'.$this->finDate.'
          	,"'.$this->employee.'","'.$this->thumbnail.'")');
        return true;
      } catch (PDOException $e) {
         return false;
      }  
     }
    

    public static function delete_ad($id){ 
      try {
      include("fyipanel/views/connect.php");
      $con->exec('DELETE from ads where id='.$id);
        return true;
      } catch (PDOException $e) {
         return false;
      }  
     }

  		public function ads(){
	            include("fyipanel/views/connect.php");
	            $tab=array();
	            $query=$con->query("SELECT * FROM ads order by pubDate desc ");
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
               // find news by id ***
			public function findnews($id){
	            include("fyipanel/views/connect.php");
	            $rqt=$con->query("SELECT * FROM ads where id=".$id);
				if($data = $rqt->fetch()){
				$this->id=$data['id'];
	            $this->title=$data['title'];
	            $this->description=$data['description'];
	             $this->finDate=$data['finDate'];
	            $this->pubDate=$data['pubDate'];
	            $this->media=$data['media'];
	            $this->pdf=$data['pdf'];
	            $this->content=$data['content'];
	            $this->employee=$data['employee'];
	            return $this;
				}else{
	                return null;

	            }
				 
	        } 
 




      }

          ?>