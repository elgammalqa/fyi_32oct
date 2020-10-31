<?php  
	include("../spanish/fyipanel/views/connect.php"); 
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) "); 
	include("../turkish/fyipanel/views/connect.php"); 
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) ");
	include("../urdu/fyipanel/views/connect.php");  
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) "); 
?> 