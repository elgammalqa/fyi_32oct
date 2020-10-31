<?php    
class v5comments{   
  

 public static function info($at){ 
           include '../views/connect.php';
           $requete = $con->prepare('select '.$at.' from account where id=1');
           $requete->execute();
            return  $requete->fetchColumn();   
      } 
  //republish rss comments 
  public static function republish_rss_comments($id){
    try{ 
    include("../views/connect.php");
    $con->exec("insert into rss_comments select * from temp_rss_comments where id='".$id."' "); 
    return true;
    } catch (PDOException $e) {
         return false; 
    } 
  }  
  public static function republish_rss_replies($id){
    try{ 
    include("../views/connect.php");
    //get id_comments
    $requete = $con->prepare("select id_comment from temp_rss_replies where id='".$id."' ");
    $requete->execute();
    $id_comment = $requete->fetchColumn();  
    //check if exist 
    if(!v5comments::check_rss_comment_exist($id_comment)){ 
      $con->exec("insert into rss_comments select * from temp_rss_comments where id='".$id_comment."' ");
    }
    $con->exec("insert into rss_replies select * from temp_rss_replies where id='".$id."' ");
    return true;
    } catch (PDOException $e) {
         return false; 
    } 
  } 
  //republish news
  public static function republish_comments($id){
    try{ 
    include("../views/connect.php");
    $con->exec("insert into comments select * from temp_comments where id='".$id."' "); 
    return true;
    } catch (PDOException $e) {
         return false; 
    } 
  }  
  public static function republish_replies($id){
    try{ 
    include("../views/connect.php");
    //get id_comments
    $requete = $con->prepare("select id_comment from temp_replies where id='".$id."' ");
    $requete->execute();
    $id_comment = $requete->fetchColumn();  
    //check if exist 
    if(!v5comments::check_comment_exist($id_comment)){ 
      $con->exec("insert into comments select * from temp_comments where id='".$id_comment."' ");
    }
    $con->exec("insert into replies select * from temp_replies where id='".$id."' ");
    return true;
    } catch (PDOException $e) {
         return false; 
    } 
  } 
  //republish ads comments 
  public static function republish_ads_comments($id){
    try{ 
    include("../views/connect.php");
    $con->exec("insert into adscomments select * from temp_adscomments where id='".$id."' "); 
    return true;
    } catch (PDOException $e) {
         return false; 
    } 
  }   
  public static function republish_ads_replies($id){
    try{ 
    include("../views/connect.php");
    //get id_comments
    $requete = $con->prepare("select id_comment from temp_adsreplies where id='".$id."' ");
    $requete->execute();
    $id_comment = $requete->fetchColumn();  
    //check if exist 
    if(!v5comments::check_ads_comment_exist($id_comment)){ 
      $con->exec("insert into adscomments select * from temp_adscomments where id='".$id_comment."' ");
    }
    $con->exec("insert into adsreplies select * from temp_adsreplies where id='".$id."' ");
    return true;
    } catch (PDOException $e) {
         return false; 
    } 
  }  



 
 //check rss
  public static function check_rss_comment_exist($id_comment){
    include("../views/connect.php");  
    $requete = $con->prepare("select id from rss_comments where id='".$id_comment."' ");
    $requete->execute();
    $id_c = $requete->fetchColumn(); 
    if($id_c==null){ return false;
    }else{  return true; }
  }
  public static function check_rss_reply_exist($id_reply){ 
    include("../views/connect.php"); 
    $requete = $con->prepare("select id from rss_replies where id='".$id_reply."' ");
    $requete->execute();
    $id_c = $requete->fetchColumn(); 
    if($id_c==null){ return false;
    }else{  return true; }
  }
 //check news
  public static function check_comment_exist($id_comment){
    include("../views/connect.php");  
    $requete = $con->prepare("select id from comments where id='".$id_comment."' ");
    $requete->execute();
    $id_c = $requete->fetchColumn(); 
    if($id_c==null){ return false;
    }else{  return true; }
  }
  public static function check_reply_exist($id_reply){ 
    include("../views/connect.php"); 
    $requete = $con->prepare("select id from replies where id='".$id_reply."' ");
    $requete->execute();
    $id_c = $requete->fetchColumn(); 
    if($id_c==null){ return false;
    }else{  return true; }
  }
 //check ads
  public static function check_ads_comment_exist($id_comment){
    include("../views/connect.php");  
    $requete = $con->prepare("select id from adscomments where id='".$id_comment."' ");
    $requete->execute();
    $id_c = $requete->fetchColumn(); 
    if($id_c==null){ return false;
    }else{  return true; }
  }
  public static function check_ads_reply_exist($id_reply){ 
    include("../views/connect.php"); 
    $requete = $con->prepare("select id from adsreplies where id='".$id_reply."' ");
    $requete->execute();
    $id_c = $requete->fetchColumn(); 
    if($id_c==null){ return false;
    }else{  return true; }
  }

 


