<?php

class UtilisateursModel
{
    private $email;
    private $name;
    private $password;
    private $isEmailConfirmed;
    private $token;
    private $con;
    private $lang;

    function __construct($lang)
    {
        $this->lang = $lang;
        require 'Connection2.php';
        $db = new Connection2($lang);
        $this->con = $db->connect();

    }

    //getters
    public function getemail()
    {
        return $this->email;
    }

    public function getname()
    {
        return $this->name;
    }

    public function getpassword()
    {
        return $this->password;
    }

    public function getisEmailConfirmed()
    {
        return $this->isEmailConfirmed;
    }

    public function gettoken()
    {
        return $this->token;
    }

    /* setters 	*/
    public function setemail($value)
    {
        $this->email = $value;

    }

    public function setname($value)
    {
        $this->name = $value;
    }

    public function setpassword($value)
    {
        $this->password = $value;
    }

    public function setisEmailConfirmed($value)
    {
        $this->isEmailConfirmed = $value;
    }

    public function settoken($value)
    {
        $this->token = $value;
    }

    public function email_non_confirmed_existe($email, $token)
    {

        $sql = $this->con->prepare("SELECT email FROM utilisateurs WHERE email='$email' AND token='$token' AND isEmailConfirmed=0");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public function user_token_existe($email, $token)
    {

        $sql = $this->con->prepare("SELECT email FROM utilisateurs WHERE email='$email'
                   AND token='$token' AND  isEmailConfirmed=0");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public function get_nb_rss_source()
    {

        $sql = $this->con->prepare("SELECT count(*) FROM rss_sources ");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public function nb_sources_not_checked($email)
    {

        $sql = $this->con->prepare("SELECT count(*) FROM user_sources WHERE email='$email' ");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public function get_countries()
    {

        $tab = array();
        $query = $this->con->query('select  distinct country from rss_sources ');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function get_sources_of_country($country)
    {

        $tab = array();
        $query = $this->con->query('select  distinct source from rss_sources where country = "' . $country . '"');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function get_types_of_country_and_source($country, $source)
    {

        $tab = array();
        $query = $this->con->query('select * from rss_sources WHERE country= "' . $country . '"
             AND source="' . $source . '"');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function check_source($email, $id)
    {

        $sql = $this->con->prepare("SELECT email FROM user_sources WHERE email='$email' AND id='$id' ");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public function get_id_rss_source($country, $source, $type)
    {

        $sql = $this->con->prepare("SELECT id FROM rss_sources WHERE country='$country' AND source='$source' AND type='$type' ");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public function add_user_sources($email, $id)
    {

        $this->con->exec('INSERT INTO user_sources VALUES ("' . $email . '","' . $id . '")');
    }

    public function delete_user_sources($email, $id)
    {

        $this->con->exec("DELETE FROM user_sources WHERE email='$email' AND id='$id' ");
    }

    public function confirm_email($email)
    {
        //arabic
        include("../arabic/fyipanel/views/connect.php");
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");
        //$con->exec("INSERT INTO language_users SELECT * from utilisateurs WHERE email='" . $email . "'");
        //english
        include '../fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");
        //spanish
        include '../spanish/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");
        //turkish
        include '../turkish/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");
        //chinese
        include '../chinese/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");
        //russian
        include '../russian/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");
        //french
        include '../french/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");

        include '../indian/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");

        include '../urdu/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");

        include '../hebrew/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");

        include '../german/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");

        include '../japanese/fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");
    }

    public function update_token_pass_user($email, $newpass)
    {
        //ar
        include("../arabic/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');
        //en
        include("../fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');
        //sp
        include("../spanish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');
        //tr
        include("../turkish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');
        //chinese
        include("../chinese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');
        //russian
        include("../russian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');
        //french
        include("../french/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');

        include("../indian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');

        include("../urdu/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');

        include("../hebrew/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');

        include("../japanese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');

        include("../german/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '",isEmailConfirmed=1 WHERE email = "' . $email . '"');
    }

    public function update_token_pass_whitout_conf_user($email, $newpass)
    {
        //ar
        include("../arabic/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');
        //en
        include("../fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');
        //sp
        include("../spanish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');
        //tr
        include("../turkish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');
        //chinese
        include("../chinese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');
        //russian
        include("../russian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');
        //french
        include("../french/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../indian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../urdu/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../hebrew/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../german/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../japanese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET token="", Password="' . $newpass . '" WHERE email = "' . $email . '"');
    }

    public function add_utilisateur($pass)
    {
        //english
        include("../fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');

        // arabic
        include("../arabic/fyipanel/views/connect.php");
        $con->exec('INSERT IGNORE INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //print_r($this->con->errorInfo());
        //spanish
        include("../spanish/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //tr
        include("../turkish/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //chinese
        include("../chinese/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //russian
        include("../russian/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //french
        include("../french/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //in
        include("../indian/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //ur
        include("../urdu/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //hb
        include("../hebrew/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //ur
        include("../german/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');

        include("../japanese/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' . $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
    }

    public function update_token($email, $token)
    {
        //arabic
        include("../arabic/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //english
        include("../fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //spanish
        include("../spanish/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //tr
        include("../turkish/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //chinese
        include("../chinese/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //russian
        include("../russian/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //french
        include("../french/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../indian/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../urdu/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../hebrew/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../german/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../japanese/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  token="' . $token . '"   WHERE email = "' . $email . '"');
    }

    public function update_token_pass($email, $newpass)
    {
        //arabic
        include("../arabic/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');
        //english
        include("../fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');
        //spanish
        include("../spanish/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');
        //tr
        include("../turkish/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');
        //chinese
        include("../chinese/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');
        //russian
        include("../russian/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');
        //french
        include("../french/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../indian/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../urdu/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../hebrew/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../german/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');

        include("../japanese/fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET token="", password="' . $newpass . '" WHERE email = "' . $email . '"');
    }

    //active_status
    public function active_status($email)
    {
        //ar
        include("../arabic/fyipanel/views/connect.php");
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');

        //en
        include('../fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');
        //es
        include('../spanish/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');
        //tr
        include('../turkish/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');
        //chinese
        include('../chinese/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');
        //ru
        include('../russian/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');
        //french
        include('../french/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');

        include('../indian/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');

        include('../urdu/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');

        include('../hebrew/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');

        include('../german/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');

        include('../japanese/fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=1 where email="' . $email . '"');
    }

    public function getLink($at)
    {

        $requete = $this->con->prepare('select ' . $at . ' from links where id=1');
        $requete->execute();
        return $requete->fetchColumn();
    }

    public function info($at)
    {

        $requete = $this->con->prepare('select ' . $at . ' from account where id=1');
        $requete->execute();
        return $requete->fetchColumn();
    }

    public function info2($at)
    {
        ;
        $requete = $this->con->prepare('select ' . $at . ' from account where id=1');
        $requete->execute();
        return $requete->fetchColumn();
    }

    // all users
    public function utilisateurs()
    {
        include("../views/connect.php");
        $tab = array();
        $query = $this->con->query('select * from utilisateurs');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function update_user($email)
    {

        $this->con->exec('UPDATE utilisateurs SET  name="' . $this->name . '",password="' . $this->password . '"  WHERE email = "' . $email . '"');
    }

    public function update_user_photo($photo, $email){
        $this->con->exec("UPDATE utilisateurs SET  image='$photo'  WHERE email = '$email' ");
    }

    public function source($word)
    {
        $source = "";
        if ($word == "cnn") $source = "سي ان ان";
        else if ($word == "aljazeera") $source = "الجزيرة";
        else if ($word == "alwatanvoice") $source = "دنيا الوطن";
        else if ($word == "bbc") $source = " بي بي سي  ";
        else if ($word == "radiosawa") $source = "  راديو سوا   ";
        else if ($word == "aawsat") $source = "  الشرق الاوسط  ";
        else if ($word == "alraimedia") $source = "  الراي ";
        else if ($word == "masralarabia") $source = " مصر العربية  ";
        else if ($word == "arabi21") $source = " عربي 21 ";
        else if ($word == "Anadolu Agency") $source = " وكالة الأناضول ";
        else if ($word == "alarab_qa") $source = " العرب القطرية ";
        else if ($word == "yenisafak") $source = " يني شفق العربية ";
        else if ($word == "alsopar") $source = " صحيفة السوبر ";
        else if ($word == "alblaad") $source = " وكالة البلاد للانباء ";
        else if ($word == "skynewsarabia") $source = " سكاي نيوز  ";
        else if ($word == "france24") $source = " فرانس 24 ";
        else if ($word == "arabicpost") $source = " عربي بوست ";
        else if ($word == "arabianbusiness") $source = " أريبيان بزنس ";
        else if ($word == "As Arabia") $source = "As Arabia";
        else if ($word == "RT Arabic") $source = "RT Arabic";
        else if ($word == "Shorouk") $source = "الشروق";
        else if ($word == "Masrawy") $source = "مصراوي";
        else if ($word == "Akhbarelyom") $source = "أخبار اليوم";
        else if ($word == "Vetogate") $source = "بوابة فيتو";
        else if ($word == "Youm7") $source = "اليوم السابع";
        else if ($word == "Elbalad") $source = "صدى البلد";
        else if ($word == "Elwatannews") $source = "الوطن";
        else if ($word == "ElBadil News") $source = "البديل";
        else if ($word == "akhbarak") $source = "أخبارك نت";
        else if ($word == "Rassd News") $source = "رصد";
        else if ($word == "Tahrir News") $source = "أخبار التحرير";
        else if ($word == "Filfan") $source = "في الفن";
        else if ($word == "E3rfkora") $source = "إعرف كورة";
        else if ($word == "Yallakora") $source = "يلا كورة";
        else if ($word == "Almasryalyoum") $source = "المصري اليوم";
        else if ($word == "Nogoom Masrya") $source = "نجوم مصرية";
        else if ($word == "Mubasher.info") $source = "مباشر";
        else if ($word == "misr alan") $source = "مصر الآن";
        else if ($word == "Alyuwm") $source = "اليوم الإخباري";
        else if ($word == "Hapijournal") $source = "Hapijournal";
        else if ($word == "Kuwait News") $source = "كويت نيوز";
        else if ($word == "Alkhabar") $source = "الخبر";
        else if ($word == "Liferdefempire") $source = "شامل نيوز";
        else if ($word == "Alkuwait Alomh") $source = "الكويت الأمة";
        else if ($word == "Watan News KU") $source = "الوطن الإلكترونية";
        else if ($word == "Alqabas") $source = "القبس الإلكتروني";
        else if ($word == "AlAnba News") $source = "جريدة الأنباء";
        else if ($word == "Media Court") $source = "أمن ومحاكم";
        else if ($word == "Alhawadeth") $source = "الحوادث الاخبارية";
        else if ($word == "Alaan News") $source = "جريدة الآن";
        else if ($word == "Quds News") $source = "شبكة قدس الإخبارية";
        else if ($word == "Alquds Newspaper") $source = "جريدة القدس";
        else if ($word == "48 News") $source = "48 الإخبارية";
        else if ($word == "Alsharq Portal") $source = "بوابة الشرق";
        else if ($word == "AlArab Qatar") $source = "العرب";
        else if ($word == "Alwatan Qatar") $source = "جريدة الوطن";
        else if ($word == "Alraya") $source = "الراية القطرية";
        else if ($word == "Alraya D") $source = "الراية اليومية";
        else if ($word == "Qatar Newspaper") $source = "جريدة قطر";
        else if ($word == "Sabq") $source = "صحيفة سبق";
        else if ($word == "AlRiyadh") $source = "جريدة الرياض";
        else if ($word == "Akhbaar24") $source = "أخبار 24";
        else if ($word == "AlwatanSA") $source = "جريدة الوطن السعودية";
        else if ($word == "Alarabiya") $source = "العربية";
        else if ($word == "Tech-wd") $source = "عالم التقنية";
        else if ($word == "AlShrq News") $source = "صحيفة الشرق";
        else if ($word == "OKAZ online") $source = "صحيفة عكاظ";
        else if ($word == "Twasul News") $source = "صحيفة تواصل";
        else if ($word == "Alweeam News") $source = "صحيفة الوئام";
        else if ($word == "Aljazirah") $source = "صحيفة الجزيرة";
        else if ($word == "Afrigatenewsly") $source = "بوابة افريقيا الاخبارية";
        else if ($word == "emaratalyoum") $source = "الإمارات اليوم";
        else if ($word == "Akhbar alaan") $source = "أخبار الآن";
        else if ($word == "AlBayan") $source = "البيان";
        else if ($word == "aletihad") $source = "الاتحاد";
        else if ($word == "BARQ") $source = "برق الإمارات";
        else if ($word == "Erem") $source = "إرم نيوز";
        else if ($word == "AlArabiya_Bn") $source = "الأسواق العربية";
        else if ($word == "tayyar_org") $source = "التيار الوطني الحر";
        else if ($word == "AlJoumhouria") $source = "الجمهورية";
        else if ($word == "assafir") $source = "جريدة السفير";
        else if ($word == "Al-Akhbar") $source = "جريدة الأخبار";
        else if ($word == "Annahar") $source = "النهار";
        else if ($word == "Aljaras") $source = "الجرس";
        else if ($word == "Assawsana") $source = "Assawsana News";
        else if ($word == "AlMaqar") $source = "صحيفة المقر";
        else if ($word == "HalaAkhbar") $source = "هلا أخبار";
        else if ($word == "alwakeel") $source = "الوكيل الإخباري";
        else if ($word == "7iber") $source = "حبر";
        else if ($word == "Khaberni") $source = "خبرني";
        else if ($word == "Alghad") $source = "جريدة الغد";
        else if ($word == "alrai") $source = "الرأي - أخبار الأردن";
        else if ($word == "Sentry_Syria") $source = "مرصد سوريا";
        else if ($word == "zamanalwsl") $source = "زمان الوصل";
        else if ($word == "Aksalser") $source = "عكس السير";
        else if ($word == "HalabToday") $source = "حلب اليوم";
        else if ($word == "shaamnews") $source = "شبكة شام الإخبارية";
        else if ($word == "yalla") $source = "يلا";
        else if ($word == "annbaanet") $source = "شبكة النبأ";
        else if ($word == "AssabahAljadeed") $source = "الصباح الجديد";
        else if ($word == "rudaw_arabic") $source = "Rudaw عربية";
        else if ($word == "Baxcha") $source = "Baxcha";
        else if ($word == "yepress") $source = "يمن برس";
        else if ($word == "SUHFNET") $source = "صحف نت";
        else if ($word == "ALyemennow") $source = "اليمن الآن";
        else if ($word == "YenNews1") $source = "عين اليمن الأخبارية";
        else if ($word == "almasdaronline") $source = "المصدر أونلاين";
        else if ($word == "marebpress") $source = "مأرب برس";
        else if ($word == "albiladpress") $source = "صحيفة البلاد";
        else if ($word == "AAK_News") $source = "أخبار الخليج";
        else if ($word == "Alwatan") $source = "الوطن";
        else if ($word == "ALAYAM") $source = "الأيام";
        else if ($word == "BahrainMirror") $source = "مرآة البحرين";
        else if ($word == "alwasatnews") $source = "الوسط";
        else if ($word == "WAF") $source = "واف";
        else if ($word == "albalad") $source = "صحيفة البلد";
        else if ($word == "ALROYA") $source = "جريدة الرؤية";
        else if ($word == "Atheer_Oman") $source = "أثيـر";
        else if ($word == "omandaily1") $source = "جريدة عمان";
        else if ($word == "Algerie360") $source = "Algerie360";
        else if ($word == "TSAlgerie") $source = "TSAlgerie";
        else if ($word == "elwatancom") $source = "elwatan.com";
        else if ($word == "AlgeriaTimes") $source = "AlgeriaTimes";
        else if ($word == "elwatan_com") $source = "El Watan";
        else if ($word == "elkhabarlive") $source = "الخبر";
        else if ($word == "JournaLiberteDZ") $source = "Liberté";
        else if ($word == "Algpatriotique") $source = "Algérie Patriotique";
        else if ($word == "Nawaat") $source = "نواة";
        else if ($word == "Tunisia Live") $source = "Tunisia Live";
        else if ($word == "KapitalisInfo") $source = "Kapitalis";
        else if ($word == "ChallengesTn") $source = "challenges.tn";
        else if ($word == "Hespress") $source = "هسبريس";
        else if ($word == "yabiladi") $source = "Yabiladi.com";
        else if ($word == "Le360") $source = "Le360";
        else if ($word == "Medias24") $source = "Medias24";
        else if ($word == "HuffPost Maroc") $source = "HuffPost Maroc";
        else if ($word == "H24info") $source = "H24Info";
        else if ($word == "Le 360 ar") $source = "Le 360 - العربية";
        else if ($word == "Chouf tv") $source = "Chouf tv";
        else if ($word == "Menara.ma") $source = "Menara.ma";
        else if ($word == "yabiladi_ar") $source = "يابلادي";
        else if ($word == "ZSC Official") $source = "نادي الزمالك";
        else if ($word == "AlAhly") $source = "النادي الأهلي";
        else if ($word == "superkora") $source = "سوبر كورة";
        else if ($word == "Elwatan Sport") $source = "الوطن الرياضي";
        else if ($word == "Kooora") $source = "Kooora";
        else if ($word == "FilGoal") $source = "FilGoal";
        else if ($word == "sporty 24") $source = "سبورت 24";
        else if ($word == "Sportksa.net") $source = "سبورت السعودية";
        else if ($word == "Korarotana") $source = "برنامج كورة";
        else if ($word == "Shoot KSA") $source = "شووت";
        else if ($word == "Eqtisad Misr") $source = "اقتصاد مصر";
        else if ($word == "Amwal Alghad") $source = "أموال الغد";
        else if ($word == "Almal Web") $source = "جريدة المال";
        else if ($word == "Aliktisad") $source = "مجلة الاقتصاد";
        else if ($word == "Aleqtisadiah") $source = "صحيفة الاقتصادية";
        else if ($word == "Aliqtisadi") $source = "الاقتصادي";
        else if ($word == "Central Bank Of Ly") $source = "مصرف ليبيا المركزي";
        else if ($word == "Eqtesadiaps") $source = "جريدة الاقتصادية غزة";
        else if ($word == "Pal Economy") $source = "بوابة اقتصاد فلسطين";
        else if ($word == "Eliktisad") $source = "الإقتصاد";
        else if ($word == "SinaaIktisad") $source = "مجلة الصناعة والإقتصاد";
        else if ($word == "Iraq Directory") $source = "Iraq Directory";
        else if ($word == "Arabic Economist") $source = "الاقتصادي";
        else if ($word == "Eqtsad Syria") $source = "Eqtsad Syria";
        else if ($word == "B2B SYRIA") $source = "B2B SYRIA";
        else if ($word == "Oman Economy") $source = "اقتصاد السلطنة";
        else if ($word == "Get Chefaa") $source = "GetChefaa";
        else if ($word == "Kaahe") $source = "موسوعة الملك عبدالله";
        else if ($word == "3eesho My health") $source = "صحتي-عيشوا.كوم";
        else if ($word == "Altibbi") $source = "Altibbi";
        else if ($word == "Doctoori") $source = "دكتوري";
        else if ($word == "DMedicalinfo") $source = "كل يوم معلومة طبية";
        else if ($word == "Capsuleh") $source = "كبسولة";
        else if ($word == "Web Teb") $source = "ويب طب";
        else   $source = "  إف واي آي برس ";
        return $source;

    }

    public function type($word, $lang)
    {
        $source = "";
        switch ($lang){
            case 'ar':
                if ($word == "News") $source = "اخبار";
                else if ($word == "Sports") $source = "رياضة";
                else if ($word == "Technology") $source = "تكنولوجيا";
                else if ($word == "Arts") $source = "فن";
                else if ($word == "Economy") $source = "اقتصاد";
                else if ($word == "Health") $source = "صحة";
                else if ($word == "General Culture" || $word == "Culture") $source = "ثقافة عامة";
                break;
            case 'en':
                break;
            case 'tu':
                if($word=="News")  $source=" Haberler  ";
                else  if($word=="Sports")   $source=" Spor ";
                else  if($word=="Technology")   $source=" Teknoloji ";
                else  if($word=="Arts")   $source=" Sanat ";
                else if ($word == "Economy") $source = "Ekonomi";
                else if ($word == "Health") $source = "Sağlık";
                else  if($word=="General Culture"||$word=="Culture")   $source=" Genel Kültür ";
                break;
            case 'ur':
                if($word=="News")  $source=" خبریں  ";
                else  if($word=="Sports")   $source=" کھیلوں ";
                else  if($word=="Technology")   $source=" ٹیکنالوجی ";
                else  if($word=="Arts")   $source=" آرٹ ";
                else if ($word == "Economy") $source = "معیشت";
                else if ($word == "Health") $source = "صحت";
                else  if($word=="General Culture"||$word=="Culture")   $source="   جنرل ثقافت  ";
                break;
            case 'sp':
                if($word=="News")  $source="Noticias";
                else  if($word=="Sports")   $source="Deportes";
                else  if($word=="Technology")   $source="Tecnología";
                else  if($word=="Arts")   $source="Artes";
                else if ($word == "Economy") $source = "Economía";
                else if ($word == "Health") $source = "Salud";
                else  if($word=="General Culture"||$word=="Culture")   $source="Cultura general";
                break;
            case 'ru':
                if($word=="News")  $source=" Новости  ";
                else  if($word=="Sports")   $source=" Спорт ";
                else  if($word=="Technology")   $source=" Технология ";
                else  if($word=="Arts")   $source=" Искусство ";
                else if ($word == "Economy") $source = "экономика";
                else if ($word == "Health") $source = "Здоровье";
                else  if($word=="General Culture"||$word=="Culture")   $source=" Общая культура ";
                break;
            case 'jp':
                if($word=="News")  $source=" ニュース  ";
                else  if($word=="Sports")   $source=" スポーツ ";
                else  if($word=="Technology")   $source=" 技術 ";
                else  if($word=="Arts")   $source=" 芸術 ";
                else if ($word == "Economy") $source = "経済";
                else if ($word == "Health") $source = "健康";
                else  if($word=="General Culture"||$word=="Culture")   $source=" 一般文化 ";
                break;
            case 'in':
                if($word=="News")  $source=" समाचार  ";
                else  if($word=="Sports")   $source=" खेल ";
                else  if($word=="Technology")   $source=" प्रौद्योगिकी ";
                else  if($word=="Arts")   $source=" कला ";
                else if ($word == "Economy") $source = "अर्थव्यवस्था";
                else if ($word == "Health") $source = "स्वास्थ्य";
                else  if($word=="General Culture"||$word=="Culture")   $source=" सामान्य संस्कृति ";
                break;
            case 'ge':
                if($word=="News")  $source=" Nachrichten  ";
                else  if($word=="Sports")   $source=" Sport ";
                else  if($word=="Technology")   $source=" Technologie ";
                else  if($word=="Arts")   $source=" Kunst ";
                else if ($word == "Economy") $source = "Wirtschaft";
                else if ($word == "Health") $source = "Gesundheit";
                else  if($word=="General Culture"||$word=="Culture")   $source=" Allgemeine Kultur ";
                break;
            case 'fr':
                if($word=="News")  $source=" Actualités  ";
                else  if($word=="Sports")   $source=" Sport ";
                else  if($word=="Technology")   $source=" Technologie ";
                else  if($word=="Arts")   $source=" Arts ";
                else if ($word == "Economy") $source = "Économie";
                else if ($word == "Health") $source = "Santé";
                else  if($word=="General Culture"||$word=="Culture")   $source=" Culture générale ";
                break;
            case 'ch':
                if($word=="News")  $source=" 新闻  ";
                else  if($word=="Sports")   $source=" 体育 ";
                else  if($word=="Technology")   $source=" 科技 ";
                else  if($word=="Arts")   $source=" 艺术 ";
                else if ($word == "Economy") $source = "經濟";
                else if ($word == "Health") $source = "健康";
                else  if($word=="General Culture"||$word=="Culture")   $source=" 一般文化 ";
                break;
            case 'he':
                if($word=="News")  $source="חדשות   ";
                else  if($word=="Sports")   $source="ספורט  ";
                else  if($word=="Technology")   $source="טכנולוגיה  ";
                else  if($word=="Arts")   $source="אמנויות  ";
                else if ($word == "Economy") $source = "כלכלה";
                else if ($word == "Health") $source = "בריאות";
                else  if($word=="General Culture"||$word=="Culture")   $source="תרבות כללית   ";
                break;
            default:
                $output['error'] = 1;
                $output['message'] = 'Language Error';
                echo json_encode($output);
                die('');
        }

        return $source;
    }

    public function update_pass($email, $newpass)
    {

        $this->con->exec('UPDATE utilisateurs SET password="' . $newpass . '" WHERE email = "' . $email . '"');
    }

    // user exist or not
    public function userexist($email)
    {

        $sql = 'select * from utilisateurs where email="' . $email . '"';
        $query = $this->con->query($sql);
        if ($data = $query->fetch()) {
            $this->email = $data['email'];
            $this->name = $data['name'];
            $this->password = $data['password'];
            if ($this->getemail() != null) {
                return $this;
            } else {
                return null;
            }
        }
    }

    // user exist or not
    public function Function_userexist($email, $pass)
    {

        $sql = 'select * from utilisateurs where email="' . $email . '" and password="' . $pass . '"';
        $query = $this->con->query($sql);
        if ($data = $query->fetch()) {
            $this->email = $data['email'];
            $this->name = $data['name'];
            $this->password = $data['password'];
            if ($this->getemail() != null && $this->getpassword() != null) {
                return $this;
            } else {
                return null;
            }
        }
    }

    // user exist or not
    public function Function_userexist2($email)
    {

        $sql = 'select * from utilisateurs where email="' . $email . '"';
        $query = $this->con->query($sql);
        if ($data = $query->fetch()) {
            $this->email = $data['email'];
            $this->name = $data['name'];
            $this->password = $data['password'];
            if ($this->getemail() != null && $this->getpassword() != null) {
                return $this;
            } else {
                return null;
            }
        }
    }

    //disactive_status
    public function disactive_status($email)
    {

        $this->con->exec('update utilisateurs  set status=0 where email="' . $email . '"');
    }

    // total males
    public function getUserName($email)
    {

        $requete = $this->con->prepare('SELECT  name FROM utilisateurs where email="' . $email . '"');
        $requete->execute();
        $name = $requete->fetchColumn();
        return $name;
    }

    public function get_source_status($source, $type)
    {

        $requete = $this->con->prepare('SELECT  status FROM rss_sources where source="' . $source . '" and type="' . $type . '" ');
        $requete->execute();
        $name = $requete->fetchColumn();
        return $name;
    }

    public function generateNewString()
    {
        $token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
        $token = str_shuffle($token);
        $token = substr($token, 0, 10);
        return $token;
    }

    public function generateNewpass()
    {
        $token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789';
        $token = str_shuffle($token);
        $token = substr($token, 0, 10);
        return $token;
    }

    public function email_exist($email)
    {

        $requete = $this->con->prepare("SELECT count(*) FROM utilisateurs  where  email  = '" . $email . "' ");
        $requete->execute();
        $pass = $requete->fetchColumn();
        if ($pass > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function email_token_exist($email, $token)
    {

        $requete = $this->con->prepare("SELECT count(*) FROM utilisateurs  where  email  = '" . $email . "' AND token='" . $token . "'");
        $requete->execute();
        $pass = $requete->fetchColumn();
        if ($pass > 0) {
            return true;
        } else {
            return false;
        }
    }

    // currentpass
    public function get_current_pass($email)
    {

        $requete = $this->con->prepare("SELECT password FROM utilisateurs  where email  = '" . $email . "'");
        $requete->execute();
        $pass = $requete->fetchColumn();
        return $pass;
    }

    public function acount_is_confirmed($email)
    {

        $requete = $this->con->prepare("SELECT count(*) FROM utilisateurs  where isEmailConfirmed=1 and email  = '" . $email . "' ");
        $requete->execute();
        $pass = $requete->fetchColumn();
        if ($pass > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function acount_is_non_confirmed($email)
    {

        $requete = $this->con->prepare("SELECT count(*) FROM utilisateurs  where isEmailConfirmed=0 and email  = '" . $email . "' ");
        $requete->execute();
        $pass = $requete->fetchColumn();
        if ($pass > 0) {
            return true;
        } else {
            return false;
        }
    }

    //islogged
    public function islogged()
    {
        $c = false;

        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_pass'])
            && !empty($_COOKIE['fyiuser_pass']) && !empty($_COOKIE['fyiuser_email'])) {
            $requete = $this->con->prepare('SELECT count(*) FROM utilisateurs where email="' . $_COOKIE['fyiuser_email'] . '" and password="' . $_COOKIE['fyiuser_pass'] . '"');
            $requete->execute();
            $nb = $requete->fetchColumn();
            if ($nb > 0) {
                $c = true;
            }
        }


        if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_pass'])
            && !empty($_SESSION['user_auth']['user_pass']) && !empty($_SESSION['user_auth']['user_email'])) {
            $requete = $this->con->prepare('SELECT count(*) FROM utilisateurs where email="' . $_SESSION['user_auth']['user_email'] . '" and password="' . $_SESSION['user_auth']['user_pass'] . '"');
            $requete->execute();
            $nb = $requete->fetchColumn();
            if ($nb > 0) {
                $c = true;
            }
        }

        return $c;
    }

    public function find_search($searchq)
    {

        $tab = array();
        $query = $this->con->query(" select * from  news_published where title LIKE '%$searchq%' OR description LIKE '%$searchq%' OR pubDate LIKE '%$searchq%' ");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function get_source_row($source){
        $stmt = $this->con->prepare("select * from rss_sources where source = '$source'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function get_source_twitter($source){
        $stmt = $this->con->prepare("select * from rss_sources where source = '$source' and twitter != ''");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

}

?>
		
		
		