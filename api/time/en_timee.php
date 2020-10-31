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
            if ($n <= 1) $c = "Before " . $n . " second ";
            else $c = "Before " . $n . " seconds ";
        } else if (round(($nbseconds / 60)) < 60) {
            //minutes
            $n = round(($nbseconds / 60), 1);
            if ($n <= 1) $c = "Before " . ceil($n) . " minute ";
            else if ($n < 2) $c = "Before " . floor($n) . " minute ";
            else $c = "Before " . floor($n) . " minutes ";
        } else if (round(($nbseconds / 3660), 1) < 24) {
            //hours
            $n = round(($nbseconds / 3660), 1);
            if ($n <= 1) $c = "Before " . ceil($n) . " hour ";
            else if ($n < 2) $c = "Before " . floor($n) . " hour ";
            else $c = "Before " . floor($n) . " hours ";
        } else if (round(($nbseconds / 86400), 1) < 7) {
            //days
            $n = round(($nbseconds / 86400), 1);
            if ($n <= 1) $c = "Before " . ceil($n) . " day ";
            else if ($n < 2) $c = "Before " . floor($n) . " day ";
            else $c = "Before " . floor($n) . " days ";

        } else if (round(($nbseconds / 604800), 1) < 4) {
            //weeks
            $n = round(($nbseconds / 604800), 1);
            if ($n <= 1) $c = "Before " . ceil($n) . " week ";
            else if ($n < 2) $c = "Before " . floor($n) . " week ";
            else $c = "Before " . floor($n) . " weeks ";
        } else if (round(($nbseconds / 2629800), 1) < 12) {
            //months
            $n = round(($nbseconds / 2629800), 1);
            if ($n <= 1) $c = "Before " . ceil($n) . " month ";
            else if ($n < 2) $c = "Before " . floor($n) . " month ";
            else $c = "Before " . floor($n) . " months ";
        } else {
            //years
            $n = round(($nbseconds / 31557600), 1);
            if ($n <= 1) $c = "Before " . ceil($n) . " year ";
            else if ($n < 2) $c = "Before " . floor($n) . " year ";
            else $c = "Before " . floor($n) . " years ";
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
            if ($n <= 1) $c = "Before " . $n . " second ";
            else $c = "Before " . $n . " seconds ";
        } else if (round(($nbseconds / 60)) < 60) {
            //minutes
            $n = round(($nbseconds / 60), 1);
            if ($n <= 1) $c = "Before " . ceil($n) . " minute ";
            else if ($n < 2) $c = "Before " . floor($n) . " minute ";
            else $c = "Before " . floor($n) . " minutes ";
        } else if (round(($nbseconds / 3660), 1) < 24) {
            //hours
            $n = round(($nbseconds / 3660), 1);
            if ($n <= 1) $c = "Before " . ceil($n) . " hour ";
            else if ($n < 2) $c = "Before " . floor($n) . " hour ";
            else $c = "Before " . floor($n) . " hours ";
        } else if (round(($nbseconds / 86400), 1) < 7) {
            //days
            $n = round(($nbseconds / 86400), 1);
            if ($n <= 1) $c = "Before " . ceil($n) . " day ";
            else if ($n < 2) $c = "Before " . floor($n) . " day ";
            else $c = "Before " . floor($n) . " days ";

        } else if (round(($nbseconds / 604800), 1) < 4) {
            //weeks
            $n = round(($nbseconds / 604800), 1);

            if ($n <= 1) $c = "Before " . ceil($n) . " week ";
            else if ($n < 2) $c = "Before " . floor($n) . " week ";
            else $c = "Before " . floor($n) . " weeks ";
        } else {
            //years
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