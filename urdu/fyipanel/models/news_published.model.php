<?php

class news_publishedModel
{
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

    public static function nbrhotnews()
    {
        include("fyipanel/views/connect.php");
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $requete = $con->prepare("select count(*) from 
                  (select id from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png'   || media like '%.JPEG' || media like '%.PNG'  || media like '%.JPG' )  UNION all
                  select id from rss   where  favorite not in (select id from user_sources where email='$emaill') and (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title)x");
        } else {

            if (isset($_COOKIE['urdu_sources'])) {
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $requete = $con->prepare("select count(*) from 
                      (select id from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png'   || media like '%.JPEG' || media like '%.PNG'  || media like '%.JPG' )  UNION all
                      select id from rss where favorite NOT IN ( '" . implode("', '", $data) . "' ) and (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title)x");
                } else {
                    $requete = $con->prepare("select count(*) from 
                      (select id from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png'   || media like '%.JPEG' || media like '%.PNG'  || media like '%.JPG' )  UNION all
                      select id from rss where (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title)x");
                }
            } else {
                $requete = $con->prepare("select count(*) from 
                      (select id from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png'   || media like '%.JPEG' || media like '%.PNG'  || media like '%.JPG' )  UNION all
                      select id from rss where (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title)x");
            }


        }
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public static function nbrnewsStartCountVideos2()
    {
        include("fyipanel/views/connect.php");
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }

        if ($emaill != "") {
            $requete = $con->prepare("select count(*) from(select id from rss where favorite not in (select id from user_sources where email='$emaill') and (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) group by title UNION select id FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ))x");
        } else {//not logged
            if (isset($_COOKIE['urdu_sources'])) {
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $requete = $con->prepare("select count(*) from(select id from rss where  favorite NOT IN ( '" . implode("', '", $data) . "' ) and (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) group by title UNION select id FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ))x");
                } else {
                    $requete = $con->prepare("select count(*) from(select id from rss where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) group by title UNION select id FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ))x");
                }
            } else {
                $requete = $con->prepare("select count(*) from(select id from rss where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) group by title UNION select id FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ))x");
            }
        }
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public static function nbrNewsBySourceindex($src)
    {
        include("fyipanel/views/connect.php");

        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }

        if ($emaill != "") {
            $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and favorite not in (select id from user_sources where email='$emaill') and type='" . $src . "' and 
                 (media like '%.jpg' || media like '%.jpeg' || media like '%.png' ||  media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' ) group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF'  )x");
        } else {
            if (isset($_COOKIE['urdu_sources'])) {
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and  favorite NOT IN ( '" . implode("', '", $data) . "' )  and type='" . $src . "' and 
                 (media like '%.jpg' || media like '%.jpeg' || media like '%.png' ||  media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' ) group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF'  )x");
                } else {
                    $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and type='" . $src . "' and (media like '%.jpg' || media like '%.jpeg' || media like '%.png' ||  media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )  group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF'  )x");
                }
            } else {
                $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and type='" . $src . "' and  (media like '%.jpg' || media like '%.jpeg' || media like '%.png' ||  media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' ) group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF'  )x");
            }
        }
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public static function rsscount2()
    {
        include("fyipanel/views/connect.php");
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $requete = $con->prepare('SELECT count(*) FROM rss where media="" and favorite not in (select id from user_sources where email="$emaill") ');
        } else {
            if (isset($_COOKIE['urdu_sources'])) {
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $requete = $con->prepare("SELECT count(*) FROM rss where media='' and  favorite NOT IN ( '" . implode("', '", $data) . "' ) ");
                } else {
                    $requete = $con->prepare('SELECT count(*) FROM rss where media="" ');
                }
            } else {
                $requete = $con->prepare('SELECT count(*) FROM rss where media="" ');
            }
        }
        $requete->execute();
        $nbrss = $requete->fetchColumn();
        return $nbrss;
    }

    public static function source_not_open($source)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('select source from sources_not_open where source="' . $source . '" ');
        $requete->execute();
        $s = $requete->fetchColumn();
        if ($s != null) {
            return true;
        } else {
            return false;
        }
    }

    public static function get_media_by_id($id)
    {
        include("../views/connect.php");
        $requete = $con->prepare('select media from news_published where id=' . $id);
        $requete->execute();
        $media = $requete->fetchColumn();
        return $media;
    }

    public static function get_thumbnail_by_id($id)
    {
        include("../views/connect.php");
        $requete = $con->prepare('select thumbnail from news_published where id=' . $id);
        $requete->execute();
        $media = $requete->fetchColumn();
        return $media;
    }

    public static function get_media_by_id2($id)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('select media from news_published where id=' . $id);
        $requete->execute();
        $media = $requete->fetchColumn();
        return $media;

    }

    public static function update_rss_sources($status, $id)
    {
        include("../views/connect.php");
        $con->exec('UPDATE rss_sources  set status=' . $status . ' where id=' . $id);
    }

    public static function get_content_to_update($id)
    {
        include("../views/connect.php");
        $requete = $con->prepare('select content from news_published where id=' . $id);
        $requete->execute();
        $name = $requete->fetchColumn();
        return $name;

    }

    /* setters  */

    public static function update_content($t, $id)
    {
        include("../views/connect.php");
        try {
            $con->exec('UPDATE news_published  set content="' . $t . '" where id=' . $id);
            return true;
        } catch (PDOException $e) {
            return false;
        }

    }

    public static function nbrNewsBySourceWithoutMedia2($src)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('select count(*) from news_published  where media="" and type="' . $src . '"');
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public static function id_added($id)
    {
        include("../views/connect.php");
        $requete = $con->prepare('select id from news_published where id=' . $id);
        $requete->execute();
        $name = $requete->fetchColumn();
        return $name;

    }

    public static function delete_rss($id)
    {
        try {
            include("../views/connect.php");
            $con->exec('DELETE FROM rss where id=' . $id);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function nbr_news_with_images()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM news_published where media!="" ');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    public static function nbr_news_without_images()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM news_published where media="" ');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    public static function nbr_news_without_images2()
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM news_published where media="" ');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    public static function nbresNews($type)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare("SELECT count(*) FROM news_published 
                where type='" . $type . "'");
        $requete->execute();
        $nbr = $requete->fetchColumn();
        return $nbr;
    }

    public static function NbreNewsToShow()
    {
        include 'fyipanel/views/connect.php';
        $requete = $con->prepare('select numberofs from settings where id=1');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function timToContinue()
    {
        include 'fyipanel/views/connect.php';
        $requete = $con->prepare('select numberofs from settings where id=2');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function nameReporter2($email)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT concat(First_name," ",Last_name) as name
             FROM users where Email="' . $email . '"');
        $requete->execute();
        $name = $requete->fetchColumn();
        return $name;
    }











    //v2
    //azaz

    public static function pdfcount()
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare("SELECT count(*) FROM news_published 
                          where (media like '%.PDF' || media like '%.pdf'  )  ");
        $requete->execute();
        $nbrss = $requete->fetchColumn();
        return $nbrss;
    }


    //azaz

    public static function typeOfMedia($str)
    {
        $lastdot = strrpos($str, ".");//
        $length = strlen($str);//
        $type = substr($str, $lastdot + 1, $length - $lastdot + 1);
        $media = "";
        if ($type == "jpg" || $type == "JPG" || $type == "jpeg" || $type == "JPEG" || $type == "png" || $type == "PNG" || $type == "gif" || $type == "GIF") {
            $media = "image";
        } else if ($type == "mp4" || $type == "webm" || $type == "flv" || $type == "mkv" || $type == "mpeg"
            || $type == "MP4" || $type == "WEBM" || $type == "FLV" || $type == "MKV" || $type == "MPEG") {
            $media = "video";
        } else if ($type == "mp3" || $type == "AC-3" || $type == "MP3" || $type == "ac-3") {
            $media = "audio";
        } else if ($type == "pdf" || $type == "PDF") {
            $media = "pdf";
        }
        return $media;
    }

    //azaz

    public static function nameReporter($email)
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT concat(First_name," ",Last_name) as name
             FROM users where Email="' . $email . '"');
        $requete->execute();
        $name = $requete->fetchColumn();
        return $name;
    }


//azaz

    public static function gettypebyid($id)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT type   FROM news_published where id=' . $id);
        $requete->execute();
        $type = $requete->fetchColumn();
        return $type;
    }


