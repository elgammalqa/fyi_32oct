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
            if ($n <= 1) $c = $n . " سیکنڈ  سے پہلے    ";
            else $c = $n . " سیکنڈ  سے پہلے   ";
        } else if (round(($nbseconds / 60)) < 60) {
            //minutes
            $n = round(($nbseconds / 60), 1);
            if ($n <= 1) $c = ceil($n) . " منٹ سے پہلے    ";
            else if ($n < 2) $c = floor($n) . " منٹ سے پہلے   ";
            else $c = floor($n) . " منٹ سے پہلے    ";
        } else if (round(($nbseconds / 3660), 1) < 24) {
            //hours
            $n = round(($nbseconds / 3660), 1);
            if ($n <= 1) $c = ceil($n) . " گھنٹہ سے پہلے   ";
            else if ($n < 2) $c = floor($n) . " گھنٹہ سے پہلے   ";
            else $c = floor($n) . " گھنٹے سے پہلے   ";
        } else if (round(($nbseconds / 86400), 1) < 7) {
            //days
            $n = round(($nbseconds / 86400), 1);
            if ($n <= 1) $c = ceil($n) . " دن سے پہلے   ";
            else if ($n < 2) $c = floor($n) . " دن سے پہلے   ";
            else $c = floor($n) . " دن سے پہلے";

        } else {
            $c = 'date';
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
            //seconds
            if ($nbseconds == 0) $n = 1;
            else $n = $nbseconds;
            if ($n <= 1) $c = $n . " سیکنڈ  سے پہلے    ";
            else $c = $n . " سیکنڈ  سے پہلے   ";
        } else if (round(($nbseconds / 60)) < 60) {
            //minutes
            $n = round(($nbseconds / 60), 1);
            if ($n <= 1) $c = ceil($n) . " منٹ سے پہلے    ";
            else if ($n < 2) $c = floor($n) . " منٹ سے پہلے   ";
            else $c = floor($n) . " منٹ سے پہلے    ";
        } else if (round(($nbseconds / 3660), 1) < 24) {
            //hours
            $n = round(($nbseconds / 3660), 1);
            if ($n <= 1) $c = ceil($n) . " گھنٹہ سے پہلے   ";
            else if ($n < 2) $c = floor($n) . " گھنٹہ سے پہلے   ";
            else $c = floor($n) . " گھنٹے سے پہلے   ";
        } else if (round(($nbseconds / 86400), 1) < 7) {
            //days
            $n = round(($nbseconds / 86400), 1);
            if ($n <= 1) $c = ceil($n) . " دن سے پہلے   ";
            else if ($n < 2) $c = floor($n) . " دن سے پہلے   ";
            else $c = floor($n) . " دن سے پہلے";

        } else {
            $c = 'date';
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
        return $d;
    } else {
        $western_arabic = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $eastern_arabic = array('٠', '١', '٢', '٣', '۴', '۵', '۶', '٧', '٨', '٩');

        $str = str_replace($western_arabic, $eastern_arabic, $cc);
        return $str;
    }
}

function real_comments_time($d)
{
    $cc = comments_time($d);
    if ($cc == "Err") {
        return $d;
    } else {
        $western_arabic = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $eastern_arabic = array('٠', '١', '٢', '٣', '۴', '۵', '۶', '٧', '٨', '٩');

        $str = str_replace($western_arabic, $eastern_arabic, $cc);
        return $str;
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