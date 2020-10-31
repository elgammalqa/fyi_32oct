<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
    <title>FYI Press</title>  
</head>
        <?php  if (isset($_COOKIE['fyipPhoto'])&&!empty($_COOKIE['fyipPhoto'])&&
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
        ?> 
        <div class="profile clearfix">
              <div class="profile_pic"> 
                <img src="<?php echo "../views/img/".$fyipPhoto; ?>" 
                style="width: 80px; height: 70px; margin-left: 10px; margin-top: 10px;" alt="..." class="img-circle photox">
              </div>
              <div class="profile_info" style="padding-left: 10px; padding-top: 18px">
                <span>Welcome,</span>
                <h2 style="padding-left: 30px;"> <?php echo  $fyipFirst_name; ?> </h2>
              </div>
            </div>