<?php
try
{
 $con= new PDO('mysql:host=localhost;dbname=fyi_turkish', 'thatsfyidb', 'AAAaaa@1234' );
 //$con= new PDO('mysql:host=localhost;dbname=fyi8_turkish', 'root', '' );
    $con->exec("set names utf8");
    
}
catch (Exception $e)
{
        die('Error : ' . $e->getMessage());
} 
?>