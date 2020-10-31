<?php

class utilisateursModel
{
    private $email;
    private $name;
    private $password;
    private $isEmailConfirmed;
    private $token;
    private $image;

    //getters
    public function getemail()
    {
        return $this->email;
    }

    public function getname()
    {
        return $this->name;
    }

    public function getimage()
    {
        return $this->image;
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

    public function setimage($value)
    {
        $this->image = $value;

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

    public static function email_non_confirmed_existe($email, $token)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT email FROM utilisateurs WHERE email='$email' AND token='$token' AND isEmailConfirmed=0");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }


    public static function user_token_existe($email, $token)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT email FROM utilisateurs WHERE email='$email'
                   AND token='$token' AND  isEmailConfirmed=0");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }


    //v2check
    public static function get_nb_rss_source()
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT count(*) FROM rss_sources ");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public static function nb_sources_not_checked($email)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT count(*) FROM user_sources WHERE email='$email' ");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }


    //v2
    public function get_countries()
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query('select  distinct country from rss_sources ');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function get_sources_of_country($country)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query('select  distinct source from rss_sources where country = "' . $country . '"');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function get_source_row($source){
        include("fyipanel/views/connect.php");
        $stmt = $con->prepare("select * from rss_sources where source = '$source'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function get_source_twitter($source){
        include("fyipanel/views/connect.php");
        $stmt = $con->prepare("select * from rss_sources where source = '$source' and twitter != ''");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function get_types_of_country_and_source($country, $source)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query('select * from rss_sources WHERE country= "' . $country . '"
             AND source="' . $source . '"');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public static function check_source($email, $id)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT email FROM user_sources WHERE email='$email' AND id='$id' ");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public static function get_id_rss_source($country, $source, $type)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT id FROM rss_sources WHERE country='$country' AND source='$source' AND type='$type' ");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public static function add_user_sources($email, $id)
    {
        include("fyipanel/views/connect.php");
        $con->exec('INSERT INTO user_sources VALUES ("' . $email . '","' . $id . '")');
    }

    public static function delete_user_sources($email, $id)
    {
        include("fyipanel/views/connect.php");
        $con->exec("DELETE FROM user_sources WHERE email='$email' AND id='$id' ");
    }


    public static function confirm_email($email)
    {
        //arabic
        include 'fyipanel/views/connect.php';
        $con->exec("UPDATE utilisateurs SET isEmailConfirmed=1,token='' WHERE email='" . $email . "'");
        $con->exec("INSERT INTO language_users SELECT * from utilisateurs WHERE email='" . $email . "'");
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

    public static function update_token_pass_user($email, $newpass)
    {
        //ar
        include("fyipanel/views/connect.php");
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

    public static function update_token_pass_whitout_conf_user($email, $newpass)
    {
        //ar
        include("fyipanel/views/connect.php");
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
        // arabic
        include("fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //english
        include("../fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //spanish
        include("../spanish/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //tr
        include("../turkish/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //chinese
        include("../chinese/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //russian
        include("../russian/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //french
        include("../french/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //in
        include("../indian/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //ur
        include("../urdu/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //hb
        include("../hebrew/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
        //ur
        include("../german/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');

        include("../japanese/fyipanel/views/connect.php");
        $con->exec('INSERT INTO utilisateurs VALUES (null, "' . $this->email . '","' . $this->name . '","' .
            $pass . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '", "", "")');
    }

    public static function update_token($email, $token)
    {
        //arabic
        include("fyipanel/views/connect.php");
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


    public static function update_token_pass($email, $newpass)
    {
        //arabic
        include("fyipanel/views/connect.php");
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
        include('fyipanel/views/connect.php');
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

    //delete employee
    public static function delete_user_And_His_comments($id_c)
    {
        $c = false;
        //ar
        include("../views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }
        //en
        include("../../../fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }

        //es
        include("../../../spanish/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }
        //tr
        include("../../../turkish/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }
        //chinese
        include("../../../chinese/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }
        //russian
        include("../../../russian/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }
        //french
        include("../../../french/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }

        include("../../../indian/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }

        include("../../../urdu/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }

        include("../../../hebrew/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }

        include("../../../german/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }

        include("../../../japanese/fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM utilisateurs  where email="' . $id_c . '"');
        $requete->execute();
        $nbr_user = $requete->fetchColumn();
        if ($nbr_user > 0) {
            $con->exec('DELETE FROM  utilisateurs  where email="' . $id_c . '"');
            $c = true;
        }


        return $c;
    }


    public static function getLink($at)
    {
        include 'fyipanel/views/connect.php';
        $requete = $con->prepare('select ' . $at . ' from links where id=1');
        $requete->execute();
        return $requete->fetchColumn();
    }

    public static function info($at)
    {
        include 'fyipanel/views/connect.php';
        $requete = $con->prepare('select ' . $at . ' from account where id=1');
        $requete->execute();
        return $requete->fetchColumn();
    }

    public static function info2($at)
    {
        include '../views/connect.php';
        $requete = $con->prepare('select ' . $at . ' from account where id=1');
        $requete->execute();
        return $requete->fetchColumn();
    }

    // all users
    public function utilisateurs()
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from utilisateurs');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function update_user($email)
    {
        include("fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET  name="' . $this->name . '",password="' . $this->password . '"  WHERE email = "' . $email . '"');
    }

    public static function source($word)
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
        else if ($word == "As Arabia") $source = "As العربيه";
        else if ($word == "RT Arabic") $source = "RT العربيه";
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
        else if ($word == "Hapijournal") $source = "جريده هابي";
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
        else if ($word == "Assawsana") $source = "اسوانا";
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
        else if ($word == "rudaw_arabic") $source = "روضه عربية";
        else if ($word == "Baxcha") $source = "بوسطا";
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
        else if ($word == "Algerie360") $source = "الجزائر 360";
        else if ($word == "TSAlgerie") $source = "الجزائر تي اس";
        else if ($word == "elwatancom") $source = "الوطن كوم";
        else if ($word == "AlgeriaTimes") $source = "الجزائر تايمز";
        else if ($word == "elwatan_com") $source = "جريده الوطن";
        else if ($word == "elkhabarlive") $source = "الخبر";
        else if ($word == "JournaLiberteDZ") $source = "ليبراتي";
        else if ($word == "Algpatriotique") $source = "ألجيري باتريوتيك";
        else if ($word == "Nawaat") $source = "نواة";
        else if ($word == "Tunisia Live") $source = "تونس مباشر";
        else if ($word == "KapitalisInfo") $source = "كابيتاليس";
        else if ($word == "ChallengesTn") $source = "التحدي";
        else if ($word == "Hespress") $source = "هسبريس";
        else if ($word == "yabiladi") $source = "يابلادي";
        else if ($word == "Le360") $source = "لي 360";
        else if ($word == "Medias24") $source = "ميداس 24";
        else if ($word == "HuffPost Maroc") $source = "هاف بوست";
        else if ($word == "H24info") $source = "اتش 24";
        else if ($word == "Le 360 ar") $source = "لي 360 - العربية";
        else if ($word == "Chouf tv") $source = "شوف تي في";
        else if ($word == "Menara.ma") $source = "منار";
        else if ($word == "yabiladi_ar") $source = "يابلادي";
        else if ($word == "ZSC Official") $source = "نادي الزمالك";
        else if ($word == "AlAhly") $source = "النادي الأهلي";
        else if ($word == "superkora") $source = "سوبر كورة";
        else if ($word == "Elwatan Sport") $source = "الوطن الرياضي";
        else if ($word == "Kooora") $source = "كووره";
        else if ($word == "FilGoal") $source = "في الجول";
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
        else if ($word == "Iraq Directory") $source = "دليل العراق";
        else if ($word == "Arabic Economist") $source = "الاقتصادي";
        else if ($word == "Eqtsad Syria") $source = "اقتصاد سوريا";
        else if ($word == "B2B SYRIA") $source = "B2B سوريا";
        else if ($word == "Oman Economy") $source = "اقتصاد السلطنة";
        else if ($word == "Get Chefaa") $source = "شفاء";
        else if ($word == "Kaahe") $source = "موسوعة الملك عبدالله";
        else if ($word == "3eesho My health") $source = "صحتي-عيشوا.كوم";
        else if ($word == "Altibbi") $source = "الطبيب";
        else if ($word == "Doctoori") $source = "دكتوري";
        else if ($word == "DMedicalinfo") $source = "كل يوم معلومة طبية";
        else if ($word == "Capsuleh") $source = "كبسولة";
        else if ($word == "Web Teb") $source = "ويب طب";
        else if ($word == "The Age") $source =  "جريده العمر"; 
        else if ($word == "Lebanon24") $source =  "لبنان 24";
        else if ($word == "218tv") $source =  "218 تليفزيون";

        else if ($word == "Arabnn") $source =  "الشبكة العربية";
        else if ($word == "Syria4Twitte") $source =  "عين على سوريا";
        else if ($word == "Alwatan_Live") $source =  "صحيفة الوطن";
        else if ($word == "ariyadhiah") $source =  "صحيفة الرياضية";
        else if ($word == "sporty_24") $source =  "اخبار 24";
  
        else   $source = "  إف واي آي برس ";
        return $source;


    } 

    public static function type($word)
    {
        $source = "";
        if ($word == "News") $source = "اخبار";
        else if ($word == "Sports") $source = "رياضة";
        else if ($word == "Technology") $source = "تكنولوجيا";
        else if ($word == "Arts") $source = "فن";
        else if ($word == "Economy") $source = "اقتصاد";
        else if ($word == "Health") $source = "صحة";
        else if ($word == "General Culture" || $word == "Culture") $source = "ثقافة عامة";
        return $source;
    }


    public function update_pass($email, $newpass)
    {
        include("fyipanel/views/connect.php");
        $con->exec('UPDATE utilisateurs SET password="' . $newpass . '" WHERE email = "' . $email . '"');
    }


    // user exist or not
    public function userexist($email)
    {
        include("fyipanel/views/connect.php");
        $sql = 'select * from utilisateurs where email="' . $email . '"';
        $query = $con->query($sql);
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
        include('fyipanel/views/connect.php');
        $sql = 'select * from utilisateurs where email="' . $email . '" and password="' . $pass . '"';
        $query = $con->query($sql);
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
        include('fyipanel/views/connect.php');
        $sql = 'select * from utilisateurs where email="' . $email . '"';
        $query = $con->query($sql);
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
        include('fyipanel/views/connect.php');
        $con->exec('update utilisateurs  set status=0 where email="' . $email . '"');
    }

    // total males
    public static function getUserName($email)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT  name FROM utilisateurs where email="' . $email . '"');
        $requete->execute();
        $name = $requete->fetchColumn();
        return $name;
    }

 public static function url_allowed($url){
    $curl = curl_init($url);  

    // Use curl_setopt() to set an option for cURL transfer 
    curl_setopt($curl, CURLOPT_NOBODY, true); 

    // Use curl_exec() to perform cURL session 
    $result = curl_exec($curl); 

if ($result !== false) {  
    // Use curl_getinfo() to get information 
    // regarding a specific transfer 
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
    if ($statusCode == 404) { 
        return false; 
    }  else { 
        return true; 
    } 
}  else { 
    return false; 
}

}

    public static function get_source_status($source, $type)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare('SELECT  status FROM rss_sources where source="' . $source . '" and type="' . $type . '" ');
        $requete->execute();
        $name = $requete->fetchColumn();
        return $name;
    }

    public static function generateNewString()
    {
        $token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
        $token = str_shuffle($token);
        $token = substr($token, 0, 10);
        return $token;
    }

    public static function generateNewpass()
    {
        $token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789';
        $token = str_shuffle($token);
        $token = substr($token, 0, 10);
        return $token;
    }

    public static function email_exist($email)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare("SELECT count(*) FROM utilisateurs  where  email  = '" . $email . "' ");
        $requete->execute();
        $pass = $requete->fetchColumn();
        if ($pass > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function email_token_exist($email, $token)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare("SELECT count(*) FROM utilisateurs  where  email  = '" . $email . "' AND token='" . $token . "'");
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
        include("fyipanel/views/connect.php");
        $requete = $con->prepare("SELECT password FROM utilisateurs  where email  = '" . $email . "'");
        $requete->execute();
        $pass = $requete->fetchColumn();
        return $pass;
    }

    public static function acount_is_confirmed($email)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare("SELECT count(*) FROM utilisateurs  where isEmailConfirmed=1 and email  = '" . $email . "' ");
        $requete->execute();
        $pass = $requete->fetchColumn();
        if ($pass > 0) {
            return true;
        } else {
            return false;
        }
    }


    public static function acount_is_non_confirmed($email)
    {
        include("fyipanel/views/connect.php");
        $requete = $con->prepare("SELECT count(*) FROM utilisateurs  where isEmailConfirmed=0 and email  = '" . $email . "' ");
        $requete->execute();
        $pass = $requete->fetchColumn();
        if ($pass > 0) {
            return true;
        } else {
            return false;
        }
    }


    //islogged
    public static function islogged()
    {
        $c = false;
        include("fyipanel/views/connect.php");
        if (isset($_COOKIE['fyiuser_email']) && isset($_COOKIE['fyiuser_pass'])
            && !empty($_COOKIE['fyiuser_pass']) && !empty($_COOKIE['fyiuser_email'])) {
            $requete = $con->prepare('SELECT count(*) FROM utilisateurs where email="' . $_COOKIE['fyiuser_email'] . '" and password="' . $_COOKIE['fyiuser_pass'] . '"');
            $requete->execute();
            $nb = $requete->fetchColumn();
            if ($nb > 0) {
                $c = true;
            }
        }


        if (isset($_SESSION['user_auth']['user_email']) && isset($_SESSION['user_auth']['user_pass'])
            && !empty($_SESSION['user_auth']['user_pass']) && !empty($_SESSION['user_auth']['user_email'])) {
            $requete = $con->prepare('SELECT count(*) FROM utilisateurs where email="' . $_SESSION['user_auth']['user_email'] . '" and password="' . $_SESSION['user_auth']['user_pass'] . '"');
            $requete->execute();
            $nb = $requete->fetchColumn();
            if ($nb > 0) {
                $c = true;
            }
        }

        return $c;
    }


    public static function find_search($searchq)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query(" select * from  news_published where title LIKE '%$searchq%' OR description LIKE '%$searchq%' OR pubDate LIKE '%$searchq%' ");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public static function get_user_by_email($email){
        include("fyipanel/views/connect.php");
        $stmt = $con->prepare("select * from utilisateurs where email = '$email'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    /*public static function get_source_by_twitter($twitter_account){
        include("fyipanel/views/connect.php");
        $stmt = $con->prepare("select * from rss_sources where twitter = '$twitter_account'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row();
    }*/

}

?>
		
		
		