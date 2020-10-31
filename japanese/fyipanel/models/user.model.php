<?php

class userModel
{
    private $Email;
    private $First_name;
    private $Last_name;
    private $Gender;
    private $Photo;
    private $Password;
    private $Function;
    private $Phone;
 
    //getters
    public function getPhone()
    {
        return $this->Phone;
    }

    public function setPhone($value)
    {
        if (!empty($value))
            $this->Phone = $value;
    }

    public static function acount_is_confirmed($email)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT count(*) FROM users  where isEmailConfirmed=1 and email  = '" . $email . "' ");
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
        include("../views/connect.php");
        $requete = $con->prepare("SELECT count(*) FROM users  where isEmailConfirmed=0 and email  = '" . $email . "' ");
        $requete->execute();
        $pass = $requete->fetchColumn();
        if ($pass > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function acount_exist($email)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT count(*) FROM users  where Email  = '" . $email . "' ");
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
        $requete = $con->prepare("SELECT count(*) FROM users  where  email  = '" . $email . "' AND token='" . $token . "'");
        $requete->execute();
        $pass = $requete->fetchColumn();
        if ($pass > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function generateNewString()
    {
        $token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789';
        $token = str_shuffle($token);
        $token = substr($token, 0, 10);
        return $token;
    }

    public static function minDate()
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT min(date) FROM `dates` ");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
        return $tbtwodates;
    }

    public static function maxDate()
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT max(date) FROM `dates` ");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
        return $tbtwodates;
    }

