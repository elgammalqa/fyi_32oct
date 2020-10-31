<?php   
session_start();     
ob_start();   
require_once('models/utilisateurs.model.php');  
require_once('models/v4.utilisateurs.model.php');  
if(utilisateursModel::islogged())
$log=true;  
else $log=false;    
if(!isset($_GET['country'])||$_GET['country']==""){
 echo "<script> location.href='index.php'; </script>"; exit;
   } 

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
          .card_container {
              padding-top: 25px;
              background: #fff;
          }

          .fav_source_image {
              float: right;
              /*width: 80px;
              height: 80px;*/
              margin-right: 5px;
              max-width: 60px;
          }

          .fav_source_link {
              display: block;
              font-weight: bold;
              height: 40px;
              line-height: 0;
              margin-right: 25px;
              float: right;
              color: #000 !important;
              margin-top: 15px;
              font-size: 16px;
              border-bottom: 1px solid #f1f1f1;
              width: 55%;
              text-align: right;
          }

          .card {
              border-radius: 0 !important;
              box-shadow: none !important;
              padding-bottom: 5px;
              margin-top: 0 !important;
              height: 50px !important;
              margin-bottom: 25px !important;
          }

          .followers_count {
              font-weight: normal;
              font-size: 14px;
              float: right;
              width: 100%;
              margin-top: 40px;
              color: #ababab;
              display: none
          }

          input[type=checkbox].css-checkbox {
              position: absolute;
              z-index: -1000;
              left: -1000px;
              overflow: hidden;
              clip: rect(0 0 0 0);
              height: 1px;
              width: 1px;
              margin: -1px;
              padding: 0;
              border: 0;
          }

          input[type=checkbox].css-checkbox + label.css-label {
              margin-top: 0;
              padding-right: 65px;
              height: 31px;
              display: inline-block;
              line-height: 31px;
              background-repeat: no-repeat;
              background-position: 0 -31px;
              vertical-align: middle;
              cursor: pointer;
          }

          input[type=checkbox].css-checkbox:checked + label.css-label {
              background-position: 0 0;
              font-weight: bold;
          }

          label.css-label {
              font-weight: bold;
              background-image: url('images/add.png');
              -webkit-touch-callout: none;
              -webkit-user-select: none;
              -khtml-user-select: none;
              -moz-user-select: none;
              -ms-user-select: none;
              user-select: none;
          }
          input[type=submit] {
              width: 100px !important; height: 35px; border: 0; float: right;margin-right: 40%; line-height: 0;
              font-size: 14px; margin-bottom: 20px;
              color: #fff ;
              padding: 0 ;
              background: #fe0002 ;
          }
      </style>
  </head>    
    <?php require_once ("header.php");  
     if(!isMobile()) echo '<br><br><br><br><br><br> ';
     else echo '<br><br> '; ?>
  <body>    
    <div class="content">
        <div class="container stats"> 
            <h1> Kaynağı seçin : </h1> <hr> 
        </div>
          <div class="container container-fluid">
            <form method="post" >
            <div class="row"> 
          <?php
          function number_format_unchanged_precision($number, $dec_point = '.', $thousands_sep = ',')
          {
              if ($dec_point == $thousands_sep) {
                  trigger_error('2 parameters for ' . __METHOD__ . '() have the same value, that is "' . $dec_point . '" for $dec_point and $thousands_sep', E_USER_WARNING);
                  // It corresponds "PHP Warning:  Wrong parameter count for number_format()", which occurs when you use $dec_point without $thousands_sep to number_format().
              }
              if (preg_match('{\.\d+}', $number, $matches) === 1) {
                  $decimals = strlen($matches[0]) - 1;
              } else {
                  $decimals = 0;
              }
              return number_format($number, $decimals, $dec_point, $thousands_sep);
          }

           $utilisateur=new utilisateursModel();  
           $req=$utilisateur->get_sources_of_country($_GET['country']); 
           $pays=$_GET['country']; 
              $notchecked=array();
         ?>
                <div class="col-xs-12 col-md-5 col-md-push-4 card_container">
                    <?php

                    foreach ($req as $country) {

                        $source = $country["source"];
                        $source_row = $utilisateur->get_source_row($source);
                        //print_r($source_row);
                        if($source_row['type'] == 'Health'){ continue; }
                        $id_count = v4Utilisteurs::count_source_in_user_sources($source, $pays);
                        $rand = mt_rand(11111, 99999);
                        //echo 's: '.$source.' - ';
                        /*$source_ids = v4Utilisteurs::get_ids_of_source($pays, $source);
                        $id_count = 0;
                        foreach ($source_ids as $arr) {
                            $id = $arr['id'];

                            $id_count += v4Utilisteurs::count_source_in_user_sources($sourceو $pays);
                        }*/
                        //echo '</pre>';
                        ?>

                        <div class="col-xs-12">

                            <div class="card card-stats">

                                <img src="../v2/sources/<?php echo $source; ?>.png" width="80px" alt="" class="fav_source_image">

                                <a href="favorite_types.php?country=<?php echo $pays; ?>&source=<?php echo $source; ?>" class="fav_source_link">

                                    <?php echo ucwords($source); ?>

                                    <span class="followers_count">Takipçiler  <?= number_format_unchanged_precision($id_count) ?> </span>
                                </a>

                                <div class="col-xs-2 follow_unfollow_source" style="position: relative;">
                                    <?php
                                    if ($log == true) { //logged

                                        if (isset($_COOKIE['fyiuser_email'])) {

                                            $email = $_COOKIE['fyiuser_email'];

                                        } else if (isset($_SESSION['user_auth']['user_email'])) {
                                            $email = $_SESSION['user_auth']['user_email'];
                                        }

                                        $nb = v4Utilisteurs::check_sourcesOfCountry($email, $pays, $source);
                                        //echo $email.' - '.$pays.' - '.$source;

                                        if ($nb == 0) {
                                            ?>
                                            <input type="checkbox" name="countries[]" id="radio<?= $rand ?>" class="css-checkbox" value="<?= $source ?>"/><label
                                                    for="radio<?= $rand ?>" class="css-label radGroup<?= $rand ?>"> </label>

                                        <?php }
                                        else {
                                            ?>
                                            <input type="checkbox" checked name="countries[]" id="radio<?= $rand ?>" class="css-checkbox" value="<?= $source ?>"/><label
                                                    for="radio<?= $rand ?>" class="css-label radGroup<?= $rand ?>"> </label>

                                            <?php
                                        }

                                    }
                                    else {//not logged

                                        if (isset($_COOKIE['turkish_sources'])) { //there is a cookie

                                            $data = json_decode($_COOKIE['turkish_sources'], true);

                                            $allids = v4Utilisteurs::get_ids_of_source($pays, $source);

                                            $exist = true;

                                            foreach ($allids as $value) {

                                                if (!in_array($value['id'], $data)) {

                                                    $exist = false;
                                                    break;

                                                }

                                            }//for


                                            if ($exist) { //all exist in the cookie
                                                ?>


                                                <input type="checkbox" name="countries[]" id="radio<?= $rand ?>" class="css-checkbox" value="<?= $source ?>"/><label
                                                        for="radio<?= $rand ?>" class="css-label radGroup<?= $rand ?>"> </label>


                                            <?php }
                                            else { ?>


                                                <input type="checkbox" checked name="countries[]" id="radio<?= $rand ?>" class="css-checkbox" value="<?= $source ?>"/><label
                                                        for="radio<?= $rand ?>" class="css-label radGroup<?= $rand ?>"> </label>


                                            <?php }

                                        }
                                        else {//there is no cookie
                                            ?>

                                            <input type="checkbox" checked name="countries[]" id="radio<?= $rand ?>" class="css-checkbox" value="<?= $source ?>"/><label
                                                    for="radio<?= $rand ?>" class="css-label radGroup<?= $rand ?>"> </label>


                                        <?php }

                                    }//not logged
                                    ?>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                    <input type="submit"  name="Enregistrer" value=" kayıt etmek ">

                </div>
            </div>
            </form>
          </div>
  </div>
     <?php 

            if(isset($_POST['Enregistrer'])&&isset($_POST['countries'])){ 
              if($log){
                $GLOBALS['nb_sources_not_checked']=v4Utilisteurs::nbSourcesunCheckedWithoutCCountry($email,$pays);
                $req=$utilisateur->get_sources_of_country($_GET['country']);  
                foreach($req as $sources){ //reuters
                $currentSource=$sources["source"];
                    if( !in_array($currentSource, $_POST['countries']) ){//unch 
                       $GLOBALS['nb_sources_not_checked']+=v4Utilisteurs::nb_rss_of_CountryAndSource($pays,$currentSource);
                     } 
                } 
              }else{//not logged
                 if(isset($_COOKIE['turkish_sources'])){ 
                    $GLOBALS['nb_sources_not_checked']=count($data);
                     $allids= v4Utilisteurs::get_ids_of_country($pays); 
                      foreach($allids as $value){  
                        if(in_array($value['id'], $data)){
                          $GLOBALS['nb_sources_not_checked']--;
                        }
                      }//for 3
                      $sql=$utilisateur->get_sources_of_country($_GET['country']);  
                        foreach($sql as $tmpsources){ //reuters
                        $ss=$tmpsources["source"];
                            if( !in_array($ss, $_POST['countries']) ){//unch 
                  $GLOBALS['nb_sources_not_checked']+=v4Utilisteurs::nb_rss_of_CountryAndSource($pays,$ss);
                             } 
                        } 
                 }else{
                  $GLOBALS['nb_sources_not_checked']=0;
                 }
              }
              $nb_rss_sources=utilisateursModel::get_nb_rss_source();
              $GLOBALS['nb_sources_not_checked']=$nb_rss_sources-$GLOBALS['nb_sources_not_checked'];  
                if($GLOBALS['nb_sources_not_checked']>=5){//ok we can continue  
                $req=$utilisateur->get_sources_of_country($_GET['country']);  
                foreach($req as $sources){ //reuters 
                   $currentSource=$sources["source"]; 
                     if( !in_array( $currentSource, $_POST['countries']) ){ //source un checked  
                        $allids=v4Utilisteurs::get_ids_of_source($pays,$currentSource); 
                            foreach($allids as $row){  
                              $id=$row['id']; 
                              if($log==true){ 
                                   $emaill=utilisateursModel::check_source($email,$id);
                                   if($emaill==null){ 
                                   utilisateursModel::add_user_sources($email,$id); 
                                   }
                              } else { //not logged 
                                if(isset($_COOKIE['turkish_sources'])){ 
                                      if(!in_array($id, $data)){ 
                                           array_push($data,$id); 
                                      }    
                                }else{//there is no cookie
                                  array_push($notchecked, $id); 
                                }
                            }//not logged 
                            }//ids  
                      }else{//country checked 
                          $allids=v4Utilisteurs::get_ids_of_source($pays,$currentSource); 
                          foreach($allids as $row){  
                            $id=$row['id'];
                              if($log==true){ 
                                  $emaill=utilisateursModel::check_source($email,$id);
                                  if($emaill!=null){  
                                    utilisateursModel::delete_user_sources($email,$id);
                                  }
                              } else { //not logged 
                                if(isset($_COOKIE['turkish_sources'])){ 
                                  if(in_array($id, $data)){ 
                                     unset($data[array_search($id,$data,true)]);  
                                  }   
                                } 
                              }//not logged
                          }//ids 
                      }//country checked
                  }//foreach countries
                  if($log==false){
                      if(isset($_COOKIE['turkish_sources'])){
                      setcookie('turkish_sources', json_encode($data),time()+31556926 ,'/');
                    }else{
                      setcookie('turkish_sources', json_encode($notchecked),time()+31556926 ,'/'); 
                    }
                  }

                  ?>
    <script>  
       location.href="favorite_sources.php?country=<?php echo $pays; ?>";
    </script>  
                  <?php 
              }else{//not ok 
                echo "<script> alert('En az beş kaynağa uymalısınız'); </script>";
              }   
 
            }else if(isset($_POST['Enregistrer'])&&!isset($_POST['countries'])){//all not checked
              if($log){
                $GLOBALS['nb_sources_not_checked']=v4Utilisteurs::nbSourcesunCheckedWithoutCCountry($email,$pays);
                $req=$utilisateur->get_sources_of_country($_GET['country']);  
                foreach($req as $sources){ //reuters
                $currentSource=$sources["source"];
                   // if( !in_array($currentSource, $_POST['countries']) ){//unch 
                       $GLOBALS['nb_sources_not_checked']+=v4Utilisteurs::nb_rss_of_CountryAndSource($pays,$currentSource);
                    // } 
                } 
              }else{//not logged
                 if(isset($_COOKIE['turkish_sources'])){ 
                    $GLOBALS['nb_sources_not_checked']=count($data);
                     $allids= v4Utilisteurs::get_ids_of_country($pays); 
                      foreach($allids as $value){  
                        if(in_array($value['id'], $data)){
                          $GLOBALS['nb_sources_not_checked']--;
                        }
                      }//for 3
                      $sql=$utilisateur->get_sources_of_country($_GET['country']);  
                        foreach($sql as $tmpsources){ //reuters
                        $ss=$tmpsources["source"];
                           // if( !in_array($ss, $_POST['countries']) ){//unch 
                  $GLOBALS['nb_sources_not_checked']+=v4Utilisteurs::nb_rss_of_CountryAndSource($pays,$ss);
                             //} 
                        } 
                 }else{
                  $GLOBALS['nb_sources_not_checked']=0;
                 }
              }
              $nb_rss_sources=utilisateursModel::get_nb_rss_source();
              $GLOBALS['nb_sources_not_checked']=$nb_rss_sources-$GLOBALS['nb_sources_not_checked'];  
                if($GLOBALS['nb_sources_not_checked']>=5){//ok we can continue 

                   $req=$utilisateur->get_sources_of_country($_GET['country']);  
                foreach($req as $sources){ //reuters 
                   $currentSource=$sources["source"];   
                        $allids=v4Utilisteurs::get_ids_of_source($pays,$currentSource); 
                            foreach($allids as $row){  
                              $id=$row['id']; 
                              if($log==true){ 
                                   $emaill=utilisateursModel::check_source($email,$id);
                                   if($emaill==null){ 
                                   utilisateursModel::add_user_sources($email,$id); 
                                   } 
                              } else { //not logged 
                                if(isset($_COOKIE['turkish_sources'])){ 
                                      if(!in_array($id, $data)){ 
                                           array_push($data,$id); 
                                      }    
                                }else{//there is no cookie
                                  array_push($notchecked, $id); 
                                }
                            }//not logged 
                            }//ids   

                  }//foreach countries
                  if($log==false){
                      if(isset($_COOKIE['turkish_sources'])){
                      setcookie('turkish_sources', json_encode($data),time()+31556926 ,'/');
                    }else{
                      setcookie('turkish_sources', json_encode($notchecked),time()+31556926 ,'/'); 
                    }
                  } 
                  ?>
    <script>  
       location.href="favorite_sources.php?country=<?php echo $pays; ?>";
    </script>  
     <?php   
      }else{  echo "<script> alert('En az beş kaynağa uymalısınız'); </script>";    } 
        
      } //all not checked  
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

