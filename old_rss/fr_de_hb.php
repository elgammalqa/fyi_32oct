<?php  
	include("../french/fyipanel/views/connect.php"); 
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) "); 
	include("../german/fyipanel/views/connect.php"); 
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) ");
	include("../hebrew/fyipanel/views/connect.php");  
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) "); 
?>   