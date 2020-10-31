<?php  
         function update_links(){
          //en
        try{ 
          $http_link='https://www.fyipress.net';
          $https_link='https://www.fyipress.net';

          include("fyipanel/views/connect.php");   
          $con->exec("update links set http_link='".$http_link."',https_link='".$https_link."' where id=1");
          $con->exec("update account set link='".$https_link."'"); 
          //arabic
          include("arabic/fyipanel/views/connect.php");   
          $con->exec("update links set http_link='".$http_link."/arabic',https_link='".$https_link."/arabic' where id=1");
          $con->exec("update account set link='".$https_link."/arabic'");
            //chinese
          include("chinese/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/chinese',https_link='".$https_link."/chinese' where id=1");
          $con->exec("update account set link='".$https_link."/chinese'");
            //french
          include("french/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/french',https_link='".$https_link."/french' where id=1");
          $con->exec("update account set link='".$https_link."/french'");
         //german
          include("german/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/german',https_link='".$https_link."/german' where id=1");
          $con->exec("update account set link='".$https_link."/german'");
         //hebrew
          include("hebrew/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/hebrew',https_link='".$https_link."/hebrew' where id=1");
          $con->exec("update account set link='".$https_link."/hebrew'");
          //indian
          include("indian/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/indian',https_link='".$https_link."/indian' where id=1");
          $con->exec("update account set link='".$https_link."/indian'");
         //japanese
          include("japanese/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/japanese',https_link='".$https_link."/japanese' where id=1");
          $con->exec("update account set link='".$https_link."/japanese'");
            //russian
          include("russian/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/russian',https_link='".$https_link."/russian' where id=1");
          $con->exec("update account set link='".$https_link."/russian'");
            //spanish
          include("spanish/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/spanish',https_link='".$https_link."/spanish' where id=1");
          $con->exec("update account set link='".$https_link."/spanish'");
            //turkish
          include("turkish/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/turkish',https_link='".$https_link."/turkish' where id=1");
          $con->exec("update account set link='".$https_link."/turkish'");
         //urdu
          include("urdu/fyipanel/views/connect.php");  
          $con->exec("update links set http_link='".$http_link."/urdu',https_link='".$https_link."/urdu' where id=1");
          $con->exec("update account set link='".$https_link."/urdu'");

          }catch(PDOException $e){
            echo "error ".$e->getMessage();
          }
          }

          update_links();
 ?>