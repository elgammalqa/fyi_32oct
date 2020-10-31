<?php 
   if (isset($_GET['id_pub'])&&!empty($_GET['id_pub'])) {
   	 include '../models/news.model.php'; 
    $art=new newsModel();   
    $art->update_status($_GET['id_pub']); 
   }
?> 

<script>
window.location.replace('articles_not_sent.php');
</script>