<?php  session_start(); ob_start();
            function addLike(){
              try{
               include 'fyipanel/views/connect.php'; 
               $con->exec("UPDATE footer SET fyi_likes=fyi_likes+1");
               return true;
           } catch (PDOException $e) {
          return false;  
    } 
           }   

            if (count($_COOKIE)>0) {  
				setcookie("already_l","already_l",time() + (10 * 365 * 24 * 60 * 60)); 
            }else{ 
                $_SESSION['already_l']='already_l'; 
            } 
  
if(addLike())
header('Location:home.php');

 ?> 