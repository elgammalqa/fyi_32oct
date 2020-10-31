<?php 
try{
	include 'fyipanel/models/ads.model.php'; 
$p=adsModel::get_pdf_by_id2($_GET['id']);  
header('content-Disposition: attachment; filename = '.$p.'');
header('content-type:application/octent-strem');
header('content-lenght='.filesize($p));
@readfile('ads/pdf/'.$p);
 
} 
catch(Exception $e){ ?>
<script type="text/javascript">
	window.location.replace('home.php');
</script> 
<?php }  ?>




