<?php
function comments_time($d)
{
    $c = '';
    date_default_timezone_set('GMT');
    $time2 = date("Y-m-d H:i:s");
    $time1 = $d;
    $nb = round((strtotime($time2) - strtotime($time1)), 1);
    $nbsecondes = floor($nb);
    if ($nbsecondes >= 0) {
        if ($nbsecondes <= 59) {
            //secondes
            if ($nbsecondes == 0) $n = 1;
            else $n = $nbsecondes;
            if ($n <= 1) $c = "Avant " . $n . " seconde ";
            else $c = "Avant " . $n . " secondes ";
        } else if (round(($nbsecondes / 60)) < 60) {
            //minutes
            $n = round(($nbsecondes / 60), 1);
            if ($n <= 1) $c = "Avant " . ceil($n) . " minute ";
            else if ($n < 2) $c = "Avant " . floor($n) . " minute ";
            else $c = "Avant " . floor($n) . " minutes ";
        } else if (round(($nbsecondes / 3660), 1) < 24) {
            //heures
            $n = round(($nbsecondes / 3660), 1);
            if ($n <= 1) $c = "Avant " . ceil($n) . " heure ";
            else if ($n < 2) $c = "Avant " . floor($n) . " heure ";
            else $c = "Avant " . floor($n) . " heures ";
        } else if (round(($nbsecondes / 86400), 1) < 7) {
            //jours
            $n = round(($nbsecondes / 86400), 1);
            if ($n <= 1) $c = "Avant " . ceil($n) . " jour ";
            else if ($n < 2) $c = "Avant " . floor($n) . " jour ";
            else $c = "Avant " . floor($n) . " jours ";

        } else if (round(($nbsecondes / 604800), 1) < 4) {
            //semaines
            $n = round(($nbsecondes / 604800), 1);
            if ($n <= 1) $c = "Avant " . ceil($n) . " semaine ";
            else if ($n < 2) $c = "Avant " . floor($n) . " semaine ";
            else $c = "Avant " . floor($n) . " semaines ";
        } else if (round(($nbsecondes / 2629800), 1) < 12) {
            //mois
            $n = round(($nbsecondes / 2629800), 1);
            if ($n <= 1) $c = "Avant " . ceil($n) . " mois ";
            else if ($n < 2) $c = "Avant " . floor($n) . " mois ";
            else $c = "Avant " . floor($n) . " mois ";
        } else {
            //ans
            $n = round(($nbsecondes / 31557600), 1);
            if ($n <= 1) $c = "Avant " . ceil($n) . " an ";
            else if ($n < 2) $c = "Avant " . floor($n) . " an ";
            else $c = "Avant " . floor($n) . " ans ";
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
    $nbsecondes = floor($nb);
    if ($nbsecondes >= 0) {
        if ($nbsecondes <= 59) {
            //secondes
            if ($nbsecondes == 0) $n = 1;
            else $n = $nbsecondes;
            if ($n <= 1) $c = "Avant " . $n . " seconde ";
            else $c = "Avant " . $n . " secondes ";
        } else if (round(($nbsecondes / 60)) < 60) {
            //minutes
            $n = round(($nbsecondes / 60), 1);
            if ($n <= 1) $c = "Avant " . ceil($n) . " minute ";
            else if ($n < 2) $c = "Avant " . floor($n) . " minute ";
            else $c = "Avant " . floor($n) . " minutes ";
        } else if (round(($nbsecondes / 3660), 1) < 24) {
            //heures
            $n = round(($nbsecondes / 3660), 1);
            if ($n <= 1) $c = "Avant " . ceil($n) . " heure ";
            else if ($n < 2) $c = "Avant " . floor($n) . " heure ";
            else $c = "Avant " . floor($n) . " heures ";
        } else if (round(($nbsecondes / 86400), 1) < 7) {
            //jours
            $n = round(($nbsecondes / 86400), 1);
            if ($n <= 1) $c = "Avant " . ceil($n) . " jour ";
            else if ($n < 2) $c = "Avant " . floor($n) . " jour ";
            else $c = "Avant " . floor($n) . " jours ";

        } else if (round(($nbsecondes / 604800), 1) < 4) {
            //semaines
            $n = round(($nbsecondes / 604800), 1);

            if ($n <= 1) $c = "Avant " . ceil($n) . " semaine ";
            else if ($n < 2) $c = "Avant " . floor($n) . " semaine ";
            else $c = "Avant " . floor($n) . " semaines ";
        } else {
            //ans
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