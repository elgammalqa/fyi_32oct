<?php 

	function f(){
	 include("fyipanel/views/connect.php");
        $tab = array();
        $query = $con->query("SELECT source FROM `rss_sources` WHERE id in (4,5,32,38,48,50,52,63,66,67,68)");
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