    public static function getname($email)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT  concat(First_name,' ',Last_name) as name FROM `users` where Email='" . $email . "' ");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
        return $tbtwodates;
    }

    public static function traffic_By_date($d1)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT sum(nb) FROM `visitors`
             WHERE `date` ='" . $d1 . "'");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
        return $tbtwodates;
    }

    /* setters 	*/

    public static function getgeoplugin_countryCode($d1)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT distinct geoplugin_countryCode FROM `countries`
             WHERE `country` ='" . $d1 . "'");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
        return $tbtwodates;
    }

    public static function traffic_By_country($d1)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT sum(nb) FROM `visitors`
             WHERE `country` ='" . $d1 . "'");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
        return $tbtwodates;
    }

    public static function traffic_B_two_dates($d1, $d2)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT sum(nb) FROM `visitors`
             WHERE `date` BETWEEN '" . $d1 . "' and '" . $d2 . "'");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
        return $tbtwodates;
    }

    public static function traffic_country_B_two_dates($c, $d1, $d2)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT sum(nb) FROM `visitors`
             WHERE  `country` ='" . $c . "' and `date` BETWEEN '" . $d1 . "' and '" . $d2 . "'");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
        return $tbtwodates;
    }

    public static function traffic_date_country($d1, $c)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT sum(nb) FROM `visitors`
             WHERE `date`='" . $d1 . "' and country='" . $c . "'");
        $requete->execute();
        $tbtwodates = $requete->fetchColumn();
        return $tbtwodates;
    }

    public static function to_online($timeout)
    {
        include("../views/connect.php");
        $requete = $con->prepare("select sum(nb) from total_visitors where  time>='" . $timeout."'");
        $requete->execute();
        $total_online_visitors = $requete->fetchColumn();
        return $total_online_visitors;
    }

    public static function nb_total_visitors()
    {
        include("../views/connect.php");
        $requete = $con->prepare('select sum(nb) from visitors where date!=curdate() ');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function nb_total_visitors_today()
    {
        include("../views/connect.php");
        $requete = $con->prepare('select sum(nb) from visitors ');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function nb_total_dates()
    {
        include("../views/connect.php");
        $requete = $con->prepare('select count(*)-1 from dates  ');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function max_day_traffic()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT date from visitors GROUP by date HAVING sum(nb)>= all (select sum(nb) from visitors GROUP by date)');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function max_country_traffic()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT country from visitors GROUP by country HAVING sum(nb)>= all (select sum(nb) from visitors GROUP by country)');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function max_country_traffic_today($d)
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT country from visitors where date="' . $d . '" GROUP by country HAVING sum(nb)>= all (select sum(nb) from visitors where date="' . $d . '" GROUP by country)');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function nb_total_visitors_by_date($d)
    {
        include("../views/connect.php");
        $requete = $con->prepare('select sum(nb) from visitors where date="' . $d . '"');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function getTotalNewsPublishedByEmployee($email)
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM news where status=-1 and employee="' . $email . '"');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function newsipublished($email)
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM news_published where employee="' . $email . '"');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function getTotalNewsWaiting()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM news where status=1');
        $requete->execute();
        $nb = $requete->fetchColumn();
        return $nb;
    }

    public static function update_token($email, $token)
    {
        //de
        include("../views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //english
        include("../../../fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //arabic
        include("../../../arabic/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //es
        include("../../../spanish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //tr
        include("../../../turkish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //chinese
        include("../../../chinese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');
        //russian
        include("../../../russian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../../../french/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../../../indian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../../../japanese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../../../urdu/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');

        include("../../../hebrew/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  token="' . $token . '"   WHERE email = "' . $email . '"');

    }

     public function update_pass($email, $newpass)
    {
         //de
        include("../views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');
        //english
        include("../../../fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');
        //arabic
        include("../../../arabic/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');
        //es
        include("../../../spanish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');
        //tr
        include("../../../turkish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');
        //chinese
        include("../../../chinese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');
        //russian
        include("../../../russian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');

        include("../../../french/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');

        include("../../../indian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');

        include("../../../japanese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');

        include("../../../urdu/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');

        include("../../../hebrew/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET Password="'.$newpass.'" WHERE Email = "'.$email.'"');

    }

    public static function isMobile()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    public static function islogged($f)
    {
        include('../views/connect.php');
        $c = false;

        if (isset($_COOKIE['fyipPassword']) && isset($_COOKIE['fyipEmail']) &&
            isset($_COOKIE['fyipFunction']) && isset($_COOKIE['fyipPhoto']) &&
            isset($_COOKIE['fyipFirst_name']) && isset($_COOKIE['fyipLast_name'])
            && $_COOKIE['fyipFunction'] == $f) {
            $requete = $con->prepare('SELECT count(*) FROM users where Email="' . $_COOKIE['fyipEmail'] . '" and Password="' . $_COOKIE['fyipPassword'] . '" and Function="' . $_COOKIE['fyipFunction'] . '"');
            $requete->execute();
            $nb = $requete->fetchColumn();
            if ($nb > 0) {
                $c = true;
            }
        }


        if (isset($_SESSION['auth']['Password']) && isset($_SESSION['auth']['Email']) &&
            isset($_SESSION['auth']['Function']) && isset($_SESSION['auth']['Photo']) &&
            isset($_SESSION['auth']['First_name']) && isset($_SESSION['auth']['Last_name'])
            && $_SESSION['auth']['Function'] == $f) {
            $requete = $con->prepare('SELECT count(*) FROM users where Email="' . $_SESSION['auth']['Email'] . '" and Password="' . $_SESSION['auth']['Password'] . '" and Function="' . $_SESSION['auth']['Function'] . '"');
            $requete->execute();
            $nb = $requete->fetchColumn();
            if ($nb > 0) {
                $c = true;
            }
        }
        return $c;
    }

    public static function islogged2($f)
    {
        include('fyipanel/views/connect.php');
        $c = false;

        if (isset($_COOKIE['fyipPassword']) && isset($_COOKIE['fyipEmail']) &&
            isset($_COOKIE['fyipFunction']) && isset($_COOKIE['fyipPhoto']) &&
            isset($_COOKIE['fyipFirst_name']) && isset($_COOKIE['fyipLast_name'])
            && $_COOKIE['fyipFunction'] == $f) {
            $requete = $con->prepare('SELECT count(*) FROM users where Email="' . $_COOKIE['fyipEmail'] . '" and Password="' . $_COOKIE['fyipPassword'] . '" and Function="' . $_COOKIE['fyipFunction'] . '"');
            $requete->execute();
            $nb = $requete->fetchColumn();
            if ($nb > 0) {
                $c = true;
            }
        }


        if (isset($_SESSION['auth']['Password']) && isset($_SESSION['auth']['Email']) &&
            isset($_SESSION['auth']['Function']) && isset($_SESSION['auth']['Photo']) &&
            isset($_SESSION['auth']['First_name']) && isset($_SESSION['auth']['Last_name'])
            && $_SESSION['auth']['Function'] == $f) {
            $requete = $con->prepare('SELECT count(*) FROM users where Email="' . $_SESSION['auth']['Email'] . '" and Password="' . $_SESSION['auth']['Password'] . '" and Function="' . $_SESSION['auth']['Function'] . '"');
            $requete->execute();
            $nb = $requete->fetchColumn();
            if ($nb > 0) {
                $c = true;
            }
        }
        return $c;
    }

    public static function isLoged_but_un_lock()
    {
        $c = false;
        if (isset($_COOKIE['fyipPassword']) && isset($_COOKIE['fyipEmail']) &&
            isset($_COOKIE['fyipFunction']) && isset($_COOKIE['fyipPhoto']) &&
            isset($_COOKIE['fyipFirst_name']) && isset($_COOKIE['fyipLast_name'])
            && isset($_COOKIE['fyiplock']) && $_COOKIE['fyiplock'] == 1) {
            $c = true;
        }


        if (isset($_SESSION['auth']['Password']) && isset($_SESSION['auth']['Email']) &&
            isset($_SESSION['auth']['Function']) && isset($_SESSION['auth']['Photo']) &&
            isset($_SESSION['auth']['First_name']) && isset($_SESSION['auth']['Last_name'])
            && isset($_SESSION['auth']['lock']) && $_SESSION['auth']['lock'] == 1) {
            $c = true;
        }
        return $c;
    }

    public static function getImageName($mail)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT Photo FROM users where Email  = '" . $mail . "'");
        $requete->execute();
        $getimage = $requete->fetchColumn();
        return $getimage;
    }

    public static function totl_gender($gender)
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM users where Gender="' . $gender . '"');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    public static function totl_news()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM News ');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    public static function totl_news_not_published()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM News where status=1');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    //v5

    public static function getTotalNewsSent($email)
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT count(*) FROM news where status=1 and employee="' . $email . '"');
        $requete->execute();
        $name = $requete->fetchColumn();
        return $name;
    }

    //v5

    public static function totl_news_published()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM news_published');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    //v5

    public static function totl_rss()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(DISTINCT(title)) FROM rss');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    public static function total_users()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM users');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    public static function total_utilisateurs()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM utilisateurs');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

    public function getFirst_name()
    {
        return $this->First_name;
    }

    public function setFirst_name($value)
    {
        if (!empty($value))
            $this->First_name = $value;


    }

    public function getLast_name()
    {
        return $this->Last_name;
    }

    public function setLast_name($value)
    {
        if (!empty($value))
            $this->Last_name = $value;

    }

    // getReporterByidNews

    public function getGender()
    {
        return $this->Gender;
    }

    public function setGender($value)
    {
        if (!empty($value))
            $this->Gender = $value;

    }

    public function getPhoto()
    {
        return $this->Photo;
    }

    public function setPhoto($value)
    {
        if (!empty($value))
            $this->Photo = $value;

    }

    public function getisEmailConfirmed()
    {
        return $this->isEmailConfirmed;
    }

    public function gettoken()
    {
        return $this->token;
    }


    //update pass

    public function setisEmailConfirmed($value)
    {
        $this->isEmailConfirmed = $value;
    }

    // all users

    public function settoken($value)
    {
        $this->token = $value;
    }

    public function countries()
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from countries');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public function add_user()
    {
        //ur
        try{
        include("../views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","","' . $this->Phone . '")');
        //english
        include("../../../fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');
        //arabic
        include("../../../arabic/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');
        //es
        include("../../../spanish/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');
        //tr
        include("../../../turkish/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');
        //chinese
        include("../../../chinese/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');
        //russian
        include("../../../russian/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');

        include("../../../japanese/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');

        include("../../../french/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');

        include("../../../german/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');

        include("../../../indian/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' . $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');

        include("../../../urdu/fyipanel/views/connect.php");
        $con->exec('INSERT INTO users VALUES ("' . $this->Email . '","' . $this->First_name . '","' . $this->Last_name . '","' . $this->Gender . '","' . $this->Photo . '","' .
        $this->Password . '","' . $this->Function . '",0,' . $this->isEmailConfirmed . ',"' . $this->token . '","")');
        return true;
           } catch (PDOException $e) {
                  return false;  
           }
    }
  
    // user exist or not

    public function update_user($email)
    {
        //ur
        include("../views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '",Phone = "' . $this->Phone . '" WHERE Email = "' . $email . '"');
        //en
        include("../../../fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');
        //ar
        include("../../../arabic/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');
        //es
        include("../../../spanish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');
        //tr
        include("../../../turkish/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');
        //chinese
        include("../../../chinese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');
        //russian
        include("../../../russian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');

        include("../../../french/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');

        include("../../../japanese/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');

        include("../../../german/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');

        include("../../../indian/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo . '" WHERE Email = "' . $email . '"');

        include("../../../urdu/fyipanel/views/connect.php");
        $con->exec('UPDATE users SET  First_name="' . $this->First_name . '",Last_name = "' . $this->Last_name . '",Gender = "' . $this->Gender . '",Photo = "' . $this->Photo .
        '" WHERE Email = "' . $email . '"');
    }

    // user exist or not

    public function delete_user($email)
    {
        //jp
        include("../views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');
        //en
        include("../../../fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');
        //ar
        include("../../../arabic/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');
        //es
        include("../../../spanish/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');
        //tr
        include("../../../turkish/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');
        //chinese
        include("../../../chinese/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');
        //russian
        include("../../../russian/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');

        include("../../../french/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');

        include("../../../indian/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');

        include("../../../urdu/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');

        include("../../../hebrew/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');

        include("../../../german/fyipanel/views/connect.php");
        $con->exec('DELETE FROM users WHERE Email = "' . $email . '"');
    }
 

    //islogged

    public function users()
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from users');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    //islogged

    public function visitorsBycountryINday($d)
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from visitors where date="' . $d . '" group by country');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    //isLoged_but_un_lock

    public function visitorsByDayincoutry($d)
    {
        include("../views/connect.php");
        $tab = array();
        $query = $con->query('select * from visitors where country="' . $d . '" group by date');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }


    /*  public static function active_status1($email){
           include('../views/connect.php');
           $query = 'update users  set status=1 where Email="'.$email.'"';  
            mysqli_query($connect, $query);
        }  

 public static function disactive_status1($email){
           include('../views/connect.php');
           $query = 'update users  set status=0 where Email="'.$email.'"';  
            mysqli_query($connect, $query);
        }   */

    //active_status

    public function userexist($email)
    {
        include("../views/connect.php");
        $sql = 'select * from users where Email="' . $email . '"';
        $query = $con->query($sql);
        if ($data = $query->fetch()) {
            $this->Email = $data['Email'];
            $this->First_name = $data['First_name'];
            $this->Last_name = $data['Last_name'];
            $this->Gender = $data['Gender'];
            $this->Photo = $data['Photo'];
            $this->Password = $data['Password'];
            $this->Function = $data['Function'];
            if ($this->getEmail() != null) {
                return $this;
            } else {
                return null;
            }
        }
    }

    //disactive_status

    public function getEmail()
    {
        return $this->Email;
    }


    // find user by email ***

    public function setEmail($value)
    {
        if (!empty($value))
            $this->Email = $value;

    }

    //

    public function Function_userexist($email, $pass)
    {
        include('../views/connect.php');
        $sql = 'select * from users where Email="' . $email . '" and Password="' . $pass . '"';
        $query = $con->query($sql);
        if ($data = $query->fetch()) {
            $this->Email = $data['Email'];
            $this->First_name = $data['First_name'];
            $this->Last_name = $data['Last_name'];
            $this->Gender = $data['Gender'];
            $this->Photo = $data['Photo'];
            $this->Password = $data['Password'];
            $this->Function = $data['Function'];
            if ($this->getEmail() != null && $this->getPassword() != null && $this->getFunction() != null) {
                return $this;
            } else {
                return null;
            }
        }
    }


    //

    public function getPassword()
    {
        return $this->Password;
    }

    // currentpass

    public function setPassword($value)
    {
        if (!empty($value))
            $this->Password = $value;

    }

    // total males

    public function getFunction()
    {
        return $this->Function;
    }

    // total males

    public function setFunction($value)
    {
        if (!empty($value))
            $this->Function = $value;

    }

    public function Function_userexist2($email)
    {
        include('../views/connect.php');
        $sql = 'select * from users where Email="' . $email . '" ';
        $query = $con->query($sql);
        if ($data = $query->fetch()) {
            $this->Email = $data['Email'];
            $this->First_name = $data['First_name'];
            $this->Last_name = $data['Last_name'];
            $this->Gender = $data['Gender'];
            $this->Photo = $data['Photo'];
            $this->Password = $data['Password'];
            $this->Function = $data['Function'];
            if ($this->getEmail() != null && $this->getPassword() != null && $this->getFunction() != null) {
                return $this;
            } else {
                return null;
            }
        }
    }

    public function active_status($email)
    {
        include('../views/connect.php');
        $con->exec('update users  set status=1 where Email="' . $email . '"');
    }

    public function disactive_status($email)
    {
        include('../views/connect.php');
        $con->exec('update users  set status=0 where Email="' . $email . '"');
    }

    // total males

    public function finduser($id)
    {
        include("../views/connect.php");
        $rqt = $con->query("SELECT * FROM users where Email = '" . $id . "'");
        if ($data = $rqt->fetch()) {
            $this->Email = $data['Email'];
            $this->First_name = $data['First_name'];
            $this->Last_name = $data['Last_name'];
            $this->Gender = $data['Gender'];
            $this->Photo = $data['Photo'];
            $this->Password = $data['Password'];
            $this->Function = $data['Function'];
            return $this;
        } else {
            return null;

        }

    }

    // count of users

    public function getuser($mail)
    {
        include("../views/connect.php");
        $rqt = $con->query("SELECT * FROM users where Email  = '" . $mail . "'");
        if ($data = $rqt->fetch()) {
            $this->Email = $data['Email'];
            $this->First_name = $data['First_name'];
            $this->Last_name = $data['Last_name'];
            $this->Gender = $data['Gender'];
            $this->Photo = $data['Photo'];
            $this->Password = $data['Password'];
            $this->Function = $data['Function'];
            return $this;
        } else {
            return null;
        }

    }

    public function get_current_pass($email)
    {
        include("../views/connect.php");
        $requete = $con->prepare("SELECT Password FROM users  where Email  = '" . $email . "'");
        $requete->execute();
        $pass = $requete->fetchColumn();
        return $pass;
    }


    // count of users

    public function controle_counter()
    {
        include("../views/connect.php");
        $requete = $con->prepare('SELECT COUNT(*) FROM users');
        $requete->execute();
        $nb_res = $requete->fetchColumn();
        return $nb_res;
    }

}

?>
		
		
		