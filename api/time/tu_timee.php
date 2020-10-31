<?php
function comments_time($d)
{
    $c = '';
    date_default_timezone_set('GMT');
    $time2 = date("Y-m-d H:i:s");
    $time1 = $d;
    $nb = round((strtotime($time2) - strtotime($time1)), 1);
    $nbseconds = floor($nb);
    if ($nbseconds >= 0) {
        if ($nbseconds <= 59) {
            //seconds
            if ($nbseconds == 0) $n = 1;
            else $n = $nbseconds;
            if ($n <= 1) $c = $n . " saniye önce ";
            else $c = $n . " saniye önce ";
        } else if (round(($nbseconds / 60)) < 60) {
            //dakika
            $n = round(($nbseconds / 60), 1);
            if ($n <= 1) $c = ceil($n) . " dakika önce";
            else if ($n < 2) $c = floor($n) . " dakika önce";
            else $c = floor($n) . " dakika önce";
        } else if (round(($nbseconds / 3660), 1) < 24) {
            //Saat
            $n = round(($nbseconds / 3660), 1);
            if ($n <= 1) $c = ceil($n) . " Saat önce";
            else if ($n < 2) $c = floor($n) . " Saat önce";
            else $c = floor($n) . " Saat önce";
        } else if (round(($nbseconds / 86400), 1) <= 10) {
            //Günler
            $n = round(($nbseconds / 86400), 1);
            if ($n <= 1) $c = ceil($n) . " Gün önce";
            else if ($n < 2) $c = floor($n) . " Gün önce";
            else $c = floor($n) . " Gün önce";

        } else {
            //Yıllar
            $c = "date";
        }
    } else {
        $c = 'Err';
    }

    return $c;
}


function news_time($d)
{
    $c = '';
    date_default_timezone_set('GMT');
    $time2 = date("Y-m-d H:i:s");
    $time1 = $d;
    $nb = round((strtotime($time2) - strtotime($time1)), 1);
    $nbseconds = floor($nb);
    if ($nbseconds >= 0) {
        if ($nbseconds <= 59) {
            //saniye
            if ($nbseconds == 0) $n = 1;
            else $n = $nbseconds;
            if ($n <= 1) $c = $n . " saniye önce ";
            else $c = $n . " saniye önce";
        } else if (round(($nbseconds / 60)) < 60) {
            //dakika
            $n = round(($nbseconds / 60), 1);
            if ($n <= 1) $c = ceil($n) . " dakika önce ";
            else if ($n < 2) $c = floor($n) . " dakika önce ";
            else $c = floor($n) . " dakika önce ";
        } else if (round(($nbseconds / 3660), 1) < 24) {
            //Saat
            $n = round(($nbseconds / 3660), 1);
            if ($n <= 1) $c = ceil($n) . " Saat önce";
            else if ($n < 2) $c = floor($n) . " Saat önce ";
            else $c = floor($n) . " Saat önce ";
        } else if (round(($nbseconds / 86400), 1) <= 10) {
            //Günler
            $n = round(($nbseconds / 86400), 1);
            if ($n <= 1) $c = ceil($n) . " Gün önce ";
            else if ($n < 2) $c = floor($n) . " Gün önce ";
            else $c = floor($n) . " Gün önce ";

        } else {
            //Yıllar
            $c = "date";
        }
    } else {
        $c = 'Err';
    }

    return $c;
}


function real_news_time($d)
{
    $cc = news_time($d);
    if ($cc == "date" || $cc == "Err") {
        return $d . " GMT";
    } else {
        return $cc;
    }
}

function real_comments_time($d)
{
    $cc = comments_time($d);
    if ($cc == "Err") {
        return $d . " GMT";
    } else {
        return $cc;
    }
}

function current_lang()
{
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    if (isset($_COOKIE['current_language'])) {
        if ($actual_link != $_COOKIE['current_language']) {
            setcookie('current_language', $actual_link, time() + 31104000, "/");
        }
    } else {
        setcookie('current_language', $actual_link, time() + 31104000, "/");
    }
}


?>