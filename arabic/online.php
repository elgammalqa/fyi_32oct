<?php  
ini_set('error_reporting',E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log','online.log');

function getUserIP()
{ 
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote; 
    }

    return $ip;
}

function get_user_country()
{
    $ip = getUserIP(); 
    $url = 'http://www.geoplugin.net/json.gp?ip=' . $ip;
    $cURL = curl_init();
    curl_setopt($cURL, CURLOPT_URL, $url);
    curl_setopt($cURL, CURLOPT_CONNECTTIMEOUT, 50);
    curl_setopt($cURL, CURLOPT_TIMEOUT, 20);
    curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($cURL, CURLOPT_HTTPHEADER, array('Accept: application/json'));
    $result = curl_exec($cURL);
    curl_close($cURL);
    $ip_data = @json_decode($result, true);
    if ($ip_data && $ip_data['geoplugin_countryName'] != null) {
        $country = strtolower($ip_data['geoplugin_countryName']);
        $city = $ip_data['geoplugin_city'];
        $countryCode = $ip_data['geoplugin_countryCode'];
        $tz = $ip_data['geoplugin_timezone'];
    }
    else{
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        if ($query && $query['status'] == 'success') {
            $country = strtolower($query['country']);
            $city = $query['city'];
            $countryCode = $query['countryCode'];
            $tz = $query['timezone'];
        }
    }

    $location = array();
    @$location['country'] = $country;
    @$location['countryCode'] = $countryCode;
    @$location['city'] = $city;

    return $location;
}

function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function dateexiste($d)
{
    include 'fyipanel/views/connect.php';
    $requete = $con->prepare('select date from dates where date="' . $d . '"');
    $requete->execute();
    $date = $requete->fetchColumn();
    return $date;
} 
function time_existe($current_time)
{
    include 'fyipanel/views/connect.php';
    $requete = $con->prepare('select time from total_visitors where time="' . $current_time . '"');
    $requete->execute();
    $tim = $requete->fetchColumn();
    return $tim;
}

function nb_total_visitors()
{
    include 'fyipanel/views/connect.php';
    $requete = $con->prepare('select sum(nb) from visitors');
    $requete->execute();
    $date = $requete->fetchColumn();
    return $date;
}

function countryexiste($c)
{
    include 'fyipanel/views/connect.php';
    $requete = $con->prepare('select country from countries where country="' . $c . '"');
    $requete->execute();
    $date = $requete->fetchColumn();
    return $date;
}

function visitorexiste($d, $c)
{
    include 'fyipanel/views/connect.php';
    $requete = $con->prepare('select country from visitors where date="' . $d . '" and country="' . $c . '"');
    $requete->execute();
    $country = $requete->fetchColumn();
    return $country;
}

