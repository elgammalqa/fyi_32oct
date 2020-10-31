<?php 

class rssModel{
    private $id;
    private $title;
    private $description;
    private $link;
    private $pubDate;
    private $Source;

    //getters
    public function getid(){
			return $this->id;
		}
    public function gettitle(){
			return $this->title;
		}
    public function getdescription(){
			return $this->description;
		}
    public function getlink(){
                return $this->link;
            }
    public function getpubDate(){
			return $this->pubDate;
		}
    public function getSource(){
			return $this->Source;
        } 
        
        //setters
        public function setid($value){
                $this->id = $value;	
        }
        public function settitle($value){
                $this->title = $value;	
        }
        public function setdescription($value){
                $this->description = $value;	
        }
        public function setlink($value){
                $this->link = $value;	
        }
        public function setDate($value){
                $this->Date = $value;	
        }
        public function setSource($value){
                $this->Source = $value;	
        }   
             
        





         // getspecialfeeds  nbrfeeds2  
                public function getspecialfeeds($start,$nb){
                        $tab = array();       
                        include("fyipanel/views/connect.php");
            $emaill="";
            if(isset($_COOKIE['fyiuser_email'])&&isset($_COOKIE['fyiuser_email'])){
                $emaill=$_COOKIE['fyiuser_email']; 
            }else  if(isset($_SESSION['user_auth']['user_email'])&&isset($_SESSION['user_auth']['user_email'])){
                $emaill=$_SESSION['user_auth']['user_email']; 
            } 
            if($emaill!=""){
                $query=$con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` 
                    from rss r,rss_sources rs where r.favorite=rs.id and favorite not in (select id from user_sources where email='$emaill') and media=''  group by title 
                  UNION  
                    select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
                    FROM news_published  where   media=''  
                    ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT  ".$start.",".$nb."");
            }else{//not logged

                if(isset($_COOKIE['hebrew_sources'])){
                    $data = json_decode($_COOKIE['hebrew_sources'], true);
                    if(count($data)>0){ 
                $query=$con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` 
                    from rss r,rss_sources rs where r.favorite=rs.id and  favorite NOT IN ( '" . implode( "', '" , $data ) . "' ) and media=''  group by title 
                  UNION  
                    select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
                    FROM news_published  where   media=''  
                    ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT  ".$start.",".$nb."");

                    }else{//no follow
                $query=$con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` 
                    from rss r,rss_sources rs where r.favorite=rs.id and media=''  group by title 
                  UNION  
                    select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
                    FROM news_published  where   media=''  
                    ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT  ".$start.",".$nb."");
 
                    }
                }else{//no cookie
                $query=$con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` 
                    from rss r,rss_sources rs where r.favorite=rs.id and media=''  group by title 
                  UNION  
                    select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
                    FROM news_published  where   media=''  
                    ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT  ".$start.",".$nb."");

                }
            }
                        while ($data = $query->fetch())
                        $tab[] = $data;
                        return $tab;
                }



                public static function nbrfeeds2(){
                include("fyipanel/views/connect.php"); 
                  $emaill="";
            if(isset($_COOKIE['fyiuser_email'])&&isset($_COOKIE['fyiuser_email'])){
                $emaill=$_COOKIE['fyiuser_email']; 
            }else  if(isset($_SESSION['user_auth']['user_email'])&&isset($_SESSION['user_auth']['user_email'])){
                $emaill=$_SESSION['user_auth']['user_email']; 
            }   
            if($emaill!=""){
                $requete = $con->prepare("select count(*) from (select id from rss where  favorite not in (select id from user_sources where email='$emaill') and  media='' group by title UNION ALL select id FROM news_published where media='')x");

            }else{//not logged
                 if(isset($_COOKIE['hebrew_sources'])){
                    $data = json_decode($_COOKIE['hebrew_sources'], true);
                    if(count($data)>0){ 
                        $requete = $con->prepare("select count(*) from (select id from rss where  favorite NOT IN ( '" . implode( "', '" , $data ) . "' ) and media='' group by title UNION ALL select id FROM news_published where media='')x");
                    }else{
                        $requete = $con->prepare("select count(*) from (select id from rss where  media='' group by title UNION ALL select id FROM news_published where media='')x");
                    }
                }else{//no cookie
                    $requete = $con->prepare("select count(*) from (select id from rss where  media='' group by title UNION ALL select id FROM news_published where media='')x");
                }

            } 
                $requete->execute();
                $nbrfeeds = $requete->fetchColumn();
                return  $nbrfeeds ;
            }













         public static function rssNbreNewsToShow(){
               include 'fyipanel/views/connect.php';
                            $requete = $con->prepare('select numberofs from settings where id=3');
                            $requete->execute();
                            $nb = $requete->fetchColumn();
                            return $nb;  
                        } 
                public function rssall(){
                        $tab = array();      
                        include("fyipanel/views/connect.php");
                        $query=$con->query("SELECT * FROM rss  order by pubDate DESC");
                        while ($data = $query->fetch())
                        $tab[] = $data;
                        return $tab;
                }

                public function rssspecial($src){
                        $tab = array();      
                        include("fyipanel/views/connect.php");
                        $query=$con->query("SELECT * FROM rss  where Source='".$src."'   order by pubDate DESC ");
                        while ($data = $query->fetch())
                        $tab[] = $data;
                        return $tab;
                }
 

                 // start , nbrfeeds
                public function getspecialfeedsBySource($src,$start,$nb){
                        $tab = array();      
                        include("fyipanel/views/connect.php");
                        $query=$con->query("SELECT * FROM rss where Source='".$src."'  order by pubDate DESC LIMIT ".$start.",".$nb."");
                        while ($data = $query->fetch())
                        $tab[] = $data;
                        return $tab;
                }

                         //12 news rss
                public function twelve_rss_news(){
                        $tab = array();      
        include("fyipanel/views/connect.php");
        $query=$con->query("SELECT * FROM rss  order by pubDate DESC LIMIT 0,12");
        while ($data = $query->fetch())
                $tab[] = $data;
                        return $tab;
                }

                public function nb_rss_news($nb){
                        $tab = array();      
                        include("fyipanel/views/connect.php");
                        $query=$con->query("SELECT * FROM rss  order by pubDate DESC LIMIT 0,".$nb);
                        while ($data = $query->fetch())
                         $tab[] = $data;
                        return $tab;
                }

                        //5 news rss
                public function three_news($source){
                        $tab = array();      
                        include("fyipanel/views/connect.php");
                        $query=$con->query("SELECT * FROM rss where  Source='".$source."' order by pubDate DESC LIMIT 0,3");
                        while ($data = $query->fetch())
                        $tab[] = $data;
                        return $tab;
                }


                //return news sorted
                public function news_sorted(){
                $tab = array();      
                include("fyipanel/views/connect.php");
                $query=$con->query("SELECT * FROM rss_tmp order by pubDate DESC");
                while ($data = $query->fetch())
                        $tab[] = $data;
                                return $tab;
                        }
                
                //delete data from rss_tmp
                public function delete_rss_tmp(){
                        include("fyipanel/views/connect.php");
                        $con->exec('DELETE FROM rss_tmp');
                     } 

                   public static function last_date_rss_all($src,$type){
                        include("fyipanel/views/connect.php");
                        $requete = $con->prepare('SELECT  max(pubDate) FROM rss where Source="'.$src.'" and type="'.$type.'"');
                        $requete->execute();
                        $lastdate = $requete->fetchColumn();
                        return  $lastdate ;
                }
 
                   public static  function rrsfeedsbysource($src,$type){
                        include("fyipanel/views/connect.php");
                  $requete = $con->prepare('SELECT  count(*) FROM rss where Source="'.$src.'" and type="'.$type.'"');
                        $requete->execute();
                        $lastdate = $requete->fetchColumn();
                        return  $lastdate ;
                }
 

                 // last date of news from tass in rss table
               public static function  rsscount(){
                        include("fyipanel/views/connect.php");
                        $requete = $con->prepare('SELECT count(*) FROM rss ');
                        $requete->execute();
                        $nbrss = $requete->fetchColumn();
                        return  $nbrss ;
                } 

                  public static function  rsscount2(){
                        include("fyipanel/views/connect.php");
                        $requete = $con->prepare('SELECT count(*) FROM rss where media="" ');
                        $requete->execute();
                        $nbrss = $requete->fetchColumn();
                        return  $nbrss ;
                } 

                public function nbnewsexiste($title,$link,$source){
                include("fyipanel/views/connect.php"); 
                $requete = $con->prepare('select count(*) from rss  where Source="'.$source.'" and title="'.$title.'" and link="'.$link.'"');
                $requete->execute();
	         $nb_res = $requete->fetchColumn();
	        return  $nb_res ;
            }

            // get nbr feeds
             public static function nbrfeeds(){
                include("fyipanel/views/connect.php"); 
                $requete = $con->prepare('select count(*) from rss');
                $requete->execute();
                $nbrfeeds = $requete->fetchColumn();
                return  $nbrfeeds ;
            } 
            
            // get nbr feeds
             public function nbrfeedsBySource($src){
                include("fyipanel/views/connect.php"); 
                $requete = $con->prepare('select count(*) from rss  where Source="'.$src.'"');
                $requete->execute();
                $nbrfeeds = $requete->fetchColumn();
                return  $nbrfeeds ;
            }

            public function nbrpages(){
                include("fyipanel/views/connect.php"); 
                $requete = $con->prepare('select count(*)/10 from rss');
                $requete->execute();
	         $nbpages = $requete->fetchColumn();
	        return  $nbpages ;
            }


              // last date of news from aljazeera in rss table
             public static  function nbrssfeeds(){
                        include("fyipanel/views/connect.php");
                        $requete = $con->prepare('SELECT count(*) FROM rss');
                        $requete->execute();
                        $nb = $requete->fetchColumn();
                        return  $nb ;
                }

            
          




    }

    

?>