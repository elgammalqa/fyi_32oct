<!DOCTYPE html>
<html>
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>   
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
	
	<meta name="description" content="fyi Press, fyipress, News, Sports, Technlogy, General Culture, Arts">
	<meta name="author" content="Chatsrun"> 
	<meta name="keyword" content="fyi Press, fyipress, News, Sports, Technlogy, General Culture, Arts"> 
		<!-- Shareable -->
	<meta property="og:title" content="fyi Press, fyipress, News, Sports, Technlogy, General Culture, Arts" />
	<meta property="og:type" content="article" />
	<meta property="og:url" content="http://fyipress.net" /> 
	<meta property="og:image" content="http://fyipress.net/images/fyipress.png" />
	<link rel="icon" href="http://fyipress.net/images/fyipress.ico">  
	<title>Fyi Press</title>
</head>
<body>
<?php  if(isset($_COOKIE['current_language'])){ ?> 
		<script> location.href='<?php echo $_COOKIE["current_language"]; ?>'; </script>
<?php  }else { 
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://".$_SERVER['HTTP_HOST']; 
	//$actual_link=$actual_link.'/home.php';
	$actual_link=$actual_link.'/fyi/home.php';
?>
	<script> location.href='<?php echo $actual_link; ?>'; </script>
<?php } ?> 
</body>
</html>