  //copy  rss comments
  public static function copy_rss_comments_replies($id){
    try{ 
    include("../views/connect.php");
    $con->exec("insert into temp_rss_comments select * from rss_comments where id='".$id."' ");
    $requete = $con->prepare("select count(*) from rss_replies where id_comment='".$id."' ");
    $requete->execute();
    $nb_replies = $requete->fetchColumn();
    if($nb_replies>0){
      $con->exec("delete from temp_rss_replies where id_comment='".$id."' ");
      $con->exec("insert into temp_rss_replies select * from rss_replies where id_comment='".$id."' ");
    } 
    return true;
    } catch (PDOException $e) {
         return false; 
    } 
  }
  public static function copy_rss_replies($id){
    try{
        include("../views/connect.php"); 
        $con->exec("insert into temp_rss_replies select * from rss_replies where id='".$id."' ");
        return true;
    } catch (PDOException $e) {
         return false; 
    } 
  }
  //copy  news comments
  public static function copy_comments_replies($id){
    try{ 
    include("../views/connect.php");
    $con->exec("insert into temp_comments select * from comments where id='".$id."' ");
    $requete = $con->prepare("select count(*) from replies where id_comment='".$id."' ");
    $requete->execute();
    $nb_replies = $requete->fetchColumn();
    if($nb_replies>0){
      $con->exec("delete from temp_replies where id_comment='".$id."' ");
      $con->exec("insert into temp_replies select * from replies where id_comment='".$id."' ");
    }
    return true;
    } catch (PDOException $e) {
         return false; 
    } 
  }
  public static function copy_replies($id){
    try{
        include("../views/connect.php"); 
        $con->exec("insert into temp_replies select * from replies where id='".$id."' ");
        return true;
    } catch (PDOException $e) {
         return false; 
    }  
  }  
 

  //copy  ads comments  
  public static function copy_ads_comments_replies($id){
    try{ 
    include("../views/connect.php");
    $con->exec("insert into temp_adscomments select * from adscomments where id='".$id."' ");
    $requete = $con->prepare("select count(*) from adsreplies where id_comment='".$id."' ");
    $requete->execute();
    $nb_replies = $requete->fetchColumn();
    if($nb_replies>0){
      $con->exec("delete from temp_adsreplies where id_comment='".$id."' ");
      $con->exec("insert into temp_adsreplies select * from adsreplies where id_comment='".$id."' ");
    }
    return true;
    } catch (PDOException $e) {
         return false; 
    } 
  }

  public static function copy_ads_replies($id){
    try{
        include("../views/connect.php"); 
        $con->exec("insert into temp_adsreplies select * from adsreplies where id='".$id."' ");
        return true;
    } catch (PDOException $e) {
         return false; 
    } 
  }
 

