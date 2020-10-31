<?php

class Queries{
    private $con, $domain, $root;

    function __construct($lang, $domain, $root)
    {
        require_once 'Connection.php';
        $db = new Connection($lang);

        $this->con = $db->connect();
        $this->domain = $domain;
        $this->root = $root;
    }

    public function get_countries(){
        $stmt = $this->con->prepare("SELECT id, country FROM rss_sources GROUP BY country");
        if($stmt->execute()){
            $countries = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $country['country_name'] = $row['country'];
                $country['flag'] = $this->root.'v2/countries/'.$row['country'].'.png';
                $countries[] = $country;
                unset($country);
                $country = array();
            }
            return $countries;
        }
        else{
            return "no countries";
        }
    }

    public function get_country_sources($country){
        $stmt = $this->con->prepare("SELECT * FROM rss_sources where status = 1 and country = :country");
        $stmt->bindParam(':country', $country);
        if($stmt->execute()){
            $sources = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $source['country_name'] = $row['country'];
                //$source['source_id'] = $row['id'];
                $source['source_name'] = $row['source'];
                $source['type'] = $row['type'];
                $source['flag'] = $this->root.'v2/countries/'.$row['country'].'.png';
                $source['source_logo'] = $this->root.'v2/sources/'.$row['source'].'.png';
                $sources[] = $source;
                unset($source);
                $source = array();
            }
            return $sources;
        }
        else{
            return "no sources";
        }
    }

    public function get_all_category_news($email, $category){

        if($email !== ''){
            $stmt = $this->con->prepare("SELECT 2 AS RANK, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` 
FROM rss r, rss_sources s  WHERE r.favorite=s.id AND favorite NOT IN (SELECT id FROM user_sources WHERE email = :email) 
 AND  TYPE = :cat  AND media!='' GROUP BY title UNION SELECT 1 AS RANK, `id`,`title`,`description`,`type`,`type`,
 `media`, `type`,`pubDate`,' || '`thumbnail` FROM news_published WHERE TYPE=:cat AND media!='' 
 AND media NOT LIKE '%.pdf' AND media NOT LIKE '%.PDF'");
            $stmt->bindParam(':email', $email);
        }
        else{
            $stmt = $this->con->prepare("SELECT 2 AS RANK, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` FROM rss r, rss_sources s  WHERE r.favorite=s.id AND  TYPE=:cat  AND media!='' 
GROUP BY title UNION SELECT 1 AS RANK, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,
`thumbnail` FROM news_published WHERE TYPE=:cat AND media!='' AND media NOT LIKE '%.pdf' AND media 
NOT LIKE '%.PDF'");
        }

        $stmt->bindParam(':cat', $category);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        else{
            return "no news";
        }
    }

    public function get_category_news($email, $category, $offset, $ppage){
        if($email == ''){
            $stmt = $this->con->prepare("SELECT 2 AS RANK, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` FROM rss r, 
rss_sources s  WHERE r.favorite=s.id AND  TYPE=:cat  AND media!='' 
GROUP BY title UNION SELECT 1 AS RANK, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,
`thumbnail` FROM news_published WHERE TYPE=:cat AND media!='' AND media NOT LIKE '%.pdf' AND media 
NOT LIKE '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) DESC  LIMIT :offset , :ppage");

        }
        else{
            $stmt = $this->con->prepare("SELECT 2 AS RANK, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` 
FROM rss r, rss_sources s  WHERE r.favorite=s.id AND favorite NOT IN (SELECT id FROM user_sources WHERE email = :email) 
 AND  TYPE = :cat  AND media!='' GROUP BY title UNION SELECT 1 AS RANK, `id`,`title`,`description`,`type`,`type`,
 `media`, `type`,`pubDate`,' || '`thumbnail` FROM news_published WHERE TYPE=:cat AND media!='' 
 AND media NOT LIKE '%.pdf' AND media NOT LIKE '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT :offset , :ppage");
            $stmt->bindParam(':email', $email);
        }

        $stmt->bindParam(':cat', $category);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->bindValue(':ppage', (int) $ppage, PDO::PARAM_INT);

        if($stmt->execute()){
            $news = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $item = array();
                $item['id'] = $row['id'];
                $item['title'] = $row['title'];
                $item['description'] = $row['description'];
                $item['source'] = $row['Source'];
                if($row['Source'] == 'News' || $row['Source'] == 'Sports' || $row['Source'] == 'Technology' || $row['Source'] == 'Arts' || $row['Source'] == 'General Culture'){
                    $item['source_logo'] = '';
                }
                else{

                    $item['source_logo'] = $this->root.'v2/sources/'.$row['Source'].'.png';
                }

                $item['image'] = $row['media'];
                $item['link'] = $row['link'];
                $item['pubDate'] = $row['pubDate'];

                $item['rank'] = $row['RANK'];
                $news[] = $item;
                unset($item);
                $item = array();
            }
            return $news;
        }
        else{
            return "no news";
        }
    }

    public function check_user_exists($email){
        $stmt = $this->con->prepare("select * from utilisateurs where email= :email");
        $stmt->bindParam(':email', $email);
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                return 1;
            }
            else{
                return 0;
            }
        }
        else{
            return 'error';
        }
    }

    public function check_fav_country($email,$country){
        $sql = $this->con->prepare("SELECT count(*) FROM `rss_sources` WHERE `country`=:country and id not IN (select id from user_sources where email=:email)");
        $sql->bindParam('country', $country);
        $sql->bindParam('email', $email);
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public function get_user_row($email){
        $q = $this->con->prepare("select * from utilisateurs where email = :email");
        $q->bindParam(':email', $email);
        if($q->execute()){
            $row = $q->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
    }

    public function insert_comment($email, $comment, $media, $time, $news_id, $to_comment_id, $rank){
        if($rank == 2){
            if($to_comment_id == 0){
                $stmt = $this->con->prepare("insert into rss_comments (response, media, time, id_news, email_user) values (:comment, :media, :time, :news_id, :email)");
            }
            else{
                $stmt = $this->con->prepare("insert into rss_replies (response, media, time, id_news, email_user, id_comment) values (:comment, :media, :time, :news_id, :email, :comment_id)");
                $stmt->bindParam(':comment_id', $to_comment_id);
            }
        }
        else{
            if($to_comment_id == 0){
                $stmt = $this->con->prepare("insert into comments (response, media, time, id_news, email_user) values (:comment, :media, :time, :news_id, :email)");
            }
            else{
                $stmt = $this->con->prepare("insert into replies (response, media, time, id_news, email_user, id_comment) values (:comment, :media, :time, :news_id, :email, :comment_id)");
                $stmt->bindParam(':comment_id', $to_comment_id);
            }
        }

        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':media', $media);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':news_id', $news_id);
        $stmt->bindParam(':email', $email);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function check_if_comment_id_exists($to_comment_id, $rank){
        if($rank == 2){
            $stmt = $this->con->prepare("select * from rss_comments where id = :id");
        }
        else{
            $stmt = $this->con->prepare("select * from comments where id = :id");
        }

        $stmt->bindParam(':id', $to_comment_id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function get_news_item($news_id, $rank){
        if($rank == 2){
            $stmt = $this->con->prepare("select *,rss.id as news_id from rss join rss_sources where rss.favorite = rss_sources.id and rss.id = :id");
        }
        else{
            $stmt = $this->con->prepare("select *,id as news_id from news_published where id = :id");
        }

        $stmt->bindParam(':id', $news_id);
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        else{
            return 'error';
        }
    }

    public function count_news_comments($news_id){
        $stmt = $this->con->prepare("SELECT
  (SELECT COUNT(*) FROM rss_comments WHERE id_news=:id) AS total_comments, 
  (SELECT COUNT(*) FROM rss_replies WHERE id_news=:id) AS total_replies");
        $stmt->bindParam(':id', $news_id);
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        else{
            echo 'error';
        }
    }

    public function count_panel_news_comments($news_id){
        $stmt = $this->con->prepare("SELECT
  (SELECT COUNT(*) FROM comments WHERE id_news=:id) AS total_comments, 
  (SELECT COUNT(*) FROM replies WHERE id_news=:id) AS total_replies");
        $stmt->bindParam(':id', $news_id);
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        else{
            echo 'error';
        }
    }

    public function get_news_comments($news_id){
        $stmt = $this->con->prepare("select * from rss join rss_comments join utilisateurs where rss.id = rss_comments.id_news and rss_comments.email_user = utilisateurs.email and rss.id = :id order by rss_comments
.id desc");
        $stmt->bindParam(':id', $news_id);
        if($stmt->execute()){
            $comments = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data = array();
                $data['comment_id'] = $row['id'];
                $data['comment'] = $row['response'];
                $data['time'] = $row['time'];
                $data['name'] = $row['name'];
                $data['media'] = $this->domain.'arabic/images/rss_comments/'.$row['media'];
                $comments[] = $data;
                unset($data);
            }
            return $comments;
        }
        else{
            return 'error';
        }
    }

    public function get_panel_news_comments($news_id){
        $stmt = $this->con->prepare("select *, comments.media as comment_media from news_published join comments join utilisateurs where news_published.id = comments.id_news and comments.email_user = utilisateurs.email and news_published.id = :id order by comments.id desc");
        $stmt->bindParam(':id', $news_id);
        if($stmt->execute()){
            $comments = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data = array();
                $data['comment_id'] = $row['id'];
                $data['comment'] = $row['response'];
                $data['time'] = $row['time'];
                $data['name'] = $row['name'];
                if(strlen($row['media']) > 0){
                    $data['media'] = $this->domain.'arabic/images/comments/'.$row['comment_media'];
                }
                else{
                    $data['media'] ='';
                }

                $comments[] = $data;
                unset($data);
            }
            return $comments;
        }
        else{
            return 'error';
        }
    }

    public function get_comment_replies($comment_id){
        $stmt = $this->con->prepare("SELECT * FROM rss_replies JOIN utilisateurs WHERE rss_replies.email_user = utilisateurs.email AND rss_replies.id_comment = :id ORDER BY rss_replies.id ");
        $stmt->bindParam(':id', $comment_id);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $replies = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $reply = array();
                    $reply['reply_id'] = $row['id'];
                    $reply['reply'] = $row['response'];
                    $reply['time'] = $row['time'];
                    $reply['name'] = $row['name'];
                    $reply['media'] = $this->domain.'arabic/images/rss_replies/'.$row['media'];
                    $replies[] = $reply;
                    unset($reply);
                }
                return $replies;
            }
            else{
                return 0;
            }
        }
        else{
            return 'error';
        }
    }

    public function get_panel_comment_replies($comment_id){
        $stmt = $this->con->prepare("SELECT * FROM replies JOIN utilisateurs WHERE replies.email_user = utilisateurs.email AND replies.id_comment = :id ORDER BY replies.id ");
        $stmt->bindParam(':id', $comment_id);
        if($stmt->execute()){
            if($stmt->rowCount() > 0){
                $replies = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $reply = array();
                    $reply['reply_id'] = $row['id'];
                    $reply['reply'] = $row['response'];
                    $reply['time'] = $row['time'];
                    $reply['name'] = $row['name'];
                    if(trim($row['media']) !== ''){
                        $reply['media'] = $this->domain.'arabic/images/replies/'.$row['media'];
                    }
                    else{
                        $reply['media'] = '';
                    }

                    $replies[] = $reply;
                    unset($reply);
                }
                return $replies;
            }
            else{
                return 0;
            }
        }
        else{
            return 'error';
        }
    }

    public function get_comment_row($comment_id, $rank){
        if($rank == 2){
            $stmt = $this->con->prepare("select * from rss_comments where id = :id");
        }
        else{
            $stmt = $this->con->prepare("select * from comments where id = :id");
        }

        $stmt->bindParam('id', $comment_id);
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        else{
            return 'error';
        }
    }

    public function get_reply_row($reply_id, $rank){
        if($rank == 2){
            $stmt = $this->con->prepare("select * from rss_replies where id = :id");
        }
        else{
            $stmt = $this->con->prepare("select * from replies where id = :id");
        }

        $stmt->bindParam('id', $reply_id);
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        else{
            return 'error';
        }
    }

    public function check_if_user_reported_comment($email, $comment_id, $rank){
        if($rank == 2){
            $stmt = $this->con->prepare("select * from rss_report where email_user_report = :email and id_comment = :id");
        }
        else{
            $stmt = $this->con->prepare("select * from report where email_user_report = :email and id_comment = :id");
        }

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $comment_id);
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        else{
            return 'error';
        }
    }

    public function check_if_user_reported_panel_comment($email, $comment_id){
        $stmt = $this->con->prepare("select * from report where email_user_report = :email and id_comment = :id");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $comment_id);
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        else{
            return 'error';
        }
    }

    public function check_if_user_reported_reply($email, $reply_id, $rank){
        if($rank == 2){
            $stmt = $this->con->prepare("select * from rss_report where email_user_report = :email and id_reply = :id");
        }
        else{
            $stmt = $this->con->prepare("select * from report where email_user_report = :email and id_reply = :id");
        }

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $reply_id);
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        else{
            return $stmt->errorInfo();
        }
    }

    public function check_if_user_reported_panel_reply($email, $reply_id){
        $stmt = $this->con->prepare("select * from report where email_user_report = :email and id_reply = :id");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $reply_id);
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        else{
            return $stmt->errorInfo();
        }
    }

    public function add_report($news_id, $time, $email, $owner, $type, $other, $comment_id, $reply_id, $rank){
        if($rank == 2){
            $stmt = $this->con->prepare("insert into rss_report (id_news, email_user_report, email_user_abuse, id_comment, id_reply, date_report, type, other) values(:news_id, :email, :owner, :comment_id, :reply_id, :date, :type, :other)");
        }
        else{
            $stmt = $this->con->prepare("insert into report (id_news, email_user_report, email_user_abuse, id_comment, id_reply, date_report, type, other) values(:news_id, :email, :owner, :comment_id, :reply_id, :date, :type, :other)");
        }

        $stmt->bindParam(':news_id', $news_id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':owner', $owner);
        $stmt->bindParam(':comment_id', $comment_id);
        $stmt->bindParam(':reply_id', $reply_id);
        $stmt->bindParam(':date', $time);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':other', $other);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function hot_news($email, $offset, $ppage){
        if($email == ''){
            $stmt = $this->con->prepare("select 1 as rank, `id`,`title`,`description`,`type`,`media`,`content`,`pubDate`  from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )  UNION select 2 as rank,r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate` 
             from rss r,rss_sources rs where r.favorite=rs.id and (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT :offset , :ppage");
        }
        else{
            $stmt = $this->con->prepare("select 1 as rank, `id`,`title`,`description`,`type`,`media`,`content`,`pubDate`  from news_published where (media like '%.jpg' || media like '%.jpeg' || media like '%.png' || media like '%.JPEG' || media like '%.PNG' || media like '%.JPG' )  UNION select 2 as rank,r.id,`title`,`description`,`Source`,`media`,`link`,`pubDate` 
             from rss r,rss_sources rs where r.favorite=rs.id and favorite not in (select id from user_sources where email=:email) and (media like '%.jpg' ||media like '%.jpeg' || media like '%.png' || media like '%.gif' || media like '%.JPEG' ||media like '%.PNG' || media like '%.GIF' || media like '%.JPG')  group by title ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT :offset , :ppage");
            $stmt->bindParam(':email', $email);
        }

        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->bindValue(':ppage', (int) $ppage, PDO::PARAM_INT);

        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        else{
            return 'error';
        }
    }

    public function get_information(){
        $stmt = $this->con->prepare("select * from footer where id = :one");
        $stmt->bindValue(':one', 1);
        if($stmt->execute()){
            $row = $stmt->fetch();
            return $row;
        }
        else{
            return 'error';
        }
    }

    public function count_search($email, $string){
        $string = "%".$string."%";

        if($email == ''){
            $stmt = $this->con->prepare("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` from rss r,rss_sources s  where r.favorite=s.id and  title LIKE :string UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate` FROM news_published where title LIKE :string ");
        }
        else{
            $stmt = $this->con->prepare("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` from rss r,rss_sources s  where r.favorite=s.id and favorite not in (select id from user_sources where email=:email) and title LIKE :string UNION select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate` FROM news_published where title LIKE :string  ");
            $stmt->bindParam(':email', $email);
        }
        $stmt->bindParam(':string', $string);
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        else{
            return 'error';
        }
    }

    public function search($email, $string, $offset, $limit){
        $string = "%".$string."%";

        if($email == ''){
            $stmt = $this->con->prepare("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` from rss r,rss_sources s  where r.favorite=s.id and  title LIKE :string UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate` FROM news_published where title LIKE :string ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT :offset , :ppage");
        }
        else{
            $stmt = $this->con->prepare("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`link`,`pubDate` from rss r,rss_sources s  where r.favorite=s.id and favorite not in (select id from user_sources where email=:email) and title LIKE :string UNION select 1 as  rank, `id`,`title`,`description`,`type`,`type`,`type`,`pubDate` FROM news_published where title LIKE :string  ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT :offset , :ppage");
            $stmt->bindParam(':email', $email);
        }
        $stmt->bindParam(':string', $string);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->bindValue(':ppage', (int) $limit, PDO::PARAM_INT);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        else{
            return 'error';
        }
    }

    public function get_right_of_reply($id){
        $stmt = $this->con->prepare("select * from rss_right_of_reply where id = '$id'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function add_right_of_reply($news_id, $user_email, $reply_title, $user_image, $uploaded_image, $created_at, $user_phone, $message_to_mentor, $reply, $reply_to_link,
                                       $tbl, $video){
        $stmt = $this->con->prepare("insert into rss_right_of_reply (news_id, user_email, reply_title, user_image, uploaded_image, created_at, user_phone, message_to_mentor, reply, reply_to_link, tbl, video) values
(:news_id, :user_email, :reply_title, :user_image, :uploaded_image, :created_at, :user_phone, :message_to_mentor, '$reply', :reply_to_link, :tbl, :video) ");
        $stmt->bindParam(':news_id', $news_id);
        $stmt->bindParam(':user_email', $user_email);
        $stmt->bindParam(':reply_title', $reply_title);
        $stmt->bindParam(':user_image', $user_image);
        $stmt->bindParam(':uploaded_image', $uploaded_image);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':user_phone', $user_phone);
        $stmt->bindParam(':message_to_mentor', $message_to_mentor);
        //$stmt->bindParam(':reply', $reply);
        $stmt->bindParam(':reply_to_link', $reply_to_link);
        $stmt->bindParam(':tbl', $tbl);
        $stmt->bindParam(':video', $video);
        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    public function get_news_right_of_reply($news_id){
        $stmt = $this->con->prepare("select * from rss join rss_right_of_reply join utilisateurs where rss.id = rss_right_of_reply.news_id and rss_right_of_reply.user_email = utilisateurs.email and rss.id = :id and
 rss_right_of_reply.status = '1' order by rss_right_of_reply.id desc");
        $stmt->bindParam(':id', $news_id);
        if($stmt->execute()){
            $comments = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data = array();
                $data['id'] = $row['id'];
                $data['reply'] = $row['reply'];
                $data['reply_title'] = $row['reply_title'];
                $data['time'] = $row['created_at'];
                $data['name'] = $row['name'];
                /*$data['user_image'] = $row['user_image'];
                $data['reply_image'] = $row['uploaded_image'];*/
                $comments[] = $data;
                unset($data);
            }
            return $comments;
        }
        else{
            return 'comments error';
        }
    }

    public function slideshow($email, $limit){

        $tab=array();

        if($email !== ""){
            $query=$this->con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources rs  where r.favorite=rs.id and favorite not in (select id from user_sources where email='$email') and ( media!='' and media not like '%.gif' && media not like '%.GIF') group by title UNION select 1 as rank, id,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` FROM news_published where media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT ".$limit);
        }

        else{ //not logged

            $query=$this->con->query("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r,rss_sources rs  where r.favorite=rs.id and  ( media!='' and media not like '%.gif' && media not like '%.GIF') group by title UNION select 1 as rank, id,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` FROM news_published where media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT ".$limit);

        }//not logged
        while ($data = $query->fetch()){
            $tab[] = $data;
        }
        return $tab;
    }

    function total_comments($news_id){
        $requete = $this->con->prepare('SELECT COUNT(*)  FROM comments where id_news='.$news_id);
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        $rek = $this->con->prepare('SELECT COUNT(*)  FROM replies where id_news='.$news_id);
        $rek->execute();
        $nb_res2 = $rek->fetchColumn();
        $c=$nb_res+$nb_res2;
        return  $c ;
    }

    public function nbrNewsBySourceAndCountry($email, $country, $src){

        if($email!==""){
            $stmt = $this->con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id AND s.country=:country and favorite not in (select id from user_sources where 
email=:email) and type = :src 
and media!='' group by title UNION ALL select id FROM news_published where  type=:src and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
            $stmt->bindParam(':email', $email);
        }
        else{
            $stmt = $this->con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id  and s.country=:country and type=:src and media!='' group by title UNION ALL select id FROM news_published where  type=:src and media!='' and media not like '%.pdf' and media not like '%.PDF' )x");
        }
        $stmt->bindParam(':src', $src);
        $stmt->bindParam(':country', $country);
        $stmt->execute();
        $nbrfeeds = $stmt->fetchColumn();
        return  $nbrfeeds ;
    }

    public function getspecialfeedsBySourceAndCountry($email, $country,$src,$start,$nb){

        if($email!=""){
            $query=$this->con->prepare("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and s.country=:country and favorite not in (select id from user_sources where email=:email) and  type=:src  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail`
FROM news_published where type=:src and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT ".$start.",".$nb."");
            $query->bindParam(':email', $email);
        }
        else{//not logged
            $query=$this->con->prepare("select 2 as rank, r.id,`title`,`description`,`type`,`Source`,`media`,`link`,`pubDate`,`thumbnail` from rss r, rss_sources s  where r.favorite=s.id and s.country=:country and  type=:src  and media!='' group by title UNION select 1 as rank, `id`,`title`,`description`,`type`,`type`,`media`,`type`,`pubDate`,`thumbnail` FROM news_published where type=:src and media!='' and media not like '%.pdf' and media not like '%.PDF' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT ".$start.",".$nb."");
        }
        $query->bindParam(':src', $src);
        $query->bindParam(':country', $country);
        $query->execute();
        return $query->fetchAll();
    }

    function count_category_replies($src){
        $stmt = $this->con->prepare("select count(*) as total from news_published where right_of_reply_id > 0 and type = '$src' ");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function getCategoryReplies($src, $start, $nb){
        $stmt = $this->con->prepare("select * from news_published where right_of_reply_id > 0 and type = '$src' order by id  desc LIMIT " . $start . "," . $nb . "");
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data;
    }

    public function nbrBreakingNews($emaill)
    {

        if ($emaill != "") {
            $requete = $this->con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id and title like '%عاجل%' and r.favorite not in (select id from user_sources where 
email='$emaill') group by
 title )x");
        }
        else {
            $requete = $this->con->prepare("select count(*) from (select r.id from rss r,rss_sources s where r.favorite=s.id  and title like '%عاجل%' group by title )x");
        }
        $requete->execute();
        $nbrfeeds = $requete->fetchColumn();
        return $nbrfeeds;
    }

    public function getspecialfeedsBreakingNews($emaill, $start, $nb)
    {
        $tab = array();

        if ($emaill != "") {
            $query = $this->con->query("select r.id,`title`,`media`,`link`,`pubDate`,description,`Source` from rss r, rss_sources s  where r.favorite=s.id and title like '%عاجل%' and favorite not in (select id from user_sources where 
email='$emaill') ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");
        }
        else {
            $query = $this->con->query("select r.id,`title`,`media`,`link`,`pubDate`,description,`Source` from rss r, rss_sources s  where r.favorite=s.id and title like '%عاجل%' ORDER BY UNIX_TIMESTAMP(pubDate) desc LIMIT " . $start . "," . $nb . "");
        }
        while ($data = $query->fetch())
            $tab[] = $data;
        return $tab;
    }

    public function get_twitter_accounts(){
        $stmt = $this->con->prepare("select * from rss_sources where twitter like '@%'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function fix_twitter_account($account,$value){
        $stmt = $this->con->prepare("update rss_sources set twitter = '$value' where twitter = '$account'");
        $stmt->execute();
    }

    public function count_fyi_news($category){
        $stmt = $this->con->prepare("select count(*) as total from news_published where type = :category");
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function get_fyi_news($category, $offset, $ppage){
        $stmt = $this->con->prepare("select * from news_published where type = :category ORDER BY UNIX_TIMESTAMP(pubDate) DESC LIMIT :offset , :ppage");
        $stmt->bindParam(':category', $category);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->bindValue(':ppage', (int) $ppage, PDO::PARAM_INT);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        else{
            return 'error';
        }
    }
}