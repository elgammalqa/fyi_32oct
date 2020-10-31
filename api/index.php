<?php
header('Content-Type: application/json');
ini_set('error_reporting',E_ALL ^ E_DEPRECATED);
ini_set('display_errors', 'On');
ini_set('log_errors', 'On');
ini_set('error_log','LOG_api.log');

require '../vendor/autoload.php';
use nadar\quill\Lexer;

/*require_once 'Queries.php';
$q = new Queries($lang, $domain, $root);
echo '<pre>';
$data = $q->get_twitter_accounts();
foreach ($data as $item){
    $old_tw_account = $item['twitter'];
    $tw_account = str_replace('@','',$old_tw_account);
    $q->fix_twitter_account($old_tw_account, $tw_account);
}
echo '</pre>';
exit;*/

date_default_timezone_set('GMT');
$output = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    include '../fyipanel/views/connect.php';
    $ip = getUserIP();
    $req = json_encode($_POST);
    $at = date('Y-m-d H:i:s');
    $stmt = $con->prepare("insert into tempdata values(null, '$ip', '$req', '$at')");
    $stmt->execute();
    $con = null;
    unset($con);

    if(!isset($_POST['do']) || trim($_POST['do']) == ''){
        $output['error'] = 1;
        $output['message'] = 'Operation not specified';
    }

    if(!isset($_POST['lang']) || trim($_POST['lang']) == ''){
        $output['error'] = 1;
        $output['message'] = 'Language is missing';
    }

    else{
        require 'security.php';
        $lang = filter_text($_POST['lang']);
        /*$domain = 'http://127.0.0.1/fyi/';
        $root = 'http://127.0.0.1/fyi/';*/

        $domain = 'https://www.fyipress.net/';
        $root = 'https://www.fyipress.net/';

        switch ($lang){
            case 'ar':
                $domain .= 'arabic/';
                break;
            case 'en':
                break;
            case 'tu':
                $domain .= 'turkish/';
                break;
            case 'ur':
                $domain .= 'urdu/';
                break;
            case 'sp':
                $domain .= 'spanish/';
                break;
            case 'ru':
                $domain .= 'russian/';
                break;
            case 'jp':
                $domain .= 'japanese/';
                break;
            case 'in':
                $domain .= 'indian/';
                break;
            case 'ge':
                $domain .= 'german/';
                break;
            case 'fr':
                $domain .= 'french/';
                break;
            case 'ch':
                $domain .= 'chinese/';
                break;
            case 'he':
                $domain .= 'hebrew/';
                break;
            default:
                $output['error'] = 1;
                $output['message'] = 'Language Error';
                echo json_encode($output);
                die('');
        }
        
        require 'languages/'.$lang.'.php';
        require 'time/'.$lang.'_timee.php';

        $key = 'fyipress2020';

        $valid = false;

        $do = filter_text($_POST['do']);

        require_once('models/Utilisateurs.model.php');
        $utilisateur = new utilisateursModel($lang);

        switch ($do) {

            case 'get_countries':

                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }

                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {
                    require 'Queries.php';
                    $q = new Queries($lang, $domain, $root);

                    $countries = $q->get_countries();

                    $status = 0;
                    $log_error = 0;

                    if (isset($_POST['email']) && isset($_POST['password'])) {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $status = check_login($email, $password, $time, $lang);

                        switch ($status) {
                            case '0':
                                $log_error = 1;
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '2':
                                $log_error = 1;
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $log_error = 1;
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                    }

                    if($log_error == 0){
                        require_once 'models/v4.utilisateurs.model.php';
                        $v4Model = new v4Utilisteurs($lang);

                        if (is_array($countries)) {
                            $output['error'] = 0;
                            if ($status == 1) {

                                foreach ($countries as $key => $country) {
                                    $count = $q->check_fav_country($email, $country['country_name']);
                                    $countries[$key]['is_source'] = ($count > 0) ? 1 : 0;
                                    $countries[$key]['name_en'] = $country['country_name'];
                                    if($lang == 'ar'){
                                        $countries[$key]['name_ar'] = $v4Model->get_country_arabic_name(strtolower($country['country_name']));
                                    }
                                    else{
                                        $countries[$key]['name_ar'] = '';
                                    }

                                    unset($countries[$key]['country_name']);
                                }

                            }
                            else{
                                foreach ($countries as $key => $country) {
                                    $countries[$key]['is_source'] = 0;
                                    $countries[$key]['name_en'] = $country['country_name'];
                                    if($lang == 'ar'){
                                        $countries[$key]['name_ar'] = $v4Model->get_country_arabic_name(strtolower($country['country_name']));
                                    }
                                    else{
                                        $countries[$key]['name_ar'] = '';
                                    }

                                    unset($countries[$key]['country_name']);
                                }
                            }
                            $output['countries'] = $countries;
                        } else {
                            $output['error'] = 1;
                            $output['countries'] = 'Error listing countries';
                        }
                    }


                }

                break;

            case 'get_country_sources':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }

                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    $log = false;

                    if (!isset($_POST['email']) || !isset($_POST['password'])) {

                        $is_source = 0;
                        $log = false;

                    } else {

                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $status = check_login($email, $password, $time, $lang);

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                    }

                    $country = filter_text($_POST['country']);

                    if ($country == '' || !isset($_POST['country'])) {
                        $output['error'] = 1;
                        $output['message'] = 'Missing country';
                    } else {

                        require 'Queries.php';

                        $q = new Queries($lang, $domain, $root);

                        $sources = $q->get_country_sources($country);

                        $unique_sources = array();
                        foreach ($sources as $source) {
                            $unique_sources[] = $source['source_name'];
                        }
                        $unique_sources = array_unique($unique_sources);

                        $new_unique = array();

                        require_once('models/v4.utilisateurs.model.php');
                        $v4Util = new v4Utilisteurs($lang);

                        foreach ($unique_sources as $key => $unique_source) {
                            $arr = array();

                            if($lang == 'ar'){
                                $arr['source_name'] = $utilisateur->source($unique_source);
                            }
                            else{
                                $arr['source_name'] = $unique_source;
                            }

                            $arr['twitter'] = '';
                            $arr['topic_name'] = $lang.'-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$unique_source);
                            $source_row = $utilisateur->get_source_row($unique_source);
                            $source_tw = $utilisateur->get_source_twitter($unique_source);
                            if(is_array($source_tw)){
                                if(count($source_tw) > 0 && isset($source_tw['twitter'])){
                                    $arr['twitter'] = $source_tw['twitter'];
                                }
                            }


                            $arr['can_select_as_source'] = 1;

                            if($source_row['type'] == 'Health'){
                                $arr['can_select_as_source'] = 0;
                            }

                            $arr['source'] = $unique_source;


                            $id_count = $v4Util->count_source_in_user_sources($unique_source, $country);
                            unset($arr[0]);
                            $arr['followers'] = number_format_unchanged_precision($id_count);

                            foreach ($sources as $key => $item) {
                                if ($item['source_name'] == $unique_source) {
                                    $arr['source_logo'] = $item['source_logo'];
                                    continue;
                                }
                            }

                            if ($log) {

                                $nb = $v4Util->check_sourcesOfCountry($email, $country, $unique_source);
                                if ($nb == 0) {
                                    $arr['is_source'] = 0;
                                } else {
                                    $arr['is_source'] = 1;
                                }

                                $user_row = $q->get_user_row($email);
                                $user_notif_row_count = $v4Util->check_user_source_notif($user_row['user_id'],$country, $unique_source);
                                if($user_notif_row_count == 1){
                                    $arr['notifications_from_this_source'] = 1;
                                }
                                else{
                                    $arr['notifications_from_this_source'] = 0;
                                }

                            } else {
                                $arr['is_source'] = 0;
                                $arr['notifications_from_this_source'] = 0;
                                $arr['can_select_as_source'] = 0;
                            }


                            $arr['types'] = array();

                            foreach ($sources as $key => $item) {
                                if ($item['source_name'] == $unique_source) {
                                    $t = array();
                                    if($lang == 'en'){
                                        $t['name'] = $item['type'];
                                        $t['ar_name'] = '';
                                    }
                                    else{
                                        $t['ar_name'] = $utilisateur->type($item['type'], $lang);
                                        $t['name'] = $item['type'];
                                    }

                                    $t['thumb'] = $root . 'v2/types/' . $item['type'] . '.png';

                                    if ($log) {

                                        $id = $utilisateur->get_id_rss_source($country, $unique_source, $item['type']);
                                        $emaill = $utilisateur->check_source($email, $id);
                                        if ($emaill != null) {
                                            $t['is_source'] = 0;
                                        } else {
                                            $t['is_source'] = 1;
                                        }
                                    } else {
                                        $t['is_source'] = 0;
                                    }

                                    $arr['types'][] = $t;
                                    unset($t);
                                }
                            }

                            $new_unique[] = $arr;
                            unset($arr);
                        }

                        if (is_array($sources)) {
                            $output['error'] = 0;
                            $output['country'] = $country;
                            $output['country_flag'] = $sources[0]['flag'];
                            $output['sources'] = $new_unique;
                            //$output['sources'] = $sources;
                        } else {
                            $output['error'] = 1;
                            $output['message'] = 'No sources';
                        }
                    }

                }

                break;

            case 'register':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }

                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['confirm_password']) || !isset($_POST['name'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                        break;
                    } else {

                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $confirm_password = filter_text($_POST['confirm_password']);
                        $name = filter_text($_POST['name']);

                        //encrypt('abcd1234', '1570351159380');
                        //echo decrypt('VJEuPq2x/pVlK78i/X67oB3d6Vh77oCXvqXpyBI5/4c=', '1570351159380');
                        //exit;

                        $password = decrypt($password, $time);
                        $confirm_password = decrypt($confirm_password, $time);
                        //echo $password;exit;

                        if ($utilisateur->userexist($email) != null) {
                            $output['error'] = 1;
                            $output['message'] = $translation['account_exists'];
                        } else {
                            $text = $password;
                            $CountOfNumbers = count(array_filter(str_split($text), 'is_numeric'));
                            $NumbresOfCaracteres = strlen($text);
                            $msgg = "";

                            if ($NumbresOfCaracteres < 6) {
                                $msgg = $translation['password_terms'];
                                $output['error'] = 1;
                                $output['message'] = $msgg;
                                //break;
                            } else {
                                if ($CountOfNumbers >= 1) {
                                    if ($NumbresOfCaracteres - $CountOfNumbers <= 0) {
                                        $msgg = $translation['password_terms'];
                                        $output['error'] = 1;
                                        $output['message'] = $msgg;
                                        break;
                                    }
                                } else {
                                    $msgg = $translation['password_terms'];
                                    $output['error'] = 1;
                                    $output['message'] = $msgg;
                                    break;
                                }
                                //break;
                            }

                            $token = $utilisateur->generateNewString();
                            $utilisateur->setisEmailConfirmed(0);
                            $utilisateur->settoken(strip_tags($token));
                            $utilisateur->setemail($email);
                            $utilisateur->setname($name);
                            if ($msgg == "") {
                                $pass = password_hash($text, PASSWORD_DEFAULT);
                                $utilisateur->setpassword($pass);

                                if ($password == $confirm_password) {

                                    $smtpsecure = $utilisateur->info("smtpsecure");
                                    $email_sender = $utilisateur->info("email");
                                    $password_sender = $utilisateur->info("password");
                                    $host = $utilisateur->info("host");
                                    $port = $utilisateur->info("port");
                                    $link = $utilisateur->info("link");
                                    $smtpsecure = str_replace(' ', '', $smtpsecure);
                                    $email_sender = str_replace(' ', '', $email_sender);
                                    $password_sender = str_replace(' ', '', $password_sender);
                                    $host = str_replace(' ', '', $host);
                                    $port = str_replace(' ', '', $port);
                                    $link = str_replace(' ', '', $link);

                                    require('PHPMailer-master/PHPMailerAutoload.php');
                                    $mail = new PHPMailer();
                                    $mail->IsSmtp();
                                    $mail->SMTPDebug = 0;
                                    $mail->SMTPAuth = true;
                                    $mail->SMTPSecure = $smtpsecure;
                                    $mail->Host = $host; //ftpupload.net
                                    $mail->Port = $port; //or 587
                                    $mail->IsHTML(true);
                                    $mail->CharSet = 'UTF-8';
                                    $mail->Username = $email_sender;
                                    $mail->Password = $password_sender;
                                    $mail->SetFrom($email_sender, $translation['fyipress_website']);
                                    $mail->Subject = $translation['act_email_subject'];
                                    $mail->AddAddress($email, $name);
                                    $mail->Body = "  

                                  <table border='0' cellpadding='0' cellspacing='0'style='margin-left:17%;'  >
                                        <tbody> 
                                            <tr>
                                                <td  >
                                                    <a>
                                                       <img src='$link/images/fyipress.png' 
                                                       style='padding:20px; width: 350px; height: 70px;' >
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='font-size: 19px; padding: 20px;  font-family: Helvetica; line-height: 150%; text-align: right;' >
                                                   <span style='float:right;' >
                                                   ".$translation['welcome']."    
                                                    </span>
                                                    <span style='float:right;' >
                                                    $name &nbsp;
                                                   </span>
                                                   <br> <br>
                                                   ".$translation['to_fyi_website']."      <br><br>
                                                   ".$translation['to_activate_account']."
                                                    <br>
                                                    ".$translation['please_click_link']." <br> <br> 
                                                    <span style='padding-right: 100px;' ></span>
                                                    <a style='text-decoration: none;' target='_blank' href='$link/confirm.php?email=$email&token=$token'>
                                                         <span 
                                                         style='font-family: Avenir,Helvetica,sans-serif;box-sizing: border-box;
                                                               border-radius: 3px; color: #fff;display: inline-block;
                                                               text-decoration: none; background-color: #2ab27b; border-top: 10px solid #2ab27b;
                                                               border-right: 18px solid #2ab27b; border-bottom: 10px solid #2ab27b;
                                                               border-left: 18px solid #2ab27b;  ' > 
                                                            ".$translation['confirm_email']." 
                                                        </span>
                                                    </a><br><br> 
                                                   ".$translation['fyi_support']."     
                                                </td>
                                            </tr> 
                                            <tr>  
                                                <td style='text-align: right; padding: 20px;' >
                                                    <a target='_blank' href='$link' style='font-size: 19px;   font-family: Helvetica; line-height: 150%; ' >
                                                    ".$translation['visit_website']."   
                                                    </a><br><br>
                                                    <span style='font-size: 19px;    font-family: Helvetica;
                                                     line-height: 150%; color: #505050;' >
                                                    ".$translation['fyi_copyrights']."       
                                                    </span> 
                                                </td>
                                            </tr>           
                                        </tbody> 
                                    </table> ";

                                    if ($mail->send()) {
                                        $utilisateur->add_utilisateur($pass);
                                        $output['error'] = 0;
                                        $output['message'] = $translation['success_registration'];
                                    } else {
                                        $output['error'] = 1;
                                        $output['message'] = $translation['register_error'];
                                    }
                                } else {
                                    $output['error'] = 1;
                                    $output['message'] = $translation['password_no_match'];
                                }
                            }
                            else {
                                $output['error'] = 1;
                                $output['message'] = $translation['password_terms'];
                            }
                        }
                    }
                }

                break;

            case 'login':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email']) || !isset($_POST['password'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                        break;
                    } else {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);

                        $status = check_login($email, $password, $time, $lang);

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                require 'Queries.php';
                                $q = new Queries($lang, $domain, $root);
                                $row = $q->get_user_row($email);
                                $output['error'] = 0;
                                $output['email'] = $email;
                                $output['name'] = $row['name'];
                                $output['profile_image'] = $row['image'];
                                $output['message'] = $translation['success_login'];
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                    }
                }

                break;

            case 'resend_verification_email':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                        break;
                    } else {
                        $email = filter_text($_POST['email']);

                        if ($utilisateur->email_exist($email)) {
                            if ($utilisateur->acount_is_non_confirmed($email)) {
                                $token = $utilisateur->generateNewString();
                                $name = $utilisateur->getUserName($email);

                                $smtpsecure = $utilisateur->info("smtpsecure");
                                $email_sender = $utilisateur->info("email");
                                $password_sender = $utilisateur->info("password");
                                $host = $utilisateur->info("host");
                                $port = $utilisateur->info("port");
                                $link = $utilisateur->info("link");
                                $smtpsecure = str_replace(' ', '', $smtpsecure);
                                $email_sender = str_replace(' ', '', $email_sender);
                                $password_sender = str_replace(' ', '', $password_sender);
                                $host = str_replace(' ', '', $host);
                                $port = str_replace(' ', '', $port);
                                $link = str_replace(' ', '', $link);

                                require('PHPMailer-master/PHPMailerAutoload.php');
                                $mail = new PHPMailer();
                                $mail->IsSmtp();
                                $mail->SMTPDebug = 0;
                                $mail->SMTPAuth = true;
                                $mail->SMTPSecure = $smtpsecure;
                                $mail->Host = $host; //ftpupload.net
                                $mail->Port = $port; //or 587
                                $mail->IsHTML(true);
                                $mail->CharSet = 'UTF-8';
                                $mail->Username = $email_sender;
                                $mail->Password = $password_sender;
                                $mail->SetFrom($email_sender, $translation['fyipress_website']);
                                $mail->Subject = $translation['confirm_email'] ;
                                $mail->AddAddress($email, $name);
                                $mail->Body = "     
                                     <table border='0' cellpadding='0' cellspacing='0'style='margin-left:17%;'  >
                                        <tbody> 
                                            <tr>
                                                <td  >
                                                    <a>
                                                       <img src='$link/images/fyipress.png' 
                                                       style='padding:20px; width: 350px; height: 70px;' >
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='font-size: 19px; padding: 20px;  font-family: Helvetica; line-height: 150%; text-align: right;' >
                                                   <span style='float:right;' >
                                                   ".$translation['welcome']."  
                                                   </span>
                                                    <span style='float:right; padding-right: 10px; padding-left: 10px; ' >
                                                    $name 
                                                   </span>
                                                   <br> <br>
                                                   ".$translation['to_fyi_website']."  <br><br>
                                                   ".$translation['to_activate_account']."
                                                    <br>
                                                    ".$translation['please_click_link']." <br> <br>
                                                    <span style='padding-right: 100px;' ></span>
                                                    <a style='text-decoration: none;' target='_blank' href='$link/confirm.php?email=$email&token=$token'>
                                                         <span 
                                                         style='font-family: Avenir,Helvetica,sans-serif;box-sizing: border-box;
                                                               border-radius: 3px; color: #fff;display: inline-block;
                                                               text-decoration: none; background-color: #2ab27b; border-top: 10px solid #2ab27b;
                                                               border-right: 18px solid #2ab27b; border-bottom: 10px solid #2ab27b;
                                                               border-left: 18px solid #2ab27b;  ' > 
                                                            ".$translation['confirm_email']."
                                                        </span>
                                                    </a><br><br> 
                                                   ".$translation['fyi_support']."  
                                                </td>
                                            </tr> 
                                            <tr>  
                                                <td style='text-align: right; padding: 20px;' >
                                                    <a target='_blank' href='$link' style='font-size: 19px;   font-family: Helvetica; line-height: 150%; ' >
                                                    ".$translation['visit_website']."
                                                    </a><br><br>
                                                    <span style='font-size: 19px;    font-family: Helvetica;
                                                     line-height: 150%; color: #505050;' >
                                                    ".$translation['fyi_copyrights']."
                                                    </span> 
                                                </td>
                                            </tr>           
                                        </tbody>
                                    </table>  ";
                                if ($mail->send()) {
                                    $utilisateur->update_token($email, $token);
                                    $output['error'] = 0;
                                    $output['message'] = $translation['email_sent'];

                                } else {
                                    $output['error'] = 1;
                                    $output['message'] = $translation['error'];
                                }

                            } else { // email confirmed
                                $output['error'] = 1;
                                $output['message'] = $translation['email_already_activated'];
                            }
                        } else {
                            $output['error'] = 1;
                            $output['message'] = $translation['incorrect_email'] ;
                        }
                    }
                }

                break;

            case 'change_password':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                //encrypt('abcd1234', '1570351159380');
                //echo decrypt('FYJAne7JaUOmI05s4wrVZzWywswVMECl53ANztajUOA=', '1570351159380');
                //exit;

                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } elseif (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['new_password']) || !isset($_POST['confirm_password'])) {
                    $output['error'] = 1;
                    $output['message'] = $translation['missing_data'];
                } else {
                    $user_email = filter_text($_POST['email']);
                    $password = decrypt($_POST['password'], $time);
                    $new_password = decrypt($_POST['new_password'], $time);
                    $confirm_password = decrypt($_POST['confirm_password'], $time);

                    if (password_verify($password, $utilisateur->get_current_pass($user_email))) {

                        $text = $new_password;
                        $CountOfNumbers = count(array_filter(str_split($text), 'is_numeric'));
                        $NumbresOfCaracteres = strlen($text);
                        $msgg = "";
                        $tr = true;
                        if ($NumbresOfCaracteres < 6) {
                            $tr = false;
                        } else {
                            if ($CountOfNumbers >= 1) {
                                if ($NumbresOfCaracteres - $CountOfNumbers <= 0) {
                                    $tr = false;
                                }
                            } else {
                                $tr = false;
                            }
                        }

                        if ($tr == true) {
                            if ($new_password == $confirm_password) {
                                $ps = password_hash($text, PASSWORD_DEFAULT);
                                $utilisateur->update_pass($user_email, $ps);

                                $output['error'] = 0;
                                $output['message'] = $translation['password_successfully_changed'] ;
                            } else {
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                            }//confirm
                        } else {// 5 numbers and 1 letter
                            $msgg = $translation['password_terms'];
                            $output['error'] = 1;
                            $output['message'] = $msgg;
                            break;
                        }

                    } else {
                        $output['error'] = 1;
                        $output['message'] = $translation['auth_error'];
                    }//current
                }

                break;

            case 'check_source_country':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {
                    require 'Queries.php';
                    $country = filter_text($_POST['country']);
                    $email = filter_text($_POST['email']);
                    $password = filter_text($_POST['password']);
                    $status = check_login($email, $password, $time, $lang);

                    switch ($status) {
                        case '0':
                            $output['error'] = 1;
                            $output['message'] = $translation['incorrect_email'];
                            break;

                        case '1':
                            $q = new Queries($lang, $domain, $root);
                            $count = $q->check_fav_country($email, $country);
                            $output['error'] = 0;
                            $output['country'] = $country;
                            $output['is_source'] = ($count > 0) ? 1 : 0;
                            break;

                        case '2':
                            $output['error'] = 1;
                            $output['message'] = $translation['activate_email'];
                            break;

                        case '3':
                            $output['error'] = 1;
                            $output['message'] = $translation['auth_error'];
                            break;
                    }

                }

                break;

            case 'change_source_countries':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email']) || !isset($_POST['password'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                        break;
                    } else {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $status = check_login($email, $password, $time, $lang);

                        $log = false;

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                        if ($log) {
                            require_once('models/v4.utilisateurs.model.php');

                            $user_countries = filter_text($_POST['countries']);
                            $countries = explode(',', $user_countries);

                            $v4Util = new v4Utilisteurs($lang);

                            $all_countries_in_db = $utilisateur->get_countries();

                            $GLOBALS['nb_sources_not_checked'] = 0;
                            foreach ($all_countries_in_db as $country) {
                                if (!in_array($country['country'], $countries)) {
                                    $GLOBALS['nb_sources_not_checked'] += $v4Util->nb_rss_sources_of_country($country['country']);
                                }
                            }//foreach

                            $nb_rss_sources = $utilisateur->get_nb_rss_source();
                            $GLOBALS['nb_sources_not_checked'] = $nb_rss_sources - $GLOBALS['nb_sources_not_checked'];
                            if ($GLOBALS['nb_sources_not_checked'] >= 5) {//ok we can continue

                                $all_countries_in_db = $utilisateur->get_countries();
                                foreach ($all_countries_in_db as $country) {
                                    $currentCountry = $country['country'];
                                    if (!in_array($currentCountry, $countries)) { //country un checked
                                        $idsOfCurrentCountry = $v4Util->get_ids_of_country($currentCountry);
                                        foreach ($idsOfCurrentCountry as $row) {
                                            $id = $row['id'];

                                            $emaill = $utilisateur->check_source($email, $id);
                                            if ($emaill == null) {
                                                $utilisateur->add_user_sources($email, $id);
                                            }

                                        }//ids
                                    } else {//country checked
                                        $idsOfCurrentCountry = $v4Util->get_ids_of_country($currentCountry);
                                        foreach ($idsOfCurrentCountry as $row) {
                                            $id = $row['id'];
                                            if ($log == true) {
                                                $emaill = $utilisateur->check_source($email, $id);
                                                if ($emaill != null) {
                                                    $utilisateur->delete_user_sources($email, $id);
                                                }
                                            }
                                        }//ids
                                    }//country checked
                                }//foreach countries

                                $output['error'] = 0;
                                $output['message'] = $translation['updated_successfully'];
                            } else {//not ok
                                $output['error'] = 1;
                                $output['message'] = $translation['five_sources'];
                            }
                        }
                    }

                }

                break;

            case 'change_country_sources':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email']) || !isset($_POST['password'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                    } else {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $status = check_login($email, $password, $time, $lang);

                        $log = false;

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                        if ($log) {

                            $country = filter_text($_POST['country']);
                            $user_sources = filter_text($_POST['user_sources']);

                            if ($country == '' || !isset($_POST['country'])) {
                                $output['error'] = 1;
                                $output['message'] = 'Missing country';
                            } elseif (!isset($_POST['user_sources'])) {
                                $output['error'] = 1;
                                $output['message'] = 'Missing sources';
                            } else {
                                require_once('models/v4.utilisateurs.model.php');

                                $v4Util = new v4Utilisteurs($lang);

                                if (strstr($user_sources, ',')) {
                                    $new_sources = explode(',', $user_sources);
                                } elseif (!strstr($user_sources, ',')) {
                                    $new_sources = array();
                                    $new_sources[] = $user_sources;
                                }

                                $GLOBALS['nb_sources_not_checked'] = $v4Util->nbSourcesunCheckedWithoutCCountry($email, $country);
                                $req = $utilisateur->get_sources_of_country($country);
                                foreach ($req as $sources) { //reuters
                                    $currentSource = $sources["source"];
                                    if (!in_array($currentSource, $new_sources)) {//unch
                                        $GLOBALS['nb_sources_not_checked'] += $v4Util->nb_rss_of_CountryAndSource($country, $currentSource);
                                    }
                                }

                                $nb_rss_sources = $utilisateur->get_nb_rss_source();
                                $GLOBALS['nb_sources_not_checked'] = $nb_rss_sources - $GLOBALS['nb_sources_not_checked'];
                                if ($GLOBALS['nb_sources_not_checked'] >= 5) {//ok we can continue
                                    $req = $utilisateur->get_sources_of_country($country);
                                    foreach ($req as $sources) { //reuters
                                        $currentSource = $sources["source"];

                                        if (!in_array($currentSource, $new_sources)) { //source un checked
                                            $allids = $v4Util->get_ids_of_source($country, $currentSource);
                                            foreach ($allids as $row) {
                                                $id = $row['id'];
                                                if ($log == true) {
                                                    $emaill = $utilisateur->check_source($email, $id);
                                                    if ($emaill == null) {
                                                        $utilisateur->add_user_sources($email, $id);
                                                    }
                                                }
                                            }//ids
                                        } else {//country checked
                                            $allids = $v4Util->get_ids_of_source($country, $currentSource);
                                            foreach ($allids as $row) {
                                                $id = $row['id'];
                                                if ($log == true) {
                                                    $emaill = $utilisateur->check_source($email, $id);
                                                    if ($emaill != null) {
                                                        $utilisateur->delete_user_sources($email, $id);
                                                    }
                                                }
                                            }//ids
                                        }//country checked
                                    }//foreach countries

                                    $output['error'] = 0;
                                    $output['message'] = $translation['updated_successfully'];
                                } else {//not ok
                                    $output['error'] = 1;
                                    $output['message'] = $translation['five_sources'];
                                }
                            }

                        }
                    }
                }
                break;

            case 'change_source_categories':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email']) || !isset($_POST['password'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                    } else {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $status = check_login($email, $password, $time, $lang);

                        $log = false;

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                        if ($log) {

                            $country = filter_text($_POST['country']);
                            $source = filter_text($_POST['source']);
                            $types = filter_text($_POST['categories']);

                            if (strstr($types, ',')) {
                                $new_types = explode(',', $types);
                            } elseif (!strstr($types, ',')) {
                                $new_types = array();
                                $new_types[] = $types;
                            }

                            if ($country == '' || !isset($_POST['country'])) {
                                $output['error'] = 1;
                                $output['message'] = 'Missing country';
                            } elseif ($source == '' || !isset($_POST['source'])) {
                                $output['error'] = 1;
                                $output['message'] = 'Missing source';
                            } else {
                                require_once('models/v4.utilisateurs.model.php');

                                $v4Util = new v4Utilisteurs($lang);

                                $GLOBALS['nb_sources_not_checked'] = $v4Util->nbSourcesunCheckedWithoutCSources($email, $source);
                                $req = $utilisateur->get_types_of_country_and_source($country, $source);
                                foreach ($req as $types) { //news
                                    $currentType = $types["type"];
                                    if (!in_array($currentType, $new_types)) {//unch
                                        $GLOBALS['nb_sources_not_checked']++;
                                    }
                                }


                                if ($GLOBALS['nb_sources_not_checked'] >= 5) {//ok we can continue

                                    $req = $utilisateur->get_types_of_country_and_source($country, $source);
                                    foreach ($req as $types) { //news
                                        $currentType = $types["type"];
                                        $id = $utilisateur->get_id_rss_source($country, $source, $currentType);
                                        if (!in_array($currentType, $new_types)) { //type un checked
                                            if ($log == true) {
                                                $emaill = $utilisateur->check_source($email, $id);
                                                if ($emaill == null) {
                                                    $utilisateur->add_user_sources($email, $id);
                                                }
                                            }

                                        } else {//country checked
                                            $emaill = $utilisateur->check_source($email, $id);
                                            if ($emaill != null) {
                                                $utilisateur->delete_user_sources($email, $id);
                                            }

                                        }//country checked
                                    }//foreach countries

                                    $output['error'] = 0;
                                    $output['message'] = $translation['updated_successfully'];
                                } else {//not ok
                                    $output['error'] = 1;
                                    $output['message'] = $translation['five_sources'];
                                }
                            }

                        }
                    }
                }
                break;

            case 'get_category_news':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    $category = filter_text($_POST['category']);
                    $perPage = (int)$_POST['limit'];

                    if (isset($_POST['email']) && trim($_POST['email']) !== '' && isset($_POST['password']) && trim($_POST['password']) !== '') {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);

                        $status = check_login($email, $password, $time, $lang);

                        $log = false;

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                        if ($log) {
                            if (!isset($category) || $category == '') {
                                $output['error'] = 1;
                                $output['message'] = 'No category';
                            } else {
                                require 'Queries.php';
                                $q = new Queries($lang, $domain, $root);

                                $page = (int)$_POST['page'];

                                $all = $q->get_all_category_news($email, $category);
                                //print_r($all); exit;
                                $totalNews = count($all);

                                $pagenum = 1;
                                if (isset($page)) {
                                    $pagenum = $page;
                                }

                                $allPages = ceil($totalNews / $perPage);

                                $offset = ($pagenum - 1) * $perPage;

                                $news = $q->get_category_news($email, $category, $offset, $perPage);
                                foreach ($news as $k => $v){
                                    $news[$k]['title'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($news[$k]['title'])),ENT_QUOTES | ENT_HTML5);
                                    $news[$k]['description'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($news[$k]['description'])),ENT_QUOTES | ENT_HTML5);
                                    if($lang == 'ar'){
                                        $news[$k]['source'] = $utilisateur->source($news[$k]['source']);
                                    }

                                }
                                //print_r($news); exit;

                                foreach ($news as $key => $val) {
                                    $news_id = $val['id'];
                                    $news_comments_count = $q->count_news_comments($news_id);
                                    $count = $news_comments_count['total_comments'] + $news_comments_count['total_replies'];
                                    //print_r($news_comments_count); exit;
                                    $news[$key]['comments_count'] = $count;
                                    $news[$key]['when'] = trim(real_comments_time($val['pubDate']));
                                    $news[$key]['description'] = html_entity_decode(remove_extra_lines($news[$key]['description']),ENT_QUOTES | ENT_HTML5);

                                    if($val['rank'] == 1){
                                        $news[$key]['image'] = $domain.'fyipanel/views/image_news/'.$news[$key]['image'];
                                    }
                                    
                                }

                                if (is_array($news)) {
                                    $output['error'] = 0;
                                    $output['all_pages'] = $allPages;
                                    $output['news'] = $news;
                                } else {
                                    $output['error'] = 1;
                                    $output['message'] = 'No sources';
                                }

                            }
                        }
                    }
                    else {
                        if (!isset($category) || $category == '') {
                            $output['error'] = 1;
                            $output['message'] = 'No category';
                        } else {
                            require 'Queries.php';
                            $q = new Queries($lang, $domain, $root);

                            $page = (int)$_POST['page'];
                            $email = '';
                            $all = $q->get_all_category_news($email, $category);
                            //print_r($all); exit;
                            $totalNews = count($all);

                            $pagenum = 1;
                            if (isset($page)) {
                                $pagenum = $page;
                            }
                            $allPages = ceil($totalNews / $perPage);
                            $offset = ($pagenum - 1) * $perPage;

                            $news = $q->get_category_news($email, $category, $offset, $perPage);

                            foreach ($news as $key => $val) {
                                $video = '';
                                if($val['rank'] == 1){
                                    $this_news = $q->get_news_item($val['id'], $val['rank']);
                                    if($this_news['right_of_reply_id'] > 0){
                                        $right_of_reply = $q->get_right_of_reply($this_news['right_of_reply_id']);
                                        $video = $right_of_reply['video'];
                                    }
                                }

                                $news_id = $val['id'];
                                $news_comments_count = $q->count_news_comments($news_id);
                                $count = $news_comments_count['total_comments'] + $news_comments_count['total_replies'];
                                $news[$key]['comments_count'] = $count;
                                $news[$key]['when'] = trim(real_comments_time($val['pubDate']));
                                $news[$key]['video'] = $video;

                            }

                            if (is_array($news)) {
                                $output['error'] = 0;
                                $output['all_pages'] = $allPages;
                                $output['news'] = $news;
                            } else {
                                $output['error'] = 1;
                                $output['message'] = 'No sources';
                            }

                        }
                    }

                }

                break;

            case 'get_single_news':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (isset($_POST['news_id']) && isset($_POST['news_id']) !== '' && isset($_POST['news_id']) !== 0 && isset($_POST['rank']) && ($_POST['rank']) == 1 || $_POST['rank'] == 2) {
                        $news_id = (int)$_POST['news_id'];
                        $rank = (int)$_POST['rank'];
                        require 'Queries.php';
                        $q = new Queries($lang, $domain, $root);
                        $data = $q->get_news_item($news_id, $rank);

                        //print_r($data); exit;
                        if (is_array($data)) {

                            $log = false;

                            if (isset($_POST['email']) && trim($_POST['email']) !== '' && isset($_POST['password']) && trim($_POST['password']) !== '') {
                                $email = filter_text($_POST['email']);
                                $password = filter_text($_POST['password']);

                                $status = check_login($email, $password, $time, $lang);

                                switch ($status) {
                                    case '0':
                                        $output['error'] = 1;
                                        $output['message'] = $translation['incorrect_email'];
                                        break;

                                    case '1':
                                        $log = true;
                                        break;

                                    case '2':
                                        $output['error'] = 1;
                                        $output['message'] = $translation['activate_email'];
                                        break;

                                    case '3':
                                        $output['error'] = 1;
                                        $output['message'] = $translation['auth_error'];
                                        break;
                                }
                            }

                            if ($log) {
                                $user_row = $q->get_user_row($email);
                            }

                            $output['error'] = 0;

                            $data['description'] = html_entity_decode(remove_extra_lines($data['description']),ENT_QUOTES | ENT_HTML5);
                            $data['id'] = $data['news_id'];

                            $video = '';
                            if($rank == 1){
                                $data['content'] = html_entity_decode(remove_extra_lines(strip_tags(htmlspecialchars_decode($data['content']))),ENT_QUOTES | ENT_HTML5);
                                $data['source'] = $translation['fyipress'];
                                $data['source_logo'] = '';


                                $this_news = $q->get_news_item($news_id, 1);
                                if($this_news['right_of_reply_id'] > 0){
                                    $right_of_reply = $q->get_right_of_reply($this_news['right_of_reply_id']);
                                    $video = $right_of_reply['video'];
                                }

                            }
                            else{
                                $data['content'] = '';
                                $source = $data['source'];
                                if($lang == 'ar'){
                                    $data['source'] = $utilisateur->source($data['source']);
                                }

                                $data['source_logo'] = $root.'v2/sources/'.$source.'.png';

                            }

                            $data['video'] = $video;

                            $data['rank'] = $rank;
                            $data['when'] = trim(real_comments_time($data['pubDate']));

                            unset($data['right_of_reply_id']);

                            if($rank == 2){
                                $news_comments_count = $q->count_news_comments($news_id);
                                $count = $news_comments_count['total_comments'] + $news_comments_count['total_replies'];
                            }
                            else{
                                $news_comments_count = $q->count_panel_news_comments($news_id);
                                $count = $news_comments_count['total_comments'] + $news_comments_count['total_replies'];
                            }
                            $data['comments_count'] = $count;

                            if($rank == 2){
                                $news_comments = $q->get_news_comments($news_id);
                                foreach ($news_comments as $key1 => $val1) {
                                    //echo $val1['comment_id'].' - <br>';
                                    $when = trim(real_comments_time($val1['time']));
                                    $news_comments[$key1]['when'] = trim($when);
                                    $news_comments[$key1]['comment'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($news_comments[$key1]['comment'])),
                                        ENT_QUOTES | ENT_HTML5);

                                    if ($log) {
                                        $is_reported_comment = $q->check_if_user_reported_comment($email, $val1['comment_id'], $rank);
                                        $news_comments[$key1]['user_reported_comment'] = $is_reported_comment;
                                    }

                                    $comment_replies = $q->get_comment_replies($val1['comment_id']);
                                    if (is_array($comment_replies)) {
                                        foreach ($comment_replies as $k => $v) {
                                            $comment_replies[$k]['when'] = trim(real_comments_time($v['time']));
                                            $comment_replies[$k]['reply'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($comment_replies[$k]['reply'])),
                                                ENT_QUOTES | ENT_HTML5);

                                            if ($log) {
                                                $is_reported_reply = $q->check_if_user_reported_reply($email, $v['reply_id'], $rank);
                                                $comment_replies[$k]['user_reported_reply'] = $is_reported_reply;
                                            }

                                        }
                                        $news_comments[$key1]['replies'] = $comment_replies;
                                    } else {
                                        $news_comments[$key1]['replies'] = 0;
                                    }
                                }
                            }
                            else{
                                $news_comments = $q->get_panel_news_comments($news_id);
                                //print_r($news_comments); exit;
                                foreach ($news_comments as $key1 => $val1) {
                                    //echo $val1['comment_id'].' - <br>';
                                    $when = trim(real_comments_time($val1['time']));
                                    $news_comments[$key1]['when'] = trim($when);
                                    $news_comments[$key1]['comment'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($news_comments[$key1]['comment'])),
                                        ENT_QUOTES | ENT_HTML5);

                                    if ($log) {
                                        $is_reported_comment = $q->check_if_user_reported_panel_comment($email, $val1['comment_id']);
                                        $news_comments[$key1]['user_reported_comment'] = $is_reported_comment;
                                    }

                                    $comment_replies = $q->get_panel_comment_replies($val1['comment_id']);
                                    if (is_array($comment_replies)) {
                                        foreach ($comment_replies as $k => $v) {
                                            $comment_replies[$k]['when'] = trim(real_comments_time($v['time']));
                                            $comment_replies[$k]['reply'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($comment_replies[$k]['reply'])),
                                                ENT_QUOTES | ENT_HTML5);

                                            if ($log) {
                                                $is_reported_reply = $q->check_if_user_reported_reply($email, $v['reply_id'], $rank);
                                                $comment_replies[$k]['user_reported_reply'] = $is_reported_reply;
                                            }

                                        }
                                        $news_comments[$key1]['replies'] = $comment_replies;
                                    } else {
                                        $news_comments[$key1]['replies'] = 0;
                                    }
                                }
                            }

                            $data['comments'] = $news_comments;

                            $output['data'] = $data;
                        }
                        else {
                            $output['error'] = 1;
                            $output['message'] = 'News does not exist';
                        }

                    } else {
                        $output['error'] = 1;
                        $output['message'] = 'News id or rank not set';
                    }
                }
                break;

            case 'add_comment':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email']) || !isset($_POST['password'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                    } else {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $status = check_login($email, $password, $time, $lang);

                        $log = false;

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                        if ($log) {
                            if (!isset($_POST['news_id']) || !isset($_POST['comment']) || trim($_POST['comment']) == '') {
                                $output['error'] = 1;
                                $output['message'] = $translation['missing_data'];
                            } else {
                                $news_id = (int)$_POST['news_id'];
                                $rank = (int)$_POST['rank'];

                                require 'Queries.php';
                                $q = new Queries($lang, $domain, $root);

                                $data = $q->get_news_item($news_id, $rank);

                                //print_r($data); exit;
                                if (!is_array($data)) {
                                    $output['error'] = 1;
                                    $output['message'] = 'News does not exist';
                                    break;
                                }

                                $comment = filter_text($_POST['comment']);


                                $time = date("Y-m-d H:i:s");
                                $media = filter_text($_POST['media_url']);

                                $to_comment_id = 0;
                                if (isset($_POST['reply_to_comment']) && (int)$_POST['reply_to_comment'] > 0) {
                                    $to_comment_id = (int)$_POST['reply_to_comment'];
                                    $comment_exists = $q->check_if_comment_id_exists($to_comment_id, $rank);

                                    if ($comment_exists !== 1) {
                                        $output['error'] = 1;
                                        $output['message'] = 'Comment does not exist';
                                    } else {
                                        if ($q->insert_comment($email, $comment, $media, $time, $news_id, $to_comment_id, $rank)) {
                                            $output['error'] = 0;
                                            $output['message'] = $translation['comment_added'];
                                        } else {
                                            $output['error'] = 1;
                                            $output['message'] = $translation['error'];
                                        }
                                    }
                                } else {
                                    if ($q->insert_comment($email, $comment, $media, $time, $news_id, $to_comment_id, $rank)) {
                                        $output['error'] = 0;
                                        $output['message'] = $translation['comment_added'];
                                    } else {
                                        $output['error'] = 1;
                                        $output['message'] = $translation['error'];
                                    }
                                }

                            }
                        }
                    }
                }
                break;

            case 'report':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (isset($_POST['email']) && trim($_POST['email']) !== '' && isset($_POST['password']) && trim($_POST['password']) !== '') {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);

                        $status = check_login($email, $password, $time, $lang);

                        $log = false;

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                        if ($log) {
                            if (!isset($_POST['news_id']) || $_POST['news_id'] == '' || $_POST['news_id'] == 0 || !isset($_POST['reason']) || trim($_POST['reason']) == '') {
                                $output['error'] = 1;
                                $output['message'] = $translation['missing_data'];
                                break;
                            }

                            require 'Queries.php';
                            $q = new Queries($lang, $domain, $root);

                            $news_id = (int)$_POST['news_id'];
                            $rank = (int)$_POST['rank'];
                            $news_row = $q->get_news_item($news_id, $rank);
                            //print_r($news_row); exit;
                            if (!is_array($news_row)) {
                                $output['error'] = 1;
                                $output['message'] = 'News does not exist';
                            }
                            else {
                                if ((!isset($_POST['comment_id']) && !isset($_POST['reply_id'])) || ((int)$_POST['comment_id'] == 0 && (int)$_POST['reply_id'] == 0)) {
                                    $output['error'] = 1;
                                    $output['message'] = 'Missing comment or reply id';
                                }
                                else {
                                    $type = filter_text($_POST['reason']);
                                    $time = date("Y-m-d H:i:s");
                                    if (isset($_POST['other']))
                                        $other = filter_text($_POST['other']);

                                    if ((int)$_POST['comment_id'] > 0) {
                                        $comment_id = (int)$_POST['comment_id'];
                                        $reply_id = NULL;
                                        $comment_row = $q->get_comment_row((int)$_POST['comment_id'], $rank);
                                        $comment_owner = $comment_row['email_user'];

                                        $reported_before = $q->check_if_user_reported_comment($email, $comment_id, $rank);
                                        if ($reported_before > 0) {
                                            $output['error'] = 1;
                                            $output['message'] = $translation['already_reported'];
                                        }
                                        elseif ($reported_before == 'error') {
                                            $output['error'] = 0;
                                            $output['message'] = $translation['error'];
                                        }

                                        if ($reported_before == 0) {
                                            $send = $q->add_report($news_id, $time, $email, $comment_row['email_user'], $type, $other, $comment_id, $reply_id, $rank);
                                            if ($send == true) {
                                                $output['error'] = 0;
                                                $output['message'] = $translation['sent_successfully'];
                                            } else {
                                                $output['error'] = 1;
                                                $output['message'] = $translation['error'];
                                            }
                                        }
                                    }
                                    elseif ((int)$_POST['reply_id'] > 0) {
                                        $reply_id = (int)$_POST['reply_id'];
                                        $comment_id = NULL;
                                        $reply_row = $q->get_reply_row((int)$_POST['reply_id'], $rank);
                                        $reply_owner = $reply_row['email_user'];

                                        $reported_before = $q->check_if_user_reported_reply($email, $reply_id, $rank);
                                        //echo $reported_before; exit;
                                        if ((int)$reported_before > 0) {
                                            $output['error'] = 1;
                                            $output['message'] = $translation['already_reported'];
                                        } elseif ($reported_before == 0) {
                                            //echo $reply_id; exit;
                                            $send = $q->add_report($news_id, $time, $email, $reply_owner, $type, $other, $comment_id, $reply_id, $rank);

                                            if ($send == true) {
                                                $output['error'] = 0;
                                                $output['message'] = $translation['sent_successfully'];
                                            } else {
                                                $output['error'] = 1;
                                                $output['message'] = $translation['error'];
                                            }
                                        } else {
                                            $output['error'] = 1;
                                            $output['message'] = $translation['error'];
                                        }

                                    }
                                }
                            }
                        }
                    }
                }
                break;

            case 'hot_news':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    $log = false;
                    $email = '';

                    if (isset($_POST['email']) && trim($_POST['email']) !== '' && isset($_POST['password']) && trim($_POST['password']) !== '') {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);

                        $status = check_login($email, $password, $time, $lang);

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                    }

                    require 'Queries.php';
                    $q = new Queries($lang, $domain, $root);

                    $perPage = (int)$_POST['limit'];

                    $news = $q->hot_news($email, 0, $perPage);

                    //print_r($news); exit;

                    $hot_news = array();
                    foreach ($news as $key => $item) {
                        $single_item = array();
                        $single_item['id'] = $item['id'];
                        $single_item['title'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($item['title'])),ENT_QUOTES | ENT_HTML5);
                        $source = $item['type'];
                        if($lang == 'ar'){
                            $single_item['source'] = $utilisateur->source($item['type']);
                        }
                        else{
                            $single_item['source'] = $item['type'];
                        }

                        $single_item['source_logo'] = $root.'v2/sources/'.$source.'.png';
                        $single_item['image'] = $item['media'];
                        $single_item['pubDate'] = $item['pubDate'];
                        $single_item['when'] = trim(real_comments_time($item['pubDate']));
                        $single_item['description'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($item['description'])),ENT_QUOTES | ENT_HTML5);

                        $hot_news[] = $single_item;
                        unset($single_item);
                    }

                    $output['error'] = 0;
                    $output['news'] = $hot_news;

                }
                break;

            case 'get_information':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {
                    require 'Queries.php';
                    $q = new Queries($lang, $domain, $root);
                    $info = $q->get_information();
                    $information['about_us'] = remove_extra_lines($info['aboutus']);
                    $information['chatsrun'] = remove_extra_lines($info['chatsrun']);
                    $information['whatsapp'] = remove_extra_lines($info['whatsapp']);
                    $information['email'] = remove_extra_lines($info['email']);
                    $information['twitter'] = remove_extra_lines($info['twitter']);
                    $information['facebook'] = remove_extra_lines($info['facebook']);
                    $information['youtube'] = remove_extra_lines($info['youtube']);
                    $information['fyi_likes'] = remove_extra_lines($info['fyi_likes']);
                    $output['error'] = 0;
                    $output['information'] = $information;
                }

                break;

            case 'search':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['search_for']) || trim($_POST['search_for']) == '') {
                        $output['error'] = 1;
                        $output['message'] = $translation['no_search_val'];
                    } else {
                        require 'Queries.php';
                        $q = new Queries($lang, $domain, $root);

                        $log = false;
                        $email = '';

                        if (isset($_POST['email']) && trim($_POST['email']) !== '' && isset($_POST['password']) && trim($_POST['password']) !== '') {
                            $email = filter_text($_POST['email']);
                            $password = filter_text($_POST['password']);

                            $status = check_login($email, $password, $time, $lang);

                            switch ($status) {
                                case '0':
                                    $output['error'] = 1;
                                    $output['message'] = $translation['incorrect_email'];
                                    break;

                                case '1':
                                    $log = true;
                                    break;

                                case '2':
                                    $output['error'] = 1;
                                    $output['message'] = $translation['activate_email'];
                                    break;

                                case '3':
                                    $output['error'] = 1;
                                    $output['message'] = $translation['auth_error'];
                                    break;
                            }

                        }

                    }

                    $perPage = (int)$_POST['limit'];
                    $search_for = filter_text($_POST['search_for']);
                    //echo $email.' - '.$search_for; exit;
                    $totalNews = $q->count_search($email, $search_for);

                    $pagenum = 1;
                    if (isset($page)) {
                        $pagenum = $page;
                    }

                    $allPages = ceil($totalNews / $perPage);

                    $offset = ($pagenum - 1) * $perPage;

                    $result = $q->search($email, $search_for, $offset, $perPage);

                    $all_results = array();
                    foreach ($result as $key => $val) {
                        $item = array();
                        $item['news_id'] = $val['id'];
                        $item['title'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($val['title'])),ENT_QUOTES | ENT_HTML5);
                        $item['description'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($val['description'])),ENT_QUOTES | ENT_HTML5);
                        $item['type'] = $val['type'];
                        $source = $val['Source'];
                        if($lang == 'ar'){
                            $item['source'] = $utilisateur->source($source);
                        }
                        else{
                            $item['source'] = $source;
                        }

                        $item['source_logo'] = $root.'v2/sources/'.$source.'.png';
                        $item['link'] = $val['link'];
                        $item['pubDate'] = $val['pubDate'];
                        $item['when'] = trim(real_comments_time($val['pubDate']));
                        $all_results[] = $item;
                        unset($item);
                    }
                    $output['error'] = 0;
                    $output['all_pages'] = $allPages;
                    $output['result'] = $all_results;
                }
                break;

            case 'add_right_of_reply':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email']) || !isset($_POST['password'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                    } else {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $status = check_login($email, $password, $time, $lang);

                        $log = false;

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                        if ($log) {
                            if (!isset($_POST['news_id']) || !isset($_POST['reply']) || trim($_POST['reply']) == '' || !isset($_POST['reply_title']) || trim($_POST['reply_title']) == '' || !isset($_POST['reply_to_link'])) {
                                $output['error'] = 1;
                                $output['message'] = $translation['missing_data'];
                            } else {
                                $news_id = (int)$_POST['news_id'];
                                //$reply = $_POST['reply'];
                                $json = $_POST['reply'];
                                $json = str_replace('{"b":true}', '{"bold":true}',$json);
                                $json = str_replace('{"i":true}', '{"italic":true}',$json);
                                $json = str_replace('{"heading"', '{"header"',$json);

                                $json_output = json_decode($json);

                                $ops = array();
                                $ops['ops'] = $json_output;

                                $reply = json_encode($ops);

                                $lexer = new Lexer($reply);
                                $reply = htmlspecialchars($lexer->render(), ENT_QUOTES);

                                $reply_title = filter_text($_POST['reply_title']);
                                $video = filter_text($_POST['video']);
                                $reply_to_link = filter_text($_POST['reply_to_link']);

                                $rank = (int)$_POST['rank'];

                                if (isset($_POST['user_image'])) {
                                    $user_image = filter_text($_POST['user_image']);
                                }
                                if (isset($_POST['reply_image'])) {
                                    $reply_image = filter_text($_POST['reply_image']);
                                }
                                if (isset($_POST['message'])) {
                                    $message = filter_text($_POST['message']);
                                }
                                if (isset($_POST['phone'])) {
                                    $phone = filter_text($_POST['phone']);
                                }

                                $time = date("Y-m-d H:i:s");

                                require 'Queries.php';
                                $q = new Queries($lang, $domain, $root);

                                if($rank == 2){
                                    $tbl = 'rss';
                                }
                                else{
                                    $tbl = 'news';
                                }

                                $add = $q->add_right_of_reply($news_id, $email, $reply_title, $user_image, $reply_image, $time, $phone, $message, $reply, $reply_to_link, $tbl, $video);

                                if ($add) {
                                    $output['error'] = 0;
                                    $output['message'] = $translation['right_of_reply_added'];
                                } else {
                                    $output['error'] = 1;
                                    $output['message'] = $translation['error'];
                                }

                            }
                        }
                    }
                }

                break;

            case 'slideshow':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                }
                else {

                    $log = false;

                    if (isset($_POST['email']) && trim($_POST['email']) !== '' && isset($_POST['password']) && trim($_POST['password']) !== '') {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);

                        $status = check_login($email, $password, $time, $lang);

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                    }

                    include '../fyipanel/views/connect.php';
                    $s = $con->prepare("select app_slideshow_interval from right_of_reply_settings where id = '2'");
                    $s->execute();
                    $r = $s->fetch(PDO::FETCH_ASSOC);
                    $milliseconds = $r['app_slideshow_interval'] * 1000;

                    require 'Queries.php';
                    $q = new Queries($lang, $domain, $root);

                    $limit = (int) $_POST['limit'];
                    if (!$log) {
                        $email = '';
                    }

                    $news = $q->slideshow($email, $limit);
                    $slideshow = array();
                    foreach($news as $key=>$val){
                        $item = array();
                        $item['id'] = $val['id'];
                        $item['title'] = $val['title'];
                        $item['description'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($val['description'])),ENT_QUOTES | ENT_HTML5);
                        if ($lang !== 'en'){
                            $item['type'] = $val['type'];
                            $item['ar_type'] = $utilisateur->type($val['type'], $lang);
                        }
                        else{
                            $item['type'] = $val['type'];
                            $item['ar_type'] = '';
                        }
                        $item['source'] = $val['Source'];
                        $item['image'] = $val['media'];
                        $item['link'] = $val['link'];
                        $item['pubDate'] = $val['pubDate'];
                        $item['when'] = trim(real_comments_time($val['pubDate']));
                        $item['comments_count'] = $q->total_comments($val['id']);
                        $slideshow[] = $item;
                        unset($item);
                    }

                    $output['error'] = 0;
                    $output['duration'] = $milliseconds;
                    $output['slideshow'] = $slideshow;
                }

                break;

            case 'country_news':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                }
                else {

                    if(!isset($_POST['country']) || trim($_POST['country']) == ''){
                        $output['error'] = 1;
                        $output['message'] = $translation['choose_country'];
                    }
                    else{
                        $log = false;
                        $country = filter_text($_POST['country']);

                        if (isset($_POST['email']) && trim($_POST['email']) !== '' && isset($_POST['password']) && trim($_POST['password']) !== '') {
                            $email = filter_text($_POST['email']);
                            $password = filter_text($_POST['password']);

                            $status = check_login($email, $password, $time, $lang);

                            switch ($status) {
                                case '0':
                                    $output['error'] = 1;
                                    $output['message'] = $translation['incorrect_email'];
                                    break;

                                case '1':
                                    $log = true;
                                    break;

                                case '2':
                                    $output['error'] = 1;
                                    $output['message'] = $translation['activate_email'];
                                    break;

                                case '3':
                                    $output['error'] = 1;
                                    $output['message'] = $translation['auth_error'];
                                    break;
                            }

                        }

                        require 'Queries.php';
                        $q = new Queries($lang, $domain, $root);

                        $countries = $q->get_countries();
                        $all_countries = array();
                        foreach ($countries as $key => $val) {
                            $all_countries[] = $val['country_name'];
                        }

                        if(!in_array($country, $all_countries)){
                            $output['error'] = 1;
                            $output['message'] = $translation['choose_correct_country'];
                        }
                        else{

                            if (!$log) {
                                $email = '';
                            }

                            $perPage = (int)$_POST['limit'];
                            $country = filter_text($_POST['country']);

                            $pagenum = (int) $_POST['page'];
                            if (isset($page)) {
                                $pagenum = $page;
                            }

                            $src = 'News';

                            $totalNews = $q->nbrNewsBySourceAndCountry($email, $country, $src);

                            $allPages = ceil($totalNews / $perPage);

                            $offset = ($pagenum - 1) * $perPage;

                            $news = $q->getspecialfeedsBySourceAndCountry($email, $country, $src, $offset, $perPage);

                            $all_news = array();
                            foreach ($news as $key=>$val){
                                $item = array();
                                $item['news_id'] = $val['id'];
                                $item['title'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($val['title'])),ENT_QUOTES | ENT_HTML5);
                                $item['description'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($val['description'])),ENT_QUOTES | ENT_HTML5);
                                $source = $val['Source'];
                                if($lang == 'ar'){
                                    $item['source'] = $utilisateur->source($val['Source']);
                                }
                                else{
                                    $item['source'] = $val['Source'];
                                }

                                $item['image'] = $val['media'];
                                $item['link'] = $val['link'];
                                $item['pubDate'] = $val['pubDate'];
                                $item['when'] = trim(real_comments_time($val['pubDate']));
                                $news_comments_count = $q->count_news_comments($val['id']);
                                $count = $news_comments_count['total_comments'] + $news_comments_count['total_replies'];
                                $item['comments_count'] = $count;
                                $item['source_logo'] = $root.'v2/sources/'.$val['Source'].'.png';

                                $all_news[] = $item;
                                unset($item);
                            }

                            $output['error'] = 0;
                            $output['all_pages'] = $allPages;
                            $output['news'] = $all_news;

                        }

                    }

                }
                break;

            case 'category_right_of_reply':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                }
                else {

                    if (!isset($_POST['category']) || trim($_POST['category']) == '') {
                        $output['error'] = 1;
                        $output['message'] = $translation['choose_category'];
                    } else {
                        $page =(int) $_POST['page'];
                        $perPage =(int) $_POST['limit'];
                        $category = filter_text($_POST['category']);

                        require 'Queries.php';
                        $q = new Queries($lang, $domain, $root);
                        $s = $q->count_category_replies($category);
                        $totalNews = $s['total'];
                        $allPages = ceil($totalNews / $perPage);
                        $offset = ($page - 1) * $perPage;
                        $news = $q->getCategoryReplies($category,$offset,$perPage);
                        //print_r($news);
                        $all_news =array();
                        foreach ($news as $k=>$val){
                            $item = array();
                            $item['id'] = $val['id'];
                            $item['title'] = htmlspecialchars_decode($val['title']);
                            $item['description'] = strip_tags(htmlspecialchars_decode($val['description']));
                            $item['content'] = html_entity_decode(remove_extra_lines(strip_tags(htmlspecialchars_decode($val['content']))),ENT_QUOTES | ENT_HTML5);
                            $item['pubDate'] = $val['pubDate'];
                            $item['when'] = trim(real_comments_time($val['pubDate']));
                            $item['image'] = $domain.'fyipanel/views/image_news/'.$val['media'];

                            $news_comments_count = $q->count_panel_news_comments($item['id']);
                            $count = $news_comments_count['total_comments'] + $news_comments_count['total_replies'];

                            $item['comments_count'] = $count;

                            $all_news[] = $item;
                            unset($item);
                        }

                        $output['error'] = 0;
                        $output['news'] = $all_news;
                    }
                }
                break;

            case 'breaking_news':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    $log = false;
                    $email = '';

                    if (isset($_POST['email']) && trim($_POST['email']) !== '' && isset($_POST['password']) && trim($_POST['password']) !== '') {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);

                        $status = check_login($email, $password, $time, $lang);

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                    }

                    require 'Queries.php';
                    $q = new Queries($lang, $domain, $root);

                    $page = (int)$_POST['page'];
                    $perPage = (int)$_POST['limit'];

                    $pagenum = (int) $_POST['page'];
                    if (isset($page)) {
                        $pagenum = $page;
                    }

                    $totalNews = $q->nbrBreakingNews($email);

                    $allPages = ceil($totalNews / $perPage);

                    $offset = ($pagenum - 1) * $perPage;

                    $news = $q->getspecialfeedsBreakingNews($email, $offset,$perPage);

                    $total_news = array();
                    $media = $domain.'fyipanel/views/image_news/breaking_news.jpeg';
                    foreach ($news as $key => $val){
                        $item = array();
                        $item['id'] = $val['id'];
                        $item['title'] = html_entity_decode(htmlspecialchars_decode(remove_extra_lines($val['title'])),ENT_QUOTES | ENT_HTML5);
                        $item['description'] = '';
                        if($val['media'] == ''){
                            $item['image'] = $media;
                        }
                        else{
                            $item['image'] = $val['media'];
                        }
                        $item['link'] = $val['link'];
                        $item['rank'] = 2;
                        $source = $val['Source'];
                        if($lang == 'ar'){
                            $item['source'] = $utilisateur->source($val['Source']);
                        }
                        else{
                            $item['source'] = $val['Source'];
                        }

                        $item['source_logo'] = $root.'v2/sources/'.$val['Source'].'.png';
                        $item['pubDate'] = $val['pubDate'];
                        $item['when'] = trim(real_comments_time($val['pubDate']));
                        $news_comments_count = $q->count_news_comments($val['id']);
                        $count = $news_comments_count['total_comments'] + $news_comments_count['total_replies'];
                        $item['comments_count'] = $count;
                        $all_news[] = $item;
                        unset($item);
                    }

                    $output['error'] = 0;
                    $output['all_pages'] = $allPages;
                    $output['news'] = $all_news;
                }
                break;

            case 'change_profile_pic':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email']) || !isset($_POST['password'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                    } else {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $status = check_login($email, $password, $time, $lang);

                        $log = false;

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                        if ($log) {
                            if (!isset($_POST['url']) || trim($_POST['url']) == '' ) {
                                $output['error'] = 1;
                                $output['message'] = $translation['missing_data'];
                            } else {
                                $pic_url = filter_text($_POST['url']);

                                $utilisateur->update_user_photo($pic_url, $email);
                                $output['error'] = 0;
                                $output['message'] = $translation['updated_successfully'];
                            }
                        }
                    }
                }
                break;

            case 'update_notification_sources':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                } else {

                    if (!isset($_POST['email']) || !isset($_POST['password'])) {
                        $output['error'] = 1;
                        $output['message'] = $translation['missing_data'];
                    } else {
                        $email = filter_text($_POST['email']);
                        $password = filter_text($_POST['password']);
                        $status = check_login($email, $password, $time, $lang);

                        $log = false;

                        switch ($status) {
                            case '0':
                                $output['error'] = 1;
                                $output['message'] = $translation['incorrect_email'];
                                break;

                            case '1':
                                $log = true;
                                break;

                            case '2':
                                $output['error'] = 1;
                                $output['message'] = $translation['activate_email'];
                                break;

                            case '3':
                                $output['error'] = 1;
                                $output['message'] = $translation['auth_error'];
                                break;
                        }

                        if ($log) {
                            if (!isset($_POST['country']) || trim($_POST['country']) == '') {
                                $output['error'] = 1;
                                $output['message'] = $translation['missing_data'];
                            }
                            else{

                                require_once 'Queries.php';
                                $q = new Queries($lang, $domain, $root);

                                require '../fcm/WebFCMToTopic.php';
                                $fcm = new WebFCMToTopic();

                                require_once 'models/v4.utilisateurs.model.php';
                                $v4Util = new v4Utilisteurs($lang);

                                $user_row = $q->get_user_row($email);
                                $user_id = $user_row['user_id'];

                                $country = filter_text($_POST['country']);
                                $sources = filter_text($_POST['sources']);

                                if($sources == ''){
                                    $v4Util->delete_user_notif_all_country_sources($country, $user_id);
                                    $country_sources = $q->get_country_sources($country);
                                    $sources = array();
                                    foreach ($country_sources as $source){
                                        $sources[] = $source['source_name'];
                                    }
                                    $unique_sources = array_unique($sources);
                                    foreach ($unique_sources as $src){
                                        $topic = $lang.'-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$src);
                                        $fcm->unsubscribe($user_row['token'], $topic);
                                    }

                                }
                                elseif(stristr($sources,',')){

                                    $all_user_sources = $v4Util->get_all_user_notif_country_sources($user_row['user_id'], $country);
                                    foreach ($all_user_sources as $source){
                                        $topic = $lang.'-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$source);
                                        $fcm->unsubscribe($token, $topic);
                                    }

                                    $sources = explode(',', $sources);
                                    $v4Util->delete_user_notif_all_country_sources($country, $user_id);
                                    foreach ($sources as $src){
                                        $v4Util->add_user_notif_source($country, $src, $user_id);
                                        $fcm->subscribe($token, $topic);
                                    }
                                }
                                elseif(!stristr(',', $sources) && strlen($sources) > 0){
                                    $all_user_sources = $v4Util->get_all_user_notif_country_sources($user_row['user_id'], $country);
                                    foreach ($all_user_sources as $source){
                                        $topic = $lang.'-'.str_replace(' ','__',$country).'-'.str_replace(' ','__',$source);
                                        $fcm->unsubscribe($token, $topic);
                                    }
                                    $v4Util->delete_user_notif_all_country_sources($country, $user_id);
                                    $v4Util->add_user_notif_source($country, $sources, $user_id);

                                }

                                $output['error'] = 0;
                                $output['message'] = $translation['updated_successfully'];
                            }
                        }
                    }
                }
                break;

            case 'fyi_categories':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                }
                else {
                    $categories = array();
                    $item = array();
                    $item['News'] = $translation['News'];
                    $categories[] = (object)$item;
                    unset($item);
                    $item = array();
                    $item['Arts'] = $translation['Arts'];
                    $categories[] = (object)$item;
                    unset($item);
                    $item = array();
                    $item['Sports'] = $translation['Sports'];
                    $categories[] = (object)$item;
                    unset($item);
                    $item = array();
                    $item['Technology'] = $translation['Technology'];
                    $categories[] = (object)$item;
                    unset($item);
                    $item = array();
                    $item['General Culture'] = $translation['General Culture'];
                    $categories[] = (object)$item;
                    unset($item);
                    $output['error'] = 0;
                    $output['categories'] = $categories;
                }
                break;

            case 'fyi_news':
                if(!isset($_POST['time']) || !isset($_POST['enc'])){
                    $output['error'] = 1;
                    $output['message'] = 'Missing security parameters';
                }
                else {
                    $time = filter_text($_POST['time']);
                    $enc = filter_text($_POST['enc']);
                    $valid = validate_encryption($time, $enc);
                }
                if (!$valid) {
                    $output['error'] = 1;
                    $output['message'] = 'Security error';
                }
                else {
                    if(!isset($_POST['category'])){
                        $output['error'] = 1;
                        $output['message'] = 'Category is missing';
                    }
                    else{
                        require 'Queries.php';
                        $q = new Queries($lang, $domain, $root);

                        $category = filter_text($_POST['category']);
                        $perPage = (int)$_POST['limit'];
                        $totalNewsRow = $q->count_fyi_news($category);
                        $totalNews = $totalNewsRow['total'];

                        $pagenum = 1;
                        if (isset($page)) {
                            $pagenum = $page;
                        }
                        $allPages = ceil($totalNews / $perPage);
                        $offset = ($pagenum - 1) * $perPage;

                        $news = $q->get_fyi_news($category, $offset, $perPage);
                        //print_r($news); exit;
                        $all_news = array();
                        foreach ($news as $key=>$val){
                            $item = array();

                            $video = '';
                            if($val['right_of_reply_id'] > 0){
                                $right_of_reply = $q->get_right_of_reply($val['right_of_reply_id']);
                                $video = $right_of_reply['video'];
                            }

                            $item['id'] = $val['id'];
                            $item['rank'] = 1;
                            $item['type'] = $val['type'];
                            $item['pubDate'] = $val['pubDate'];
                            $item['video'] = $video;
                            $item['when'] = trim(real_comments_time($val['pubDate']));
                            $item['title'] = htmlspecialchars_decode($val['title']);
                            if(strlen(trim(htmlspecialchars_decode($val['description']))) == 0){
                                $item['description'] = get_des($lang, remove_extra_lines(strip_tags(htmlspecialchars_decode($val['content']))));
                            }
                            else{
                                $item['description'] = htmlspecialchars_decode($val['description']);
                            }

                            $item['source'] = $translation['fyipress'] ;

                            $item['media'] = $domain.'fyipanel/views/image_news/'.$val['media'];
                            $item['content'] = remove_extra_lines(strip_tags(htmlspecialchars_decode($val['content'])));
                            $all_news[] = $item;
                            unset($item);
                        }
                        $output['error'] = 0;
                        $output['total_pages'] = $allPages;
                        $output['news'] = $all_news;
                    }
                }
                break;
        }
    }

}