  //emails
  public static function nb_emails_selected(){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from language_users where isEmailConfirmed=1 and status=1 ");  
    $requete->execute();
    $nbrfeeds = $requete->fetchColumn();
      return  $nbrfeeds ;
  }  
  public static function select_deselect($st){
    try{
    include("../views/connect.php");
    $con->exec("update language_users set status='".$st."' ");  
    return true;
    } catch (PDOException $e) {
         return false; 
    }   
  } 
  public static function update_users_status($st,$e){
    try{
    include("../views/connect.php");
    $con->exec("update language_users set status='".$st."' where email='".$e."' ");  
    return true;
    } catch (PDOException $e) {
         return false; 
    }   
  } 
  public static function nb_emails(){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from language_users where isEmailConfirmed=1 ");
    $requete->execute();
    $nbrfeeds = $requete->fetchColumn();
      return  $nbrfeeds ;
  }   
  public static function all_emails(){
    $tab = array();      
    include("../views/connect.php");
    $query=$con->query("select * from language_users where isEmailConfirmed=1
              ORDER BY name ");
    while ($data = $query->fetch())  $tab[] = $data;
      return $tab;
    }
  public static function emails_selected(){
    $tab = array();      
    include("../views/connect.php");
    $query=$con->query("select * from language_users where isEmailConfirmed=1 and status=1 ");
    while ($data = $query->fetch())  $tab[] = $data;
      return $tab;
    }
   
   /*
  public static function emails_getspecial($start,$nb){
    $tab = array();      
    include("../views/connect.php");
    $query=$con->query("select * from language_users where isEmailConfirmed=1
              ORDER BY name LIMIT ".$start.",".$nb."");
    while ($data = $query->fetch())  $tab[] = $data;
      return $tab;
    }
  */

 
  //messages
  public static function nb_messages(){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from messages");
    $requete->execute();
    $nbrfeeds = $requete->fetchColumn();
    return  $nbrfeeds ;
  }
  public static function nb_messages_q($emailOrDateOrSub){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from messages
          where email like '%".$emailOrDateOrSub."%' or subject like '%".$emailOrDateOrSub."%' or date like '%".$emailOrDateOrSub."%' ");
    $requete->execute();
    $nbrfeeds = $requete->fetchColumn(); 
    return  $nbrfeeds ;
  }  
 
    public static function messages_getspecial($start,$nb){
        $tab = array();      
        include("../views/connect.php");
        $query=$con->query("select * from messages 
              ORDER BY UNIX_TIMESTAMP(date) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch())  $tab[] = $data;
        return $tab;
    }

    public static function messages_getspecial_q($emailOrDateOrSub,$start,$nb){
        $tab = array();       
        include("../views/connect.php");  
       $query=$con->query("select * from messages 
        where email like '%".$emailOrDateOrSub."%' or subject like '%".$emailOrDateOrSub."%' or date like '%".$emailOrDateOrSub."%'  ORDER BY UNIX_TIMESTAMP(date) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch()) $tab[] = $data;
        return $tab;
    }
     public static function delete_message($id_c){ 
          include("../views/connect.php"); 
          $c=false;  
          $requete = $con->prepare('SELECT count(*) FROM messages where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) { 
                  $con->exec('DELETE FROM messages where id='.$id_c);
                  $c=true;
                } 
          return  $c; 
       }  
       

  //temp ads comments 
  public static function temp_nbrAdsCommentsTotal(){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select id from temp_adscomments
     UNION all select id from temp_adsreplies)x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
  } 
  public static function temp_nbrAdsCommentsTotalq($commentOrTitle){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select ac.id from temp_adscomments ac,ads a 
          where id_ads=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      UNION all 
      select ar.id from temp_adsreplies ar,ads ad 
      where id_ads=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') )x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn(); 
        return  $nbrfeeds ;
  } 
 
  public static function temp_ads_getspecialfeeds($start,$nb){
        $tab = array();      
        include("../views/connect.php");
        $query=$con->query("SELECT 1 as rank,id,response,media,time,id_ads,email_user FROM temp_adscomments UNION
              SELECT 2 as rank,id,response,media,time,id_ads,email_user FROM temp_adsreplies
              ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch())  $tab[] = $data;
        return $tab;
    }

    public static function temp_ads_getspecialfeedsq($commentOrTitle,$start,$nb){
        $tab = array();       
        include("../views/connect.php");  
        $query=$con->query("select 1 as rank,ac.id,response,ac.media,time,id_ads,email_user,title
          from temp_adscomments ac,ads a 
          where id_ads=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') 
          UNION 
      select 2 as rank,ar.id,response,ar.media,time,id_ads,email_user,title 
      from temp_adsreplies ar,ads ad 
      where id_ads=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch()) $tab[] = $data;
        return $tab;
    }



