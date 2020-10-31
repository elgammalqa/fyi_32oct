<?php 

	function f(){
	 include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("SELECT source FROM `rss_sources` WHERE id in (3,5,9,19)");
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