else{
    $output['error'] = 1;
    $output['message'] = 'Get request is not allowed';
}
echo json_encode($output);

//////////////////////////////////////////////////////////////////////////////////

function remove_extra_lines($string){
    $string = str_replace("\n", " ", $string);
    $string = str_replace("\r", " ", $string);
    return trim($string);
}

function number_format_unchanged_precision($number, $dec_point = '.', $thousands_sep = ',')
{
    if ($dec_point == $thousands_sep) {
        trigger_error('2 parameters for ' . __METHOD__ . '() have the same value, that is "' . $dec_point . '" for $dec_point and $thousands_sep', E_USER_WARNING);
        // It corresponds "PHP Warning:  Wrong parameter count for number_format()", which occurs when you use $dec_point without $thousands_sep to number_format().
    }
    if (preg_match('{\.\d+}', $number, $matches) === 1) {
        $decimals = strlen($matches[0]) - 1;
    } else {
        $decimals = 0;
    }
    return number_format($number, $decimals, $dec_point, $thousands_sep);
}

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
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

function get_des($lang, $text){
    if($lang == 'ar'){
        $arr = explode(' ',$text);
        if(count($arr) > 10){
            $des = array();
            for($x=0; $x<10; $x++){
                $des[] = $arr[$x];
            }
            $final = implode(' ',$des);
            return $final;
        }
        else{
            return $text;
        }
    }
    else{
        $line=htmlspecialchars_decode($text);
        if (preg_match('/^.{1,100}\b/s', htmlspecialchars_decode($text), $match))
        {
            $line=$match[0];
            $ar_c = strip_tags($line);
            return $ar_c;
        }
    }

}

