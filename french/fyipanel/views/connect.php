<?php
try
{ 
$con= new PDO('mysql:host=localhost;dbname=fyi_french', 'thatsfyidb', 'AAAaaa@1234' );
//$con= new PDO('mysql:host=localhost;dbname=fyi8_french', 'root', '' );
    $con->exec("set names utf8");
    
}
catch (Exception $e)
{
        die('Error : ' . $e->getMessage());
} 
?>