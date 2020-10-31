<?php 
class adsreportModel {
  private $id;
  private $id_ads; 
  private $email_user_report;  
  private $email_user_abuse;  
  private $id_comment; 
  private $id_reply;  
  private $date_report;  
  private $type; 
  private $other;  

        //getters
  public function getid()
  {
    return $this->id;
  } 
  public function getid_ads(){
   return $this->id_ads;
 } 	 
 public function getemail_user_report(){
  return $this->email_user_report;
} 
public function getemail_user_abuse(){
  return $this->email_user_abuse;
}
public function getid_comment(){
  return $this->id_comment;
}    
public function getid_reply(){
  return $this->id_reply;
}   
public function getdate_report(){
  return $this->date_report;
}  
public function gettype(){
  return $this->type;
}   
public function getother(){
  return $this->other;
} 


          //setters
public function setid($value)
{
  $this->id = $value; 
} 
public function setid_ads($value){
  $this->id_ads = $value; 
}    
public function setemail_user_report($value){
  $this->email_user_report = $value; 
} 
public function setemail_user_abuse($value){
  $this->email_user_abuse = $value; 
}
public function setid_comment($value){
  $this->id_comment = $value; 
}    
public function setid_reply($value){
 $this->id_reply = $value; 
}   
public function setdate_report($value){
  $this->date_report = $value; 
} 

public function settype($value){
 $this->type = $value; 
}   
public function setother($value){
  $this->other = $value;  
} 
 


//v5
public function add_report(){
  try{  
    include("fyipanel/views/connect.php"); 
      include("fyipanel/views/connect.php");
      $con->exec('INSERT INTO adsreport VALUES (NULL
        ,'.$this->id_ads.',"'.$this->email_user_report.'","'.$this->email_user_abuse.'",'.$this->id_comment.','.$this->id_reply.',"'.$this->date_report.'","'.$this->type.'","'.$this->other.'")');
      return true; 
  } catch (PDOException $e) {
   return false;  
 }
} 




public static function getemail_user_abuse_2($id){
  include("fyipanel/views/connect.php");
  $requete = $con->prepare('SELECT email_user FROM adscomments where id='.$id);
  $requete->execute();
  $mail = $requete->fetchColumn();
  return  $mail ;
}

public function reports(){ 
  include("../views/connect.php");
  $tab = array();       
  $query=$con->query('select * from adsreport order by date_report desc');
  while ($data = $query->fetch()){
    $tab[] = $data;
  }
  return $tab; 
}
 
 
public static function getAdsTitle($id){ 
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/detail_ads.php?id=".$id; 
    return '<a href="'.$actual_link.'" style="font-size: 20px;" > Link </a>'; 
}


public static function getResponseComment($id){
  include("../views/connect.php");
  $requete = $con->prepare('SELECT response FROM adscomments where id='.$id);
  $requete->execute(); 
  $t = $requete->fetchColumn();
  return  $t ;
}

public static function getResponseReply($id){
  include("../views/connect.php");
  $requete = $con->prepare('SELECT response FROM adsreplies where id='.$id);
  $requete->execute();
  $t = $requete->fetchColumn();
  return  $t ;
}

public static function getUtilisateurName($email){
  include("../views/connect.php");
  $requete = $con->prepare('SELECT name FROM utilisateurs where email="'.$email.'"');
  $requete->execute();
  $t = $requete->fetchColumn();
  return  $t ;
}

public static function getemail_user_abuse_r($id){
  include("fyipanel/views/connect.php");
  $requete = $con->prepare('SELECT email_user FROM adsreplies where id='.$id);
  $requete->execute();
  $mail = $requete->fetchColumn();
  return  $mail ;
}


























































  // count of news without images
public static function nbr_news_with_images(){
  include("fyipanel/views/connect.php");
  $requete = $con->prepare('SELECT COUNT(*) FROM adsreplies where media!="" ');
  $requete->execute();
  $nb_res = $requete->fetchColumn();
  return  $nb_res ;
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