	//ads
	public static function nbrAdsCommentsTotal(){
		include("../views/connect.php");
		$requete = $con->prepare("select count(*) from (select id from adscomments
		 UNION all select id from adsreplies)x");
		$requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
	} 
	public static function nbrAdsCommentsTotalq($commentOrTitle){
		include("../views/connect.php");
		$requete = $con->prepare("select count(*) from (select ac.id from adscomments ac,ads a 
        	where id_ads=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
			UNION all 
			select ar.id from adsreplies ar,ads ad 
			where id_ads=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') )x");
		$requete->execute();
        $nbrfeeds = $requete->fetchColumn(); 
        return  $nbrfeeds ;
	} 

	public static function ads_getspecialfeeds($start,$nb){
        $tab = array();      
        include("../views/connect.php");
        $query=$con->query("SELECT 1 as rank,id,response,media,time,id_ads,email_user FROM adscomments UNION
							SELECT 2 as rank,id,response,media,time,id_ads,email_user FROM adsreplies
							ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch())  $tab[] = $data;
        return $tab;
    }

    public static function ads_getspecialfeedsq($commentOrTitle,$start,$nb){
        $tab = array();       
        include("../views/connect.php");  
        $query=$con->query("select 1 as rank,ac.id,response,ac.media,time,id_ads,email_user,title
        	from adscomments ac,ads a 
        	where id_ads=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') 
        	UNION 
			select 2 as rank,ar.id,response,ar.media,time,id_ads,email_user,title 
			from adsreplies ar,ads ad 
			where id_ads=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
			ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch()) $tab[] = $data;
        return $tab;
    }

    public static function utilisateur_name($email){
        include("../views/connect.php");
        $requete = $con->prepare('SELECT name  FROM utilisateurs where email="'.$email.'" ');
        $requete->execute();
        $name = $requete->fetchColumn();
        return  $name ;
    }

    public static function ads_title($id){
        include("../views/connect.php");
        $requete = $con->prepare('SELECT title  FROM ads where id="'.$id.'" ');
        $requete->execute();
        $name = $requete->fetchColumn();
        return  $name ;
    }

    //ads delete commets and replies
    public static function delete_Comments_ad($id_c){ 
          include("../views/connect.php"); 
          $c=false;  
          $requete = $con->prepare('SELECT count(*) FROM adscomments where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) {
                  //v6 delete media
                  /*$requete = $con->prepare('SELECT media FROM adscomments where id='.$id_c);
                  $requete->execute();
                  $media = $requete->fetchColumn();
                  if($media!=null) unlink('../../ads/comments/'.$media); */
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
                  /*$requete = $con->prepare('SELECT media FROM adsreplies where id='.$id_c);
                  $requete->execute();
                  $media = $requete->fetchColumn();
                  if($media!=null) unlink('../../ads/replies/'.$media); */
                  // 
                 $con->exec('DELETE FROM adsreplies where id='.$id_c);
                 $c=true;
                } 
          return  $c;
    }  







 






     //temp news
  public static function temp_nbrNewsCommentsTotal(){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select id from temp_comments
     UNION all select id from temp_replies)x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
  } 
  public static function temp_nbrNewsCommentsTotalq($commentOrTitle){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select ac.id from temp_comments ac,news_published a 
          where id_news=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      UNION all  
      select ar.id from temp_replies ar,news_published ad 
      where id_news=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') )x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
  }  
  public static function temp_news_getspecialfeeds($start,$nb){
        $tab = array();      
        include("../views/connect.php");
        $query=$con->query("SELECT 1 as rank,id,response,media,time,id_news,email_user FROM temp_comments UNION
              SELECT 2 as rank,id,response,media,time,id_news,email_user FROM temp_replies
              ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch())  $tab[] = $data;
        return $tab;
    } 
    public static function temp_news_getspecialfeedsq($commentOrTitle,$start,$nb){
        $tab = array();       
        include("../views/connect.php");  
        $query=$con->query("select 1 as rank,ac.id,response,ac.media,time,id_news,email_user,title
          from temp_comments ac,news_published a 
          where id_news=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') 
          UNION 
      select 2 as rank,ar.id,response,ar.media,time,id_news,email_user,title 
      from temp_replies ar,news_published ad 
      where id_news=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch()) $tab[] = $data;
        return $tab;
    }



