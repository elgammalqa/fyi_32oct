<?php

class v4Utilisteurs
{
    //v4
    public static function check_country($email, $country)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT count(*) FROM `rss_sources` WHERE `country`='$country' and id not IN (select id from user_sources where email='$email')");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public static function nb_rss_sources_of_country($country)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT count(*) FROM `rss_sources` WHERE `country`='$country' ");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public static function get_ids_of_country($country)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query('select id from rss_sources where country = "' . $country . '"');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    //v4 favorite_sources
    public static function check_sourcesOfCountry($email, $country, $source)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT count(*) FROM `rss_sources` WHERE `country`='$country' and `source`='$source' and id not IN (select id from user_sources where email='$email')");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public static function get_ids_of_source($country, $source)
    {
        include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query('select id from rss_sources where country = "' . $country . '" and source = "' . $source . '"');
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }

    public static function nbSourcesunCheckedWithoutCCountry($email, $country)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT count(*) FROM `rss_sources` WHERE `country`!='$country' and id  IN (select id from user_sources where email='$email')");
        $sql->execute();
        $nb = $sql->fetchColumn();
        return $nb;
    }

    public static function nb_rss_of_CountryAndSource($country, $source)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT count(*) FROM `rss_sources` WHERE `country`='$country' and `source`='$source'");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    //v4 types
    public static function nbSourcesunCheckedWithoutCSources($email, $source)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT count(*) FROM `rss_sources` WHERE `source`!='$source' and id  IN (select id from user_sources where email='$email')");
        $sql->execute();
        $nb = $sql->fetchColumn();
        return $nb;
    }

    public static function nb_rss_of_CountryAndSourceAndTypes($country, $source)
    {
        include 'fyipanel/views/connect.php';
        $sql = $con->prepare("SELECT count(*) FROM `rss_sources` WHERE `country`='$country' and `source`='$source'");
        $sql->execute();
        $pass = $sql->fetchColumn();
        return $pass;
    }

    public static function get_country_arabic_name($country)
    {
        switch ($country) {
            case 'united states':
                $country_to_display = 'الولايات المتحدة';
                break;
            case 'united kingdom':
                $country_to_display = 'انجلترا';
                break;
            case 'kuwait':
                $country_to_display = 'الكويت';
                break;
            case 'qatar':
                $country_to_display = 'قطر';
                break;
            case 'palestine':
                $country_to_display = 'فلسطين';
                break;
            case 'russia':
                $country_to_display = 'روسيا';
                break;
            case 'turkey':
                $country_to_display = 'تركيا';
                break;
            case 'spain':
                $country_to_display = 'اسبانيا';
                break;
            case 'saudi arabia':
                $country_to_display = 'السعودية';
                break;
            case 'egypt':
                $country_to_display = 'مصر';
                break;
            case 'libya':
                $country_to_display = 'ليبيا';
                break;
            case 'lebanon':
                $country_to_display = 'لبنان';
                break;
            case 'algeria':
                $country_to_display = 'الجزائر';
                break;
            case 'oman':
                $country_to_display = 'عمان';
                break;
            case 'bahrain':
                $country_to_display = 'البحرين';
                break;
            case 'yemen':
                $country_to_display = 'اليمن';
                break;
            case 'iraq':
                $country_to_display = 'العراق';
                break;
            case 'syria':
                $country_to_display = 'سوريا';
                break;
            case 'jordan':
                $country_to_display = 'الأردن';
                break;
            case 'tunisia':
                $country_to_display = 'تونس';
                break;
            case 'morocco':
                $country_to_display = 'المغرب';
                break;
            case 'united arab emirates':
                $country_to_display = 'الإمارات';
                break;
            case 'australia':
                $country_to_display = 'أستراليا';
                break;
        }
        return $country_to_display;
    }

    public static function get_country_unique_sources($country)
    {
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("select distinct(source) from rss_sources where country = '$country'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function delete_user_notif_all_country_sources($country, $user_id)
    {
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("delete from user_notification_sources where user_id = '$user_id' and country = '$country' ");
        $stmt->execute();
    }

    public static function delete_user_all_notif($user_id)
    {
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("delete from user_notification_sources where user_id = '$user_id' ");
        $stmt->execute();
    }

    public static function add_user_notif_source($country, $source, $user_id)
    {
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("insert into user_notification_sources values (null, '$user_id', :source, '$country')");
        $stmt->bindParam(':source',$source);
        $stmt->execute();
    }

    public static function check_user_source_notif($user_id, $country, $source)
    {
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("select * from user_notification_sources where user_id = '$user_id' and country = '$country' and source = :source");
        $stmt->bindParam(':source',$source);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function count_source_in_user_sources($source, $country)
    {
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("select * from user_notification_sources where source = :source and country = '$country'");
        $stmt->bindParam(':source',$source);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function get_all_user_notif_sources($user_id){
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("select * from user_notification_sources where user_id = :id");
        $stmt->bindParam(':id',$user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function update_user($value, $user_id){
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("update utilisateurs set web_token = :val where user_id = :id");
        $stmt->bindParam(':id',$user_id);
        $stmt->bindParam(':val',$value);
        $stmt->execute();
    }

}

?>