  <style type="text/css"> 
  .centers li  a{
    text-align: center;
  }
    @media (min-width: 800px){
       #centerr{ margin-right:40%; }
   } 
 </style> 
 <div class="top_nav">
          <div class="nav_menu">
            <nav> 
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="admin.php" class="user-profile dropdown-toggle"  >
                    <img src="<?php echo "../views/img/".$fyipPhoto; ?>" alt=""> 
                    <?php echo $fyipFirst_name." ".$fyipLast_name; ?>  
                  </a>
                </li> 

                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="font-size: 18px;" >  
                      <i style="padding-top: 5px;" class="fa fa-language fa-lg " aria-hidden="true"></i>
                    Languages
                    <span class=" fa fa-angle-down fa-lg"></span>
                  </a> 
                  <ul  class="dropdown-menu dropdown-usermenu pull-right centers" style="width: 0px;" >
                    <li><a href="" >All</a></li>
                    <li><a href=""> العربية</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                    <li><a href="">English</a></li>
                  </ul>
                </li>

                <li id="centerr">
                  <h1 style="color: #2A3F54;">English</h1>
                </li>

                 
              </ul>
            </nav>
          </div>
        </div>