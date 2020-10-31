<?php 

	function f(){
	 include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("SELECT source FROM `rss_sources` WHERE id in (2,18,30,32,34,38,39,41,48,52,54,56,65)");
        while ($data = $query->fetch()) {
            $tab[] = $data;
        }
        return $tab; 
    } 

    $q=f();
    foreach ($q as $key => $value) {
    	echo '("'.$value['source'].'"),<br>';
    }

 ?>



