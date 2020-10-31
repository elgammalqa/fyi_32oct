<?php 

	function f(){
	 include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("SELECT source FROM `rss_sources` WHERE id in (8,10,11,17,29,30,31,32,33,39,40,42,43,47,48,50,63,66,70,75,76,77,82,84,87)");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab;
    }
 
    $q=f();
    foreach ($q as $key => $value) {
    	echo "('".$value["source"]."'),<br>";
    }
 ?>