function country_info_null($c, $att)
{
    include 'fyipanel/views/connect.php';
    $requete = $con->prepare('select country from countries where  ' . $att . '="" 
             and country="' . $c . '"');
    $requete->execute();
    $country = $requete->fetchColumn();
    return $country;
}

function update_info($c, $att, $v)
{
    include 'fyipanel/views/connect.php';
    $con->exec('update countries set ' . $att . '="' . $v . '" where  country="' . $c . '"');
}
 
function updatenbvisitor($d, $c)
{
    include 'fyipanel/views/connect.php';
    $con->exec('update visitors set nb=nb+1 where date="' . $d . '" and country="' . $c . '"');
}

function insert_date($today)
{
    include 'fyipanel/views/connect.php';
    $con->exec('INSERT INTO dates  VALUES ("' . $today . '")');
}

function insert_country($country, $city, $countryCode, $tz)
{
    include 'fyipanel/views/connect.php';
    $con->exec('INSERT INTO countries  VALUES ("' . $country . '","' . $city . '","' . $countryCode . '","' . $tz . '")');
} 

//online visitors
 
function insert_onlinevisitor($current_time,$timeout)
{
    include 'fyipanel/views/connect.php';
    $current_time=date("Y-m-d h:i", $current_time);
    $timeout=date("Y-m-d h:i", $timeout);
    
    if(time_existe($current_time)==null){
        $con->exec("insert into total_visitors values ('" . $current_time . "',1)");
    }else{
        $con->exec('update total_visitors set nb=nb+1 where time="' . $current_time . '" ');
    } 
    $con->exec("delete from total_visitors where time<'" . $timeout."'");
}

function insert_Visitor($today, $country)
{
    include 'fyipanel/views/connect.php';
    $con->exec('INSERT INTO visitors  VALUES ("' . $today . '","' . $country . '",1)');
}
   
 

function data($today, $country, $city, $countryCode, $tz)
{
    if (dateexiste($today) == null) insert_date($today);
    if (countryexiste($country) == null) { // country not existe
        insert_country($country, $city, $countryCode, $tz);
    } else { 
        $info = 'geoplugin_city';
        if (country_info_null($country, $info) != null && $city != "") {
            update_info($country, $info, $city);
        }
        $info = 'geoplugin_countryCode';
        if (country_info_null($country, $info) != null && $countryCode != "") {
            update_info($country, $info, $countryCode);
        }
        $info = 'geoplugin_timezone';
        if (country_info_null($country, $info) != null && $tz != "") {
            update_info($country, $info, $tz);
        }
    }

    if (visitorexiste($today, $country) == null) {
        insert_Visitor($today, $country);
    } else {
        updatenbvisitor($today, $country);
    }
}


function data_session($today, $country)
{
    if (dateexiste($today) == null) insert_date($today); 
    if (visitorexiste($today, $country) == null) {
        insert_Visitor($today, $country);
    } else {
        updatenbvisitor($today, $country);
    }
}

function getip()
{ 
    date_default_timezone_set('GMT');
    $today = date("Y-m-d");
    $current_time = time();
    $timeout = $current_time - (300);
    include 'fyipanel/views/connect.php';  
    if(isset($_SESSION['all']['country'])&&isset($_SESSION['all']['date'])){//session
        $country=$_SESSION['all']['country']; 
        if(countryexiste($country)==null){//country not existe in this lang
            new_user_or_get_country_info($today,$current_time,$timeout);
        }else{//country exist in this lang
            if($_SESSION['all']['date']!=$today){ 
                $_SESSION['all']['date']==$today;
            } 
            data_session($today, $country);
            insert_onlinevisitor($current_time,$timeout);
        }
    }else{//new session    
        new_user_or_get_country_info($today,$current_time,$timeout);
    }
}
 
 function new_user_or_get_country_info($today,$current_time,$timeout)
 {
     $ip = getUserIP(); 
    //$ip = '37.120.132.74'; //US IP
    //desktop
    $desktop = false;
    $mobile = false; 
    if (isMobile() == false) {
        $url = 'http://www.geoplugin.net/json.gp?ip=' . $ip;
        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_CONNECTTIMEOUT, 50);
        curl_setopt($cURL, CURLOPT_TIMEOUT, 20);
        curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        $result = curl_exec($cURL);
        $ip_data = @json_decode($result, true);
        if ($ip_data && $ip_data['geoplugin_countryName'] != null) {
            $country = $ip_data['geoplugin_countryName'];
            $city = $ip_data['geoplugin_city'];
            $countryCode = $ip_data['geoplugin_countryCode'];
            $tz = $ip_data['geoplugin_timezone'];
            $desktop = true;
        } 
        curl_close($cURL); 
    } else {
        //mobile 
        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
        if ($query && $query['status'] == 'success') {
            $mobile = true;
            $country = $query['country'];
            $city = $query['city'];
            $countryCode = $query['countryCode']; 
            $tz = $query['timezone'];
        }
    } //mobile

    if ($mobile || $desktop) {   
            data($today, $country, $city, $countryCode, $tz); 
            insert_onlinevisitor($current_time,$timeout); 
            $_SESSION['all']=array('country'=>$country,'date'=>$today);   
    }//country 
 }
function get_list_of_countries(){
    include 'fyipanel/views/connect.php';
    $stmt = $con->prepare("SELECT DISTINCT(country) FROM rss_sources");
    $stmt->execute();
    $resource_countries = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $resource_countries[] = strtolower($row['country']);
    }
    return $resource_countries;
}

function get_arabic_country_name($country){
    switch ($country){
        case 'united states':
            $country = 'الولايات المتحدة';
            break;
        case 'united kingdom':
            $country = 'انجلترا';
            break;
        case 'kuwait':
            $country = 'الكويت';
            break;
        case 'qatar':
            $country = 'قطر';
            break;
        case 'palestine':
            $country = 'فلسطين';
            break;
        case 'russia':
            $country = 'روسيا';
            break;
        case 'turkey':
            $country = 'تركيا';
            break;
        case 'spain':
            $country = 'اسبانيا';
            break;
        case 'saudi arabia':
            $country = 'السعودية';
            break;
        case 'egypt':
            $country = 'مصر';
            break;
        case 'libya':
            $country = 'ليبيا';
            break;
        case 'lebanon':
            $country = 'لبنان';
            break;
        case 'united arab emirates':
            $country = 'الإمارات';
            break;
        case 'morocco':
            $country = 'المغرب';
            break;
        case 'iraq':
            $country = 'العراق';
            break;
        case 'bahrain':
            $country = 'البحرين';
            break;
        case 'algeria':
            $country = 'الجزائر';
            break;
        case 'oman':
            $country = 'عمان';
            break;
        case 'tunisia':
            $country = 'تونس';
            break;
        case 'syria':
            $country = 'سوريا';
            break;
        case 'yemen':
            $country = 'اليمن';
            break;
        case 'jordan':
            $country = 'الأردن';
            break;
    }
    return$country;
}
  
getip();
?>
 