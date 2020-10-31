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
            if ($n <= 1) $c = "ANTES DE  " . $n . " segundo ";
            else $c = "ANTES DE  " . $n . " segundos ";
        } else if (round(($nbseconds / 60)) < 60) {
            //Minutos
            $n = round(($nbseconds / 60), 1);
            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Minuto ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Minuto ";
            else $c = "ANTES DE  " . floor($n) . " Minutos ";
        } else if (round(($nbseconds / 3660), 1) < 24) {
            //Horas
            $n = round(($nbseconds / 3660), 1);
            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Hora ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Hora ";
            else $c = "ANTES DE  " . floor($n) . " Horas ";
        } else if (round(($nbseconds / 86400), 1) < 7) {
            //Días
            $n = round(($nbseconds / 86400), 1);
            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Día ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Día ";
            else $c = "ANTES DE  " . floor($n) . " Días ";

        } else if (round(($nbseconds / 604800), 1) < 4) {
            //Semanas
            $n = round(($nbseconds / 604800), 1);
            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Semana ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Semana ";
            else $c = "ANTES DE  " . floor($n) . " Semanas ";
        } else if (round(($nbseconds / 2629800), 1) < 12) {
            //Meses
            $n = round(($nbseconds / 2629800), 1);
            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Mes ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Mes ";
            else $c = "ANTES DE  " . floor($n) . " Meses ";
        } else {
            //Años
            $n = round(($nbseconds / 31557600), 1);
            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Año ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Año ";
            else $c = "ANTES DE  " . floor($n) . " Años ";
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
            if ($n <= 1) $c = "ANTES DE  " . $n . " segundo ";
            else $c = "ANTES DE  " . $n . " segundos ";
        } else if (round(($nbseconds / 60)) < 60) {
            //Minutos
            $n = round(($nbseconds / 60), 1);
            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Minuto ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Minuto ";
            else $c = "ANTES DE  " . floor($n) . " Minutos ";
        } else if (round(($nbseconds / 3660), 1) < 24) {
            //Horas
            $n = round(($nbseconds / 3660), 1);
            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Hora ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Hora ";
            else $c = "ANTES DE  " . floor($n) . " Horas ";
        } else if (round(($nbseconds / 86400), 1) < 7) {
            //Días
            $n = round(($nbseconds / 86400), 1);
            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Día ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Día ";
            else $c = "ANTES DE  " . floor($n) . " Días ";

        } else if (round(($nbseconds / 604800), 1) < 4) {
            //Semanas
            $n = round(($nbseconds / 604800), 1);

            if ($n <= 1) $c = "ANTES DE  " . ceil($n) . " Semana ";
            else if ($n < 2) $c = "ANTES DE  " . floor($n) . " Semana ";
            else $c = "ANTES DE  " . floor($n) . " Semanas ";
        } else {
            //Años
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