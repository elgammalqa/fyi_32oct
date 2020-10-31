<?php 
try{
	include 'fyipanel/models/news_published.model.php'; 
$p=news_publishedModel::get_media_by_id2($_GET['id']);  
header('content-Disposition: attachment; filename = '.$p.'');
header('content-type:application/octent-strem');
header('content-lenght='.filesize($p));
@readfile('fyiPanel/views/image_news/'.$p);
 
}
catch(Exception $e){ ?>
<script type="text/javascript">
	window.location.replace('home.php');
</script> 
<?php }  ?>




