  <style type="text/css"> 
  .centers li  a{ 
    text-align: center;
    font-size: 13px;
    border-bottom: 1px #eae4e4 solid;
  }  
  .centersmob li  a{
    text-align: center;
    font-size: 17px;
    border-bottom: 1px #eae4e4 solid;
    padding-top: 5px !important;
    padding-bottom: 10px !important;
    
  }    
 </style>  
 <?php  
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
 <div class="top_nav">  
          <div class="nav_menu">
            <nav> 
               <div class="nav toggle" style="width: 0 !important;">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right" style="width: 80%" > 
                <li    >
                  <?php   if(usermodel::isMobile()){ ?>
                   <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="font-size: 18px;" >  
                      <i style="padding-top: 5px;" class="fa fa-language fa-lg " aria-hidden="true"></i> 
                    <span class=" fa fa-angle-down fa-lg" ></span>
                  </a> 
                  <ul  class="dropdown-menu dropdown-usermenu pull-right centersmob" style="width: 0px;" >
                <?php }else{  ?>
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" >  
                      <i style="font-size: 15px;" class="fa fa-language fa-xs " aria-hidden="true">  </i> <span style="font-size: 16px;" >Languages</span>
                    <i class=" fa fa-angle-down fa-sm" style="font-size: 18px;"></i>
                  </a> 
                  <ul  class="dropdown-menu dropdown-usermenu pull-right centers" style="width: 0px;" >
                <?php }  ?>   
                    <li><a href="../../../fyipanel/production/all_cpanel.php" >All</a></li>   
                      <li><a   href="../../../arabic/fyipanel/production/<?php echo $fun_of_user; ?>">Arabic</a></li> 
                      <li><a  href="../../../urdu/fyipanel/production/<?php echo $fun_of_user; ?>">Urdu</a></li>  
                      <li><a  href="../../../fyipanel/production/<?php echo $fun_of_user; ?>">English</a></li>
                      <li><a  href="../../../turkish/fyipanel/production/<?php echo $fun_of_user; ?>">Turkish</a></li> 
                      <li><a  href="../../../german/fyipanel/production/<?php echo $fun_of_user; ?>">German</a></li>  
                      <li><a  href="../../../spanish/fyipanel/production/<?php echo $fun_of_user; ?>">Spanish</a></li>
                      <li><a  href="../../../french/fyipanel/production/<?php echo $fun_of_user; ?>">French</a></li> 
                      <li><a  href="../../../russian/fyipanel/production/<?php echo $fun_of_user; ?>">Russian</a></li> 
                      <li><a  href="<?php echo $fun_of_user; ?>">Japanese</a></li>
                      <li><a  href="../../../chinese/fyipanel/production/<?php echo $fun_of_user; ?>">Chinese</a></li>
                       <li><a  href="../../../indian/fyipanel/production/<?php echo $fun_of_user; ?>">Indian</a></li>
                      <li><a  href="../../../hebrew/fyipanel/production/<?php echo $fun_of_user; ?>">Hebrew</a></li>
                  </ul>
                </li> 
   
                <li  >
                  <a href="<?php echo $fun_of_user; ?>" class="user-profile dropdown-toggle"  >
                     <img src="<?php   echo "../views/img/".$fyipPhoto; ?>" > 
                    <?php
                     if(usermodel::isMobile()){
                     echo $fyipFirst_name;
                     }else{
                       echo $fyipFirst_name." ".$fyipLast_name;
                     } ?>  
                  </a> 
                </li>  
    
                <?php   if(usermodel::isMobile()){ ?>
                   <li style="padding-top: 15px;"  >
                   <img src="../../../images/jp.png" style="max-width: none;width: 30px;"  >
                </li>
                <?php }else{  ?>
                   <li style="margin-right:40%;padding-top: 8px;"  style="float: left !important;" >
                  <h4 style="color: #2A3F54;"> Japanese </h4>
                </li>
                <?php }  ?>
                  
              </ul>
            </nav>
          </div>
        </div>