    //news
  public static function nbrNewsCommentsTotal(){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select id from comments
     UNION all select id from replies)x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
  } 
  public static function nbrNewsCommentsTotalq($commentOrTitle){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select ac.id from comments ac,news_published a 
          where id_news=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      UNION all 
      select ar.id from replies ar,news_published ad 
      where id_news=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') )x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
  }  
  public static function news_getspecialfeeds($start,$nb){
        $tab = array();      
        include("../views/connect.php");
        $query=$con->query("SELECT 1 as rank,id,response,media,time,id_news,email_user FROM comments UNION
              SELECT 2 as rank,id,response,media,time,id_news,email_user FROM replies
              ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch())  $tab[] = $data;
        return $tab;
    } 
    public static function news_getspecialfeedsq($commentOrTitle,$start,$nb){
        $tab = array();       
        include("../views/connect.php");  
        $query=$con->query("select 1 as rank,ac.id,response,ac.media,time,id_news,email_user,title
          from comments ac,news_published a 
          where id_news=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') 
          UNION 
      select 2 as rank,ar.id,response,ar.media,time,id_news,email_user,title 
      from replies ar,news_published ad 
      where id_news=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch()) $tab[] = $data;
        return $tab;
    }


    public static function news_title($id){
        include("../views/connect.php");
        $requete = $con->prepare('SELECT title  FROM news_published where id="'.$id.'" ');
        $requete->execute();
        $name = $requete->fetchColumn();
        return  $name ;
    }



    //news delete commets and replies
    public static function delete_Comments_news($id_c){ 
          include("../views/connect.php"); 
          $c=false;   
          $requete = $con->prepare('SELECT count(*) FROM comments where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) {
                  //v6 delete media
                  /*$requete = $con->prepare('SELECT media FROM comments where id='.$id_c);
                  $requete->execute();
                  $media = $requete->fetchColumn();
                  if($media!=null) unlink('../../images/comments/'.$media); */
                  //  
                 $con->exec('DELETE FROM comments where id='.$id_c);
                 $c=true;
                } 
          return  $c;
       }  
 
    public static function delete_replies_news($id_c){ 
          include("../views/connect.php");
          $c=false;  
          $requete = $con->prepare('SELECT count(*) FROM replies where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) {
                  //v6 delete media
                  /*$requete = $con->prepare('SELECT media FROM replies where id='.$id_c);
                  $requete->execute();
                  $media = $requete->fetchColumn();
                  if($media!=null) unlink('../../images/replies/'.$media);*/
                  //  
                 $con->exec('DELETE FROM replies where id='.$id_c);
                 $c=true;
                } 
          return  $c;
    }  




