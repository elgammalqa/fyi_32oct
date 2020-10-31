<?php
try 
{
$con= new PDO('mysql:host=localhost;dbname=fyi_hebrew', 'thatsfyidb', 'AAAaaa@1234' );
//$con= new PDO('mysql:host=localhost;dbname=fyi8_hebrew', 'root', '' );
    $con->exec("set names utf8");
    
}
catch (Exception $e)
{
        die('Error : ' . $e->getMessage());
} 
?>