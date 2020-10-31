<?php  session_start(); ob_start();
            function addLike(){ 
              try{
               include '../fyipanel/views/connect.php'; 
               $con->exec("UPDATE footer SET fyi_likes=fyi_likes+1");
               return true;
                  } catch (PDOException $e) {
                      return false;  
                  }
           }
            function addLike2(){ 
              try{
               include 'fyipanel/views/connect.php'; 
               $con->exec("UPDATE footer SET fyi_likes=fyi_likes+1");
               return true;
                  } catch (PDOException $e) {
                      return false;  
                  }
           }
         addLike2(); 

            if (count($_COOKIE)>0) {  
				setcookie("already_l_ar","already_l_ar",time() + (10 * 365 * 24 * 60 * 60)); 
            }else{ 
                $_SESSION['already_l_ar']='already_l_ar'; 
            }      
if(addLike())
header('Location:index.php');

 ?> 