<?php


function validate_encryption($time, $enc){
    global $key;
    $seconds = $time / 1000;
    $date_array = explode(".",$seconds);
    $time_in_seconds = $date_array[0];
    $diff = time() - $time_in_seconds;
    //TODO DECREASE DIFFERENCE
    if($diff > 99999999999){
        return false;
    }
    else{
        $main_key = decrypt($enc, $time);
        if($main_key !== $key){
            return false;
        }
        else{
            return true;
        }
    }

}

function encrypt($plaintext = "fyipress2020", $time){
    $cipher ="AES-256-ECB";
    $key = '12345678912345678912345678912345';
    //$time = milliseconds();
    echo $time.'<br>';
    $plaintext .= $time;
    $chiperRaw = openssl_encrypt($plaintext, $cipher, $key, OPENSSL_RAW_DATA);
    $ciphertext = trim(base64_encode($chiperRaw));
    echo $ciphertext;
}

function decrypt($enc, $time){
    $cipher ="AES-256-ECB";
    $key = '12345678912345678912345678912345';
    $chiperRaw = base64_decode($enc);
    $originalPlaintext = openssl_decrypt($chiperRaw, $cipher, $key, OPENSSL_RAW_DATA);
    $main_key = substr($originalPlaintext,0, -strlen($time));
    return $main_key;
}

function filter_text($x){
    $a = trim($x);
    //$a = htmlspecialchars(strip_tags($a), ENT_QUOTES);
    $a = strip_tags($a);
    $a = str_ireplace('include','inc_lude',$a);
    $a = str_ireplace('require','req_uire',$a);
    $a = str_ireplace('cmd=','_',$a);
    $a = str_ireplace('--','_',$a);
    $a = str_ireplace('union','_',$a);
    $a = str_ireplace('.php','_php',$a);
    $a = str_ireplace('.js','_js',$a);
    $a = str_ireplace('truncate', 'tru__ate', $a);
    $a = str_ireplace('empty', 'em__y', $a);
    $a = str_ireplace('alter', 'alt_', $a);
    $a = str_ireplace('drop', 'dr__', $a);
    return $a;
}

function milliseconds() {
    $mt = explode(' ', microtime());
    return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
}

function check_login($email, $password, $time, $lang){
    $logg=$email;
    /*require_once('models/Ar_utilisateurs.model.php');

    $utilisateur = new ar_utilisateursModel($lang);*/

    $password = decrypt($password, $time);

    global $utilisateur;

    if($utilisateur->Function_userexist2($logg)!=null){
        if (password_verify($password,$utilisateur->getpassword())) {
            if ($utilisateur->acount_is_confirmed($email)) {
                return 1; //login successful
            }
            else{
                return 2; //account not activated
            }

        }
        else{
            return 3; //login error
        }
    }
    else{
        return 0;
        //user does not exist
    }
}