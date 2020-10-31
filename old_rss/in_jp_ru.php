<?php  
	include("../indian/fyipanel/views/connect.php"); 
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) "); 
	include("../japanese/fyipanel/views/connect.php"); 
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) ");
	include("../russian/fyipanel/views/connect.php");  
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) "); 
?>   