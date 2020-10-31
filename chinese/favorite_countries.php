<?php 
session_start();   
ob_start();  
require_once('models/utilisateurs.model.php'); 
require_once('models/v4.utilisateurs.model.php'); 
if(utilisateursModel::islogged())
$log=true;  
else $log=false;    
 ?>   
<!DOCTYPE html>   
<html>
  <head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon"   href="images/fyipress.ico">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../scripts/bootstrap/bootstrap.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="../scripts/ionicons/css/ionicons.min.css">
    <!-- Toast -->
    <link rel="stylesheet" href="../scripts/toast/jquery.toast.min.css">
    <!-- OwlCarousel -->
    <link rel="stylesheet" href="../scripts/owlcarousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="../scripts/owlcarousel/dist/assets/owl.theme.default.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../scripts/magnific-popup/dist/magnific-popup.css">
    <link rel="stylesheet" href="../scripts/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="stylesheet" href="../css/skins/all.css">
    <link rel="stylesheet" href="../css/demo.css">
    <link rel="stylesheet" href="../try.css">
      <style>
          .source_top_row div{float: left; margin-top: 40px;}
          .source_top_row a{
              float: left; width: 100%;
          }
          .source_top_row a.selected{background-color: #c8081c;
              border-color: #c8081c; }
      </style>
  </head>    
     <?php require_once ("header.php");  
     if(!isMobile()) echo '<br><br><br><br><br><br> ';
     else echo '<br><br> '; ?>
<body> 
    <div class="content container">

        <div class="row source_top_row">
            <?php
            $query = $_SERVER['PHP_SELF'];
            $path = pathinfo( $query );
            $page = $path['basename'];
            ?>
            <div class="col-xs-6 col-sm-4 col-md-2">
                <a href="favorite_countries.php" class="btn btn-md btn-primary <?=(!stristr($page,'user_')) ? 'selected' : '';?>">所有国家</a>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-2">
                <a href="user_favorite_countries.php" class="btn btn-md btn-primary <?=(stristr($page,'user_')) ? 'selected' : '';?>">我的资料</a>
            </div>
        </div>

        <div class="container stats"><br><h1   >国家名单 : </h1><hr></div>
        <div class="container-fluid">

          <form method="post" >
          <div class="row">
          <?php  
           $utilisateur=new utilisateursModel();  
           $req=$utilisateur->get_countries();
           $notchecked=array();
         foreach($req as $country){ 
             $c=$country['country'];
          ?> 
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
              <div class="card card-stats">
                <div class="card-header card-header-default card-header-icon">
                  <div class="card-icon">
                    <a href="favorite_sources.php?country=<?php echo $country['country']; ?>">
                       <img src="../v2/countries/<?php echo $c; ?>.png" width="80px" alt="" srcset="">
                  </a>
                  </div>
                  <h5 class="h5" >
                    <a  href="favorite_sources.php?country=<?php echo $country['country']; ?>">
                      <?php echo $c; ?> 
                    </a> 
                  </h5> 
                </div>
                <div class="card-footer">
                  <div class="stats">  
             <label class="containers">跟随
             <?php   
              if($log==true){//logged 
              if(isset($_COOKIE['fyiuser_email'])){
                $email=$_COOKIE['fyiuser_email'];
              }else if(isset($_SESSION['user_auth']['user_email'])){
                $email=$_SESSION['user_auth']['user_email'];
              }  
             $nb=v4Utilisteurs::check_country($email,$c);
             if($nb==0){ ?>
               <input type="checkbox"  name="countries[]" value="<?php echo $c; ?>" >
               <span class="checkmark"></span>
             <?php }else{ ?>
               <input type="checkbox" checked  name="countries[]" value="<?php echo $c; ?>" >
               <span class="checkmark"></span>
             <?php } 
            }else{//not logged
              if(isset($_COOKIE['chinese_sources'])){ //there is a cookie
                $data = json_decode($_COOKIE['chinese_sources'], true);
                $allids= v4Utilisteurs::get_ids_of_country($c);
                $exist=true;
                foreach($allids as $value){  
                  if(!in_array($value['id'], $data)){
                     $exist=false;  break;
                  }
                }//for

                if($exist){ //all exist in the cookie ?>
                   <input type="checkbox"  name="countries[]" value="<?php echo $c; ?>" >
                   <span class="checkmark"></span>
               <?php }else{ ?>
                 <input type="checkbox" checked  name="countries[]" value="<?php echo $c; ?>" >
                  <span class="checkmark"></span>
               <?php }  
              }else{//there is no cookie  ?>
                 <input type="checkbox" checked name="countries[]" value="<?php echo $c; ?>" >
                   <span class="checkmark"></span> 
            <?php } 
            }//not logged
           ?> 
          </label>   
                  </div>
                </div>
              </div>
            </div>  
          <?php }  //for  ?> 
        </div>
             <input type="submit" class="green" name="Enregistrer" value="保存" style="font-size: 26px; margin-right: 60px; " > 
            </form> 
          </div>   
        </div>   
            <?php  
            if(isset($_POST['Enregistrer'])&&isset($_POST['countries'])){ 
              $all_countries_in_db=$utilisateur->get_countries();
              $GLOBALS['nb_sources_not_checked']=0; 
                  foreach($all_countries_in_db as $country){ 
                if( !in_array($country['country'], $_POST['countries']) ){ 
         $GLOBALS['nb_sources_not_checked']+=v4Utilisteurs::nb_rss_sources_of_country($country['country']);
                }  
              }//foreach  
              $nb_rss_sources=utilisateursModel::get_nb_rss_source();
              $GLOBALS['nb_sources_not_checked']=$nb_rss_sources-$GLOBALS['nb_sources_not_checked']; 
              if($GLOBALS['nb_sources_not_checked']>=5){//ok we can continue

                  $all_countries_in_db=$utilisateur->get_countries(); 
                  foreach($all_countries_in_db as $country){ 
                    $currentCountry=$country['country'];
                     if( !in_array( $currentCountry, $_POST['countries']) ){ //country un checked 
                           $idsOfCurrentCountry=v4Utilisteurs::get_ids_of_country($currentCountry); 
                            foreach($idsOfCurrentCountry as $row){  
                              $id=$row['id']; 
                              if($log==true){ 
                                   $emaill=utilisateursModel::check_source($email,$id);
                                   if($emaill==null){ 
                                   utilisateursModel::add_user_sources($email,$id); 
                                   }
                              } else { //not logged 
                                if(isset($_COOKIE['chinese_sources'])){ 
                                      if(!in_array($id, $data)){ 
                                           array_push($data,$id); 
                                      }    
                                }else{//there is no cookie
                                  array_push($notchecked, $id); 
                                }
                            }//not logged  
                            }//ids  
                      }else{//country checked 
                          $idsOfCurrentCountry=v4Utilisteurs::get_ids_of_country($currentCountry); 
                          foreach($idsOfCurrentCountry as $row){  
                            $id=$row['id'];
                              if($log==true){ 
                                  $emaill=utilisateursModel::check_source($email,$id);
                                  if($emaill!=null){  
                                    utilisateursModel::delete_user_sources($email,$id);
                                  }
                              } else { //not logged 
                                if(isset($_COOKIE['chinese_sources'])){ 
                                  if(in_array($id, $data)){ 
                                     unset($data[array_search($id,$data,true)]);  
                                  }   
                                } 
                              }//not logged
                          }//ids 
                      }//country checked
                  }//foreach countries
                  if($log==false){
                      if(isset($_COOKIE['chinese_sources'])){
                      setcookie('chinese_sources', json_encode($data),time()+31556926 ,'/');
                    }else{
                      setcookie('chinese_sources', json_encode($notchecked),time()+31556926 ,'/'); 
                    }
                  }
                  ?>
                   <script>  location.href="favorite_countries.php";  </script>   
                  <?php
              }else{//not ok 
                echo "<script> alert('您必须至少关注五个来源'); </script>";
              }  
            }else if(isset($_POST['Enregistrer'])&&!isset($_POST['countries'])){//all not checked
                echo "<script> alert('您必须至少关注五个来源'); </script>"; 
            }   
             ?>

<br><br><br><br>
    <!-- Start footer -->
    <?php require_once ('footer.php') ?>
    <!-- End Footer -->  
    <!-- JS -->   
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery.migrate.js"></script>
    <script src="../scripts/bootstrap/bootstrap.min.js"></script>
    <script>var $target_end=$(".best-of-the-week");</script>
    <script src="../scripts/jquery-number/jquery.number.min.js"></script>
    <script src="../scripts/owlcarousel/dist/owl.carousel.min.js"></script>
    <script src="../scripts/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <script src="../scripts/easescroll/jquery.easeScroll.js"></script>
    <script src="../scripts/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../scripts/toast/jquery.toast.min.js"></script> 
    <script src="../js/e-magz.js"></script> 
        <script type="text/javascript">
      $(document).ready(function(){
        $('.backk').click(function(){   
      $(".nav-list").removeClass("active");
      $(".nav-list").removeClass("active");
        $(".nav-list .dropdown-menu").removeClass("active");
        $(".nav-title a").text("Menu");
        $(".nav-title .back").remove();
        $("body").css({
          overflow: "auto"
        });
        backdrop.hide();
         
        });  
      }); 
    </script>
  </body>
</html>

