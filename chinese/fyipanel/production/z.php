<!DOCTYPE html>
<html>
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
	<title></title>
</head>
<body>
  <form method="POST"  enctype="multipart/form-data" data-parsley-validate 
               class="form-horizontal form-label-left">   
                     <div class="form-group"> 
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12 " for="first-name">
                        From :  
                      </label>
                      <div class="col-md-2 col-sm-2 col-xs-12"> 
                        <input type="time" required="required" name="from"  class="form-control col-md-2 col-xs-12">
                      </div>
                      <label style="text-align: left" class="control-label col-md-1 col-sm-1 col-xs-12" for="first-name">
                        To :   
                      </label>
                      <div class="col-md-2 col-sm-2 col-xs-12"> 
                        <input type="time" required="required" name="to"  class="form-control col-md-2 col-xs-12">
                      </div> 
                      <button  name="submit" class="btn btn-success">Add</button> 
                      
                       <a href="z_edit_delete_hot_ads.php"> <button type="button" name="back" class="btn btn-primary">Back  </button></a>
                    </div>   
   </form> 

     <?php
     if(isset($_POST['submit'])){
        $ad_from=$_POST['from'];
        $ad_to=$_POST['to'];
        echo 'from = '.$ad_from.' to = '.$ad_to.'<br>';
                        }
     ?>




</body>
</html>