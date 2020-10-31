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
        $stmt->bindParam(':source', $source);
        $stmt->execute();
    }

    public static function check_user_source_notif($user_id, $country, $source)
    {
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("select * from user_notification_sources where user_id = '$user_id' and country = '$country' and source = :source");
        $stmt->bindParam(':source', $source);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public static function count_source_in_user_sources($source, $country)
    {
        include 'fyipanel/views/connect.php';
        $stmt = $con->prepare("select * from user_notification_sources where source = :source and country = '$country'");
        $stmt->bindParam(':source', $source);
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