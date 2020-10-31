 <style type="text/css">
  body{ 
   background: #F7F7F7 !important; 
  } 
  
</style>  
<?php 
 if (isset($_COOKIE['fyipPhoto'])&&!empty($_COOKIE['fyipPhoto'])&&
          isset($_COOKIE['fyipFirst_name'])&&!empty($_COOKIE['fyipFirst_name'])&&
          isset($_COOKIE['fyipLast_name'])&&!empty($_COOKIE['fyipLast_name'])){
          $fyipPhoto=$_COOKIE['fyipPhoto'];
          $fyipFirst_name=$_COOKIE['fyipFirst_name'];
          $fyipLast_name=$_COOKIE['fyipLast_name'];  
        } else {   
          $fyipPhoto=$_SESSION['auth']['Photo'];
          $fyipFirst_name=$_SESSION['auth']['First_name'];
          $fyipLast_name=$_SESSION['auth']['Last_name']; 
        }  

         $fun_of_user=" ";
  if (isset($_COOKIE['fyipFunction'])&&!empty($_COOKIE['fyipFunction'])){
    $fun_of_user=$_COOKIE['fyipFunction'];
  }else if(isset($_SESSION['auth']['Function'])&&!empty($_SESSION['auth']['Function'])){
    $fun_of_user=$_SESSION['auth']['Function'];
  }
   if($fun_of_user!=""){
      if($fun_of_user=="Admin"){
        $fun_of_user="admin.php";
      }else if($fun_of_user=="Reporter"){
        $fun_of_user="reporter.php"; 
      }else{
        $fun_of_user="head.php"; 
      }
   }  
         ?>        
       <!-- sidebar menu --> 
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">   

                  <ul class="nav side-menu">
                  <li><a style="font-size: 13px;" ><i style="padding-top: 5px;  "  class="fa fa-language fa-lg " aria-hidden="true"></i> Languages <span class="fa fa-chevron-down"></span></a> 
                    <ul class="nav child_menu"> 
                      <li><a  style="font-size: 14px;" href="../../arabic/fyipanel/production/<?php echo $fun_of_user; ?>">Arabic</a></li> 
                      <li><a style="font-size: 14px;" href="../../urdu/fyipanel/production/<?php echo $fun_of_user; ?>">Urdu</a></li> 
                      <li><a style="font-size: 14px;" href="<?php echo $fun_of_user; ?>">English</a></li>
                      <li><a style="font-size: 14px;" href="../../turkish/fyipanel/production/<?php echo $fun_of_user; ?>">Turkish</a></li> 
                      <li><a style="font-size: 14px;" href="../../german/fyipanel/production/<?php echo $fun_of_user; ?>">German</a></li> 
                      <li><a style="font-size: 14px;" href="../../spanish/fyipanel/production/<?php echo $fun_of_user; ?>">Spanish</a></li>
                      <li><a style="font-size: 14px;" href="../../french/fyipanel/production/<?php echo $fun_of_user; ?>">French</a></li> 
                      <li><a style="font-size: 14px;" href="../../russian/fyipanel/production/<?php echo $fun_of_user; ?>">Russian</a></li> 
                      <li><a style="font-size: 14px;" href="../../japanese/fyipanel/production/<?php echo $fun_of_user; ?>">Japanese</a></li>
                      <li><a style="font-size: 14px;" href="../../chinese/fyipanel/production/<?php echo $fun_of_user; ?>">Chinese</a></li>
                       <li><a style="font-size: 14px;" href="../../indian/fyipanel/production/<?php echo $fun_of_user; ?>">Indian</a></li>
                      <li><a style="font-size: 14px;" href="../../hebrew/fyipanel/production/<?php echo $fun_of_user; ?>">Hebrew</a></li>   
                    </ul>
                  </li>             
                </ul> 
              </div>
            </div>
            <!-- /sidebar menu -->