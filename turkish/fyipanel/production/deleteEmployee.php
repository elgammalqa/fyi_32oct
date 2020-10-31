<?php 
session_start();   ob_start();  
include '../models/user.model.php';  
  if(userModel::islogged("Admin")==true){ 
  	//tr
    $user_del=new userModel();

    $img=userModel::getImageName($_GET["id"]);
    if($img!="profil.png"){ 

     $target_dir = "../views/img/";
    unlink($target_dir."".$img);  
 
     //en
     $target_dir = "../../../fyipanel/views/img/";
    unlink($target_dir."".$img); 
    //es
     $target_dir = "../../../spanish/fyipanel/views/img/";
    unlink($target_dir."".$img); 
    //ar
     $target_dir = "../../../arabic/fyipanel/views/img/";
    unlink($target_dir."".$img); 
    //chinese
     $target_dir = "../../../chinese/fyipanel/views/img/";
    unlink($target_dir."".$img); 
    //russian
     $target_dir = "../../../russian/fyipanel/views/img/";
    unlink($target_dir."".$img); 
    //french
     $target_dir = "../../../french/fyipanel/views/img/";
    unlink($target_dir."".$img); 
    
     $target_dir = "../../../indian/fyipanel/views/img/";
    unlink($target_dir."".$img); 
    
     $target_dir = "../../../urdu/fyipanel/views/img/";
    unlink($target_dir."".$img); 
    
     $target_dir = "../../../hebrew/fyipanel/views/img/";
    unlink($target_dir."".$img); 
    
     $target_dir = "../../../german/fyipanel/views/img/";
    unlink($target_dir."".$img); 
    
     $target_dir = "../../../japanese/fyipanel/views/img/";
    unlink($target_dir."".$img);  
      }

    $user_del->delete_user($_GET["id"]); 
}
?> 
<script>
window.location.replace('edit_users.php');
</script>