    //newsrss

    public function getid()
    {
        return $this->id;
    }

    public function setid($value)
    {
        $this->id = $value;

    }

    public function gettitle()
    {
        return $this->title;
    }

    public function settitle($value)
    {
        $this->title = $value;


    }


    //category

    public function getdescription()
    {
        return $this->description;
    }

    public function setdescription($value)
    {
        $this->description = $value;

    }

    public function gettype()
    {
        return $this->type;
    }

    public function settype($value)
    {
        $this->type = $value;

    }

    public function getmedia()
    {
        return $this->media;
    }

    public function setmedia($value)
    {
        $this->media = $value;

    }

    public function getcontent()
    {
        return $this->content;
    }

    public function setcontent($value)
    {
        $this->content = $value;

    }

    public function getpubDate()
    {
        return $this->pubDate;
    }

    public function setpubDate($value)
    {
        $this->pubDate = $value;

    }

    public function getemployee()
    {
        return $this->employee;
    }

    public function setemployee($value)
    {
        $this->employee = $value;

    }

    public function getstatus()
    {
        return $this->status;
    }

    public function setstatus($value)
    {
        $this->status = $value;

    }


    //zzz

    public function getthumbnail()
    {
        return $this->thumbnail;
    }

    public function setthumbnail($value)
    {
        $this->thumbnail = $value;

    }