//temp rss comments replies deleted 
  public static function temp_nbrRssCommentsTotal(){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select id from temp_rss_comments
     UNION all select id from temp_rss_replies)x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
  } 
  public static function temp_nbrRssCommentsTotalq($commentOrTitle){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select ac.id from temp_rss_comments ac,rss a 
          where id_news=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      UNION all 
      select ar.id from temp_rss_replies ar,rss ad 
      where id_news=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') )x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
  }  
  public static function temp_rss_getspecialfeeds($start,$nb){
        $tab = array();      
        include("../views/connect.php");
        $query=$con->query("SELECT 1 as rank,id,response,media,time,id_news,email_user FROM temp_rss_comments UNION
              SELECT 2 as rank,id,response,media,time,id_news,email_user FROM temp_rss_replies
              ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch())  $tab[] = $data;
        return $tab;
    } 
    public static function temp_rss_getspecialfeedsq($commentOrTitle,$start,$nb){
        $tab = array();        
        include("../views/connect.php");  
        $query=$con->query("select 1 as rank,ac.id,response,ac.media,time,id_news,email_user,title
          from temp_rss_comments ac,rss a 
          where id_news=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') 
          UNION 
      select 2 as rank,ar.id,response,ar.media,time,id_news,email_user,title 
      from temp_rss_replies ar,rss ad 
      where id_news=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch()) $tab[] = $data;
        return $tab;
    } 
 
    //
    public static function getNewsTitle($id){ 
      $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/detail.php?id=".$id; 
      return '<a href="'.$actual_link.'" style="font-size: 20px;" > Link </a>'; 
    }
    public static function getAdsTitle($id){  
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST']."/detail_ads.php?id=".$id; 
        return '<a href="'.$actual_link.'" style="font-size: 20px;" > Link </a>'; 
    }

     public static function rss_getNewsTitle($id){
      include("../views/connect.php");
      $requete = $con->prepare('SELECT link FROM rss where id='.$id);
      $requete->execute();
      $t = $requete->fetchColumn();
      return  $t ;
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
        }else  if ($type=="mp3"||$type=="AC-3"||$type=="MP3"||$type=="ac-3") { 
          $media="audio";
        }
        return $media;
      }









    //rss
  public static function nbrRssCommentsTotal(){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select id from rss_comments
     UNION all select id from rss_replies)x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
  } 
  public static function nbrRssCommentsTotalq($commentOrTitle){
    include("../views/connect.php");
    $requete = $con->prepare("select count(*) from (select ac.id from rss_comments ac,rss a 
          where id_news=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      UNION all 
      select ar.id from rss_replies ar,rss ad 
      where id_news=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') )x");
    $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return  $nbrfeeds ;
  } 



  public static function rss_getspecialfeeds($start,$nb){
        $tab = array();      
        include("../views/connect.php");
        $query=$con->query("SELECT 1 as rank,id,response,media,time,id_news,email_user FROM rss_comments UNION
              SELECT 2 as rank,id,response,media,time,id_news,email_user FROM rss_replies
              ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch())  $tab[] = $data;
        return $tab;
    }

    public static function rss_getspecialfeedsq($commentOrTitle,$start,$nb){
        $tab = array();       
        include("../views/connect.php");  
        $query=$con->query("select 1 as rank,ac.id,response,ac.media,time,id_news,email_user,title
          from rss_comments ac,rss a 
          where id_news=a.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%') 
          UNION 
      select 2 as rank,ar.id,response,ar.media,time,id_news,email_user,title 
      from rss_replies ar,rss ad 
      where id_news=ad.id and (title like '%".$commentOrTitle."%' or response like '%".$commentOrTitle."%')
      ORDER BY UNIX_TIMESTAMP(time) desc LIMIT ".$start.",".$nb."");
        while ($data = $query->fetch()) $tab[] = $data;
        return $tab;
    } 
    public static function rss_title($id){
        include("../views/connect.php");
        $requete = $con->prepare('SELECT title  FROM rss where id="'.$id.'" ');
        $requete->execute();
        $name = $requete->fetchColumn();
        return  $name ; 
    }   
    //rss delete commets and replies
    public static function delete_Comments_rss($id_c){ 
          include("../views/connect.php"); 
          $c=false;  
          $requete = $con->prepare('SELECT count(*) FROM rss_comments where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) {
                  //v6 delete media
                 /* $requete = $con->prepare('SELECT media FROM rss_comments where id='.$id_c);
                  $requete->execute();
                  $media = $requete->fetchColumn();
                  if($media!=null) unlink('../../images/rss_comments/'.$media); */
                  // 
                 $con->exec('DELETE FROM rss_comments where id='.$id_c);
                 $c=true;
                } 
          return  $c;
       } 
  
    public static function delete_replies_rss($id_c){ 
          include("../views/connect.php");
          $c=false;  
          $requete = $con->prepare('SELECT count(*) FROM rss_replies where id='.$id_c);
          $requete->execute();
          $nbr_comments = $requete->fetchColumn();
                if ($nbr_comments>0) { 
                  //v6 delete media
                  /* $requete = $con->prepare('SELECT media FROM rss_replies where id='.$id_c);
                  $requete->execute();
                  $media = $requete->fetchColumn();
                  if($media!=null) unlink('../../images/rss_replies/'.$media); */
                  // 
                 $con->exec('DELETE FROM rss_replies where id='.$id_c);
                 $c=true;
                } 
          return  $c;
    }  



}

 ?>

