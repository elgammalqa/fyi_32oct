<?php  
	include("../fyipanel/views/connect.php"); 
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) "); 
	include("../arabic/fyipanel/views/connect.php"); 
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) ");
	include("../chinese/fyipanel/views/connect.php");  
    $con->exec("DELETE FROM rss WHERE pubDate < DATE_SUB(NOW(), INTERVAL 7 DAY) "); 
?>   