    public function find_search($searchq)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` 
                from rss r,rss_sources s  where r.favorite=s.id and favorite not in (select id from user_sources where email='$emaill') and title LIKE '%$searchq%'  
                UNION  
                  select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
                  FROM news_published where title LIKE '%$searchq%'  ");
        } else {//no logged
            if (isset($_COOKIE['urdu_sources'])) {
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` 
                from rss r,rss_sources s  where r.favorite=s.id and favorite NOT IN ( '" . implode("', '", $data) . "' )  and  title LIKE '%$searchq%'  
                UNION  
                  select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
                  FROM news_published where title LIKE '%$searchq%'  ");

                } else {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` 
                from rss r,rss_sources s  where r.favorite=s.id and  title LIKE '%$searchq%'  
                UNION  
                  select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
                  FROM news_published where title LIKE '%$searchq%'  ");

                }
            } else {//no cookie
                $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` 
                from rss r,rss_sources s  where r.favorite=s.id and  title LIKE '%$searchq%'  
                UNION  
                  select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
                  FROM news_published where title LIKE '%$searchq%'  ");

            }

        }
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function NewsToShow($nb)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources rs  where r.favorite=rs.id and favorite not in (select id from user_sources where email='$emaill') and ( media!='' and media not like '%.gif' && media not like '%.GIF') group by title UNION select 1 as rank, id,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` FROM news_published where media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
        } else { //not logged
            if (isset($_COOKIE['urdu_sources'])) {
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources rs  where r.favorite=rs.id and favorite NOT IN ( '" . implode("', '", $data) . "' ) and  ( media!='' and media not like '%.gif' && media not like '%.GIF') group by title UNION select 1 as rank, id,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` FROM news_published where media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
                } else {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources rs  where r.favorite=rs.id and  ( media!='' and media not like '%.gif' && media not like '%.GIF') group by title UNION select 1 as rank, id,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` FROM news_published where media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
                }
            } else {
                $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources rs  where r.favorite=rs.id and  ( media!='' and media not like '%.gif' && media not like '%.GIF') group by title UNION select 1 as rank, id,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` FROM news_published where media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
            }
        }//not logged
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }



//zzz2 


    // get nbr news

    public function hotnews($nb)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $query = $con->query("select 1 as rank, `id`,`title`,`description`,`type`,`media`,`content`,`pubDate`  from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )  UNION select 2 as rank,r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate` 
             from rss r,rss_sources rs where r.favorite=rs.id and favorite not in (select id from user_sources where email='$emaill') and (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
        } else { //not logged
            if (isset($_COOKIE['urdu_sources'])) {
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $query = $con->query("select 1 as rank, `id`,`title`,`description`,`type`,`media`,`content`,`pubDate`  from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )  UNION select 2 as rank,r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate` 
             from rss r,rss_sources rs where r.favorite=rs.id and favorite NOT IN ( '" . implode("', '", $data) . "' ) and (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
                } else {
                    $query = $con->query("select 1 as rank, `id`,`title`,`description`,`type`,`media`,`content`,`pubDate`  from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )  UNION select 2 as rank,r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate` 
             from rss r,rss_sources rs where r.favorite=rs.id and (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
                }
            } else {
                $query = $con->query("select 1 as rank, `id`,`title`,`description`,`type`,`media`,`content`,`pubDate`  from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )  UNION select 2 as rank,r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate` 
             from rss r,rss_sources rs where r.favorite=rs.id and (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
            }
        }
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    // nbrNewsBySourceWithoutMedia

    public function newsStartCountVideos2($nb)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }

        if ($emaill != "") {
            $query = $con->query("select 2 as rank, r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources s  where r.favorite=s.id and favorite not in (select id from user_sources where email='$emaill') and (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) group by title UNION select 1 as rank,`id`,`title`,`description`,`type`,`media`,`content`,`pubDate`,`thumbnail`  FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
        } else {
            if (isset($_COOKIE['urdu_sources'])) {
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources s  where r.favorite=s.id and favorite NOT IN ( '" . implode("', '", $data) . "' )  and (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) group by title UNION select 1 as rank,`id`,`title`,`description`,`type`,`media`,`content`,`pubDate`,`thumbnail`  FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
                } else {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources s  where r.favorite=s.id and  (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) group by title UNION select 1 as rank,`id`,`title`,`description`,`type`,`media`,`content`,`pubDate`,`thumbnail`  FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
                }
            } else {
                $query = $con->query("select 2 as rank, r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources s  where r.favorite=s.id and  (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) group by title UNION select 1 as rank,`id`,`title`,`description`,`type`,`media`,`content`,`pubDate`,`thumbnail`  FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' || media like '%.mkv'|| media like '%.MKV' || media like '%.mpeg' || media like '%.MPEG' || media like '%.mp3'|| media like '%.AC-3'|| media like '%.ac-3' || media like '%.MP3' ) ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
            }
        }
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;

    }

    // nbrNewsBySourceWithoutMedia

    public function getNewsRssByTypeCount($type, $s)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }

        if ($emaill != "") {
            $query = $con->query("
          select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` 
               from rss r,rss_sources s where r.favorite=s.id and favorite not in (select id from user_sources where email='$emaill') and (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )
                and  type='" . $type . "' group by title
                UNION 
          select 1 as  rank,`id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` 
                     FROM news_published  where type='" . $type . "' and media!='' 
                and media not like '%.pdf' and media not like '%.PDF'  
                ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $s);
        } else {
            if (isset($_COOKIE['urdu_sources'])) {
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` 
               from rss r,rss_sources s where r.favorite=s.id and favorite NOT IN ( '" . implode("', '", $data) . "' ) and (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )  and  type='" . $type . "' group by title
                UNION 
                 select 1 as  rank,`id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` 
               FROM news_published  where type='" . $type . "' and media!='' and media not like '%.pdf' and media not like '%.PDF'  
                ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $s);
                } else {
                    $query = $con->query(" select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` 
               from rss r,rss_sources s where r.favorite=s.id and (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )
                and  type='" . $type . "' group by title
                UNION 
                   select 1 as  rank,`id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` 
                     FROM news_published  where type='" . $type . "' and media!='' 
                and media not like '%.pdf' and media not like '%.PDF'  
                ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $s);
                }
            } else {
                $query = $con->query(" select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` 
               from rss r,rss_sources s where r.favorite=s.id and (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )
                and  type='" . $type . "' group by title
                UNION 
                   select 1 as  rank,`id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` 
                     FROM news_published  where type='" . $type . "' and media!='' 
                and media not like '%.pdf' and media not like '%.PDF'  
                ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $s);
            }

        }
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }


    // start , nbrfeeds

    public function nbrNewsBySource($src)
    {
        include("fyipanel/views/connect.php");
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and favorite not in (select id from user_sources where email='$emaill') and type='" . $src . "' and media!='' group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
        } else {
            if (isset($_COOKIE['urdu_sources'])) {//cookie
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and favorite NOT IN ( '" . implode("', '", $data) . "' ) and type='" . $src . "' and media!='' group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
                } else {
                    $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id  and type='" . $src . "' and media!='' group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
                }
            } else {//no cookie
                $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id  and type='" . $src . "' and media!='' group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
            }

        }
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    // start , nbrfeeds

    public function getspecialfeedsBySource($src, $start, $nb)
    {
        $tab = array();
        include("fyipanel/views/connect.php");

        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and favorite not in (select id from user_sources where email='$emaill') and  type='" . $src . "'  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
                         FROM news_published where type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

        } else {//not logged
            if (isset($_COOKIE['urdu_sources'])) {//cookie
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and  favorite NOT IN ( '" . implode("', '", $data) . "' )  and  type='" . $src . "'  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
                         FROM news_published where type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

                } else {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and  type='" . $src . "'  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
                         FROM news_published where type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

                }
            } else {//nookoie

                $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and  type='" . $src . "'  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
                         FROM news_published where type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

            }
        }
        while ($data = $query->fetch())
            $tab[] = $data;
        return $tab;
    }


    // start , nbrfeeds

    public function all_ads()
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from ads ');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function all_rss_sources()
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from rss_sources ');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function all_rss()
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from rss ');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function delete_news_published($id)
    {
        try {
            include("../views/connect.php");
            $con->exec('DELETE FROM news_published where id=' . $id);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    // all

    public function all_news_published()
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from news_published  order by pubDate desc ');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    //

    public function nbrRssTotal()
    {
        include("../views/connect.php");
        $requete = $con->prepare("select count(*) from rss");
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    // add

    public function nbrRssTotalq($title)
    {
        include("../views/connect.php");
        $requete = $con->prepare("select count(*) from rss where title like '%" . $title . "%'");
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }


    //v5

    public function nbrUtilisateursTotal()
    {
        include("../views/connect.php");
        $requete = $con->prepare("select count(*) from utilisateurs");
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public function nbrUtilisateursTotalq($title)
    {
        include("../views/connect.php");
        $requete = $con->prepare("select count(*) from utilisateurs  where name like '%" . $title . "%' or email like '%" . $title . "%' ");
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public function nbrNewsPdf()
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare("select count(*) from news_published  where media like '%.pdf' or media like '%.PDF' ");
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }


    // count of news without images

    public function nbrNewsBySourceWithoutMedia($src)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('select count(*) from news_published  where media="" and type="' . $src . '"');
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public function getspecialfeedsBySourcePdf($start, $nb)
    {
        $tab = array();
        include("fyipanel/views/connect.php");
        $query = $con->query("SELECT * FROM news_published where  media  like '%.pdf' or media like '%.PDF'  order by pubDate DESC LIMIT " . $start . "," . $nb . "");
        while ($data = $query->fetch())
            $tab[] = $data;
        return $tab;
    }

    public function getspecialfeedsBySourceWithoutMedia($src, $start, $nb)
    {
        $tab = array();
        include("fyipanel/views/connect.php");
        $query = $con->query("SELECT * FROM news_published where media='' and type='" . $src . "'  order by pubDate DESC LIMIT " . $start . "," . $nb . "");
        while ($data = $query->fetch())
            $tab[] = $data;
        return $tab;
    }

    // find news by id ***

    public function getNewsWithoutMediaBySource($src, $start, $nb)
    {
        $tab = array();
        include("fyipanel/views/connect.php");
        $query = $con->query("SELECT * FROM news_published where media='' and type='" . $src . "' order by pubDate DESC LIMIT " . $start . "," . $nb);
        while ($data = $query->fetch())
            $tab[] = $data;
        return $tab;
    }

    // find news by id ***

    public function rssVideos()
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("SELECT * FROM news_published where (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' ||  media like '%.mkv'||  media like '%.MKV'  ||  media like '%.mpeg'  ||  media like '%.MPEG'
            ||  media like '%.mp3'||  media like '%.AC-3'||  media like '%.ac-3' || media like '%.MP3' ) order by pubDate desc LIMIT 10 ");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }


    // find news by type ***

    public function update_status_to_publish($id)
    {
        include("../views/connect.php");
        try {
            $con->exec('UPDATE news  set status=-1 where id=' . $id);
            return true;
        } catch (PDOException $e) {
            return false;
        }

    }

    // find news by type ***

    public function update_Date_to_DateOfPublish($datee, $id)
    {
        include("../views/connect.php");
        try {
            $con->exec('UPDATE news_published  set pubDate="' . $datee . '" where id=' . $id);
            return true;
        } catch (PDOException $e) {
            return false;
        }

    }

    public function newsByHeadOfBranch($email)
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from news_published where employee="' . $email . '"  order by pubDate desc');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function add_news($id, $employee)
    {
        include("../views/connect.php");
        try {
            $con->exec('INSERT INTO news_published select * from news where id=' . $id);
            $con->exec('UPDATE news_published set employee="' . $employee . '" where id=' . $id);
            return true;
        } catch (PDOException $e) {
            return false;
        }


    }

    public function getspecialfeeds($start, $nb)
    {
        $tab = array();
        include("../views/connect.php");
        $query = $con->query("select r.*,source,type from rss r,rss_sources rs where r.favorite=rs.id ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");
        while ($data = $query->fetch())
            $tab[] = $data;
        return $tab;
    }

    public function getspecialfeedsq($title, $start, $nb)
    {
        $tab = array();
        include("../views/connect.php");
        $query = $con->query("select r.*,source,type from rss r,rss_sources rs  where r.favorite=rs.id and title like '%" . $title . "%' 
                          ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");
        while ($data = $query->fetch())
            $tab[] = $data;
        return $tab;
    }


    // find news by type ***

    public function findnews($id)
    {
        include("fyipanel/views/connect.php");
        $rqt = $con->query("SELECT * FROM news_published where id=" . $id);
        if ($data = $rqt->fetch()) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->type = $data['type'];
            $this->pubDate = $data['pubDate'];
            $this->media = $data['media'];
            $this->content = $data['content'];
            $this->employee = $data['employee'];
            $this->thumbnail = $data['thumbnail'];
            return $this;
        } else {
            return null;

        }

    }

    // find news by type ***

    public function getOneNews($start)
    {
        include("fyipanel/views/connect.php");
        $rqt = $con->query("SELECT * FROM news_published where media!='' and media not like '%.pdf' and media not like '%.PDF'  order by pubDate desc 
              limit " . $start . ",1");
        if ($data = $rqt->fetch()) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->type = $data['type'];
            $this->pubDate = $data['pubDate'];
            $this->media = $data['media'];
            $this->content = $data['content'];
            $this->employee = $data['employee'];
            return $this;
        } else {
            return null;

        }
    }

    // find news by type ***

    public function getFirstArticleVideo($type, $id)
    {
        include("fyipanel/views/connect.php");
        $query = $con->query("SELECT * FROM news_published where id!=" . $id . " and type='" . $type . "' 
              and  (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' ||  media like '%.mkv'||  media like '%.MKV'  ||  media like '%.mpeg'  ||  media like '%.MPEG') 
              order by pubDate desc  limit 1");
        if ($data = $query->fetch()) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->type = $data['type'];
            $this->pubDate = $data['pubDate'];
            $this->media = $data['media'];
            $this->content = $data['content'];
            $this->employee = $data['employee'];
            return $this;
        } else {
            return null;

        }
    }


    // getFourthArticleImage

    public function getSecondArticleVideo($type, $id, $id2)
    {
        include("fyipanel/views/connect.php");
        $query = $con->query("SELECT * FROM news_published where id!=" . $id . " and id!=" . $id2 . " and type='" . $type . "'   and  (media like '%.mp4' || media like '%.MP4'|| media like '%.webm'|| media like '%.WEBM' || media like '%.flv'|| media like '%.FLV' ||  media like '%.mkv'||  media like '%.MKV'  ||  media like '%.mpeg'  ||  media like '%.MPEG') 
              order by pubDate desc  limit 1");
        if ($data = $query->fetch()) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->type = $data['type'];
            $this->pubDate = $data['pubDate'];
            $this->media = $data['media'];
            $this->content = $data['content'];
            $this->employee = $data['employee'];
            return $this;
        } else {
            return null;

        }
    }


    // find news by type ***

    public function fiveNews($type)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("SELECT * FROM news_published  where type='" . $type . "'
              and  (media like '%.jpg' || media like '%.jpeg' ||media like '%.JPG' || media like '%.JPEG' || media like '%.png' ||  media like '%.gif'   || media like '%.PNG' ||  media like '%.GIF') order by pubDate desc  limit 5");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function getFirstArticleImage($type, $id)
    {
        include("fyipanel/views/connect.php");
        $query = $con->query("SELECT * FROM news_published where id!=" . $id . " and type='" . $type . "' 
              and  (media like '%.jpg' || media like '%.jpeg' ||media like '%.JPG' || media like '%.JPEG' ||
              media like '%.png' ||  media like '%.gif'   || media like '%.PNG' ||  media like '%.GIF') 
              order by pubDate desc  limit 1");

        if ($data = $query->fetch()) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->type = $data['type'];
            $this->pubDate = $data['pubDate'];
            $this->media = $data['media'];
            $this->content = $data['content'];
            $this->employee = $data['employee'];
            return $this;
        } else {
            return null;

        }
    }

    public function getSecondArticleImage($type, $id, $id2)
    {
        include("fyipanel/views/connect.php");
        $query = $con->query("SELECT * FROM news_published where id!=" . $id . " and id!=" . $id2 . " 
                and type='" . $type . "' 
              and  (media like '%.jpg' || media like '%.jpeg' ||media like '%.JPG' || media like '%.JPEG' ||
              media like '%.png' ||  media like '%.gif'   || media like '%.PNG' ||  media like '%.GIF') 
              order by pubDate desc  limit 1");

        if ($data = $query->fetch()) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->type = $data['type'];
            $this->pubDate = $data['pubDate'];
            $this->media = $data['media'];
            $this->content = $data['content'];
            $this->employee = $data['employee'];
            return $this;
        } else {
            return null;

        }
    }

    // get first and last name

    public function getThirdArticleImage($type, $id, $id2, $id3)
    {
        include("fyipanel/views/connect.php");
        $query = $con->query("SELECT * FROM news_published where id!=" . $id . " and id!=" . $id2 . " 
                and id!=" . $id3 . "    and type='" . $type . "' 
              and  (media like '%.jpg' || media like '%.jpeg' ||media like '%.JPG' || media like '%.JPEG' ||
              media like '%.png' ||  media like '%.gif'   || media like '%.PNG' ||  media like '%.GIF') 
              order by pubDate desc  limit 1");
        if ($data = $query->fetch()) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->type = $data['type'];
            $this->pubDate = $data['pubDate'];
            $this->media = $data['media'];
            $this->content = $data['content'];
            $this->employee = $data['employee'];
            return $this;
        } else {
            return null;

        }
    }


    // magazine

    public function getFourthArticleImage($type, $id, $id2, $id3, $id4)
    {
        include("fyipanel/views/connect.php");
        $query = $con->query("SELECT * FROM news_published where id!=" . $id . " and id!=" . $id2 . " 
                and id!=" . $id3 . " and id!=" . $id4 . "   and type='" . $type . "' 
              and  (media like '%.jpg' || media like '%.jpeg' ||media like '%.JPG' || media like '%.JPEG' ||
              media like '%.png' ||  media like '%.gif'   || media like '%.PNG' ||  media like '%.GIF') 
              order by pubDate desc  limit 1");
        if ($data = $query->fetch()) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->description = $data['description'];
            $this->type = $data['type'];
            $this->pubDate = $data['pubDate'];
            $this->media = $data['media'];
            $this->content = $data['content'];
            $this->employee = $data['employee'];
            return $this;
        } else {
            return null;

        }
    }

    public function getNewsByType($type, $s)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("SELECT * FROM news_published where type='" . $type . "' and media!='' and  (
                media like '%.jpg' || media like '%.jpeg' ||media like '%.JPG' || media like '%.JPEG' ||
              media like '%.png' ||  media like '%.gif' || media like '%.mp4' || media like '%.webm' ||
              media like '%.PNG' ||  media like '%.GIF' || media like '%.MP4' || media like '%.WBEM' ||
              media like '%.flv' ||  media like '%.mkv'  ||  media like '%.mpeg'||
              media like '%.FLV' ||  media like '%.MKV'  ||  media like '%.MPEG'
                ) order by pubDate desc 
                limit " . $s . ",1");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }


    //get  typeOfMedia

    public function newsWithoutMedia($nb)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("
                select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` 
                from rss r,rss_sources s  where r.favorite=s.id and media=''  group by title
                UNION  
                  select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate`  
                  FROM news_published  where   media=''  
                ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT " . $nb);
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    // get first and last name

    public function getNewsByTypeCount($type, $s)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("SELECT * FROM news_published where type='" . $type . "' and media!='' 
                and media not like '%.pdf' and media not like '%.PDF' order by pubDate desc 
                limit " . $s);
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    // get first and last name

    public function newsStartCountpdf()
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("SELECT * FROM news_published where (media like '%.PDF' || media like '%.pdf'  ) 
               order by pubDate desc LIMIT 10 ");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    // all users

    public function news()
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from news_published order by pubDate desc');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }


    public function getspecialfeedsBySourceAndCountry($country, $src, $start, $nb)
    {
        $tab = array();
        include("fyipanel/views/connect.php");

        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and s.country='$country' and favorite not in (select id from user_sources where email='$emaill') and  type='" . $src . "'  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
                         FROM news_published where type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

        } else {//not logged
            if (isset($_COOKIE['urdu_sources'])) {//cookie
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and s.country='$country' and  favorite NOT IN ( '" . implode("', '", $data) . "' )  and  type='" . $src . "'  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
                         FROM news_published where type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

                } else {
                    $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and s.country='$country' and  type='" . $src . "'  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
                         FROM news_published where type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

                }
            } else {//nookoie

                $query = $con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and s.country='$country' and  type='" . $src . "'  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
                         FROM news_published where type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

            }
        }
        while ($data = $query->fetch())
            $tab[] = $data;
        return $tab;
    }

    public function nbrNewsBySourceAndCountry($country, $src)
    {
        include("fyipanel/views/connect.php");
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id AND s.country='$country' and favorite not in (select id from user_sources where 
email='$emaill') and type='" . $src . "' 
and media!='' group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
        } else {
            if (isset($_COOKIE['urdu_sources'])) {//cookie
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and s.country='$country' and favorite NOT IN ( '" .
                        implode("', '", $data
                        ) . "' ) and type='" . $src . "' and media!='' group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
                } else {
                    $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and s.country='$country' and type='" . $src . "' and media!='' group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
                }
            } else {//no cookie
                $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id  and s.country='$country' and type='" . $src . "' and media!='' group by title UNION ALL select id FROM news_published where  type='" . $src . "' and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
            }

        }
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public function get_news_item($news_id)
    {
        include("fyipanel/views/connect.php");
        $stmt = $con->prepare("select * from rss where id = :id");
        $stmt->bindParam(':id', $news_id);
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return 'error';
        }
    }

    public function count_category_replies($src)
    {
        include("fyipanel/views/connect.php");
        $stmt = $con->prepare("select count(*) as total from news_published where right_of_reply_id > 0 and type = '$src' ");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function nbrBreakingNews()
    {
        include("fyipanel/views/connect.php");
        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and title like '%Breaking News%' and r.favorite not in (select id from user_sources where 
email='$emaill') group by
 title )x");
        } else {
            if (isset($_COOKIE['urdu_sources'])) { //cookie
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and title like '%Breaking News%' and favorite NOT IN ( '" . implode("', '", $data) . "' )  group by title )x");
                } else {
                    $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id  and title like '%Breaking News%' group by title )x");
                }
            } else {//no cookie
                $requete = $con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id  and title like '%Breaking News%' group by title )x");
            }

        }
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public function getspecialfeedsBreakingNews($start, $nb)
    {
        $tab = array();
        include("fyipanel/views/connect.php");

        $emaill = "";
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_email'])) {
            $emaill = $_COOKIE['fyiuser_email'];
        } else if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_email'])) {
            $emaill = $_SESSION['user_auth']['user_email'];
        }
        if ($emaill != "") {
            $query = $con->query("select r.id,`title`,`media`,`link`,`pubDate`,description,`Source` from rss r, rss_sources s  where r.favorite=s.id and title like '%Breaking News%' and favorite not in (select id from user_sources where 
email='$emaill') ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

        } else {//not logged
            if (isset($_COOKIE['urdu_sources'])) {//cookie
                $data = json_decode($_COOKIE['urdu_sources'], true);
                if (count($data) > 0) {
                    $query = $con->query("select  r.id,`title`,`media`,`link`,`pubDate`,description,`Source` from rss r, rss_sources s  where r.favorite=s.id and title like '%Breaking News%' and  favorite NOT IN ( '" .
                        implode("', '", $data) . "' )  ORDER BY 
UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");
                } else {
                    $query = $con->query("select r.id,`title`,`media`,`link`,`pubDate`,description,`Source` from rss r, rss_sources s  where r.favorite=s.id and title like '%Breaking News%' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

                }
            } else {//nookoie

                $query = $con->query("select r.id,`title`,`media`,`link`,`pubDate`,description,`Source` from rss r, rss_sources s  where r.favorite=s.id and title like '%Breaking News%' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");

            }
        }
        while ($data = $query->fetch())
            $tab[] = $data;
        return $tab;
    }

    public function getCategoryReplies($src, $start, $nb)
    {
        include("fyipanel/views/connect.php");
        $stmt = $con->prepare("select * from news_published where right_of_reply_id > 0 and type = '$src' order by id  desc LIMIT " . $start . "," . $nb . "");
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function get_news_reply_link($reply_id)
    {
        include("fyipanel/views/connect.php");
        $stmt = $con->prepare("select reply_to_link from rss_right_of_reply where id = '$reply_id'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function get_right_of_reply_video($reply_id)
    {
        include("fyipanel/views/connect.php");
        $stmt = $con->prepare("select video from rss_right_of_reply where id = '$reply_id'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

}

?>