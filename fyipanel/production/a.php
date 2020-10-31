<?php 
  function all_countries(){  
            $tab = array();   
            include("../views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../german/fyipanel/views/connect.php");   
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../french/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../spanish/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../turkish/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../russian/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../arabic/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../urdu/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../indian/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../hebrew/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../japanese/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }
            include("../../chinese/fyipanel/views/connect.php");    
            $query=$con->query('select * from countries');
            while ($data = $query->fetch()){
              $tab[$data['country']] = $data['country'];
            }

             return $tab; 

        }
 

  $req=all_countries(); 
                              
                             foreach ($req as $key)  
                              echo $key."<br>"; 
 ?>