<?php 
session_start();   
ob_start();  
require_once('models/utilisateurs.model.php'); 
require_once('models/v4.utilisateurs.model.php');
if(utilisateursModel::islogged())
$log=true;  
else $log=false;   
  
if(!isset($_GET['country'])||$_GET['country']==""||!isset($_GET['source'])||$_GET['source']==""){
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
  </head>    
     <?php require_once ("header.php");  
     if(!isMobile()) echo '<br><br><br><br><br><br> ';
     else echo '<br><br> '; ?>
  <body>

  <div class="content">
    <div class="container stats">
      <br> 
      <h1> choisissez vos types préférés : </h1> <hr>
    </div> 
    <div class="container-fluid" style=" padding-left: 8% !important; padding-right: 10% !important; "  > 
  <form method="post"  >
      <div class="row"> 
        <?php  
        $utilisateur=new utilisateursModel();   
        $pays=$_GET['country'];
        $source=$_GET['source'];
        $req=$utilisateur->get_types_of_country_and_source($pays,$source); 
        $i=0;
        $notchecked=array();
        foreach($req as $country){ ?> 
          <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <div class="card card-stats">
              <div class="card-header card-header-default card-header-icon">
                <div class="card-icon"> 
                  <img src="../v2/types/<?php echo $country['type']; ?>.png" width="80px" alt="" srcset=""> 
                </div>
                <h5 style="text-align: right;" >
                 <?php echo $country['type']; ?>
               </h5>  
             </div>  
             <div class="card-footer">
              <div class="stats">
               <label class="containers">S'abonner  
                 <?php    
                 $id=utilisateursModel::get_id_rss_source($pays,$source,$country['type']);
             if($log==true){//logged 
              if(isset($_COOKIE['fyiuser_email'])){
                $email=$_COOKIE['fyiuser_email'];
              }else if(isset($_SESSION['user_auth']['user_email'])){
                $email=$_SESSION['user_auth']['user_email'];
              }
              $emaill=utilisateursModel::check_source($email,$id); 
              if($emaill!=null){  ?>
               <input type="checkbox"  name="typee[]" value="<?php echo $country['type']; ?>" >
               <span class="checkmark"></span>
             <?php }else{ ?>
              <input type="checkbox"  checked name="typee[]" value="<?php echo $country['type']; ?>" >
              <span class="checkmark"></span>
            <?php } 
              }else{//not logged 
                if(isset($_COOKIE['french_sources'])){
                  $data = json_decode($_COOKIE['french_sources'], true); 
                  $exist=false;
                  foreach ($data as $key => $value) {
                   if($id==$value){
                    $exist=true;
                    break;
                  }
                } 
                if($exist==true){ ?>
                  <input type="checkbox"  name="typee[]" value="<?php echo $country['type']; ?>" >
                  <span class="checkmark"></span>
                <?php }else{ ?> 
                  <input type="checkbox"  checked name="typee[]" value="<?php echo $country['type']; ?>" >
                  <span class="checkmark"></span>
                <?php }
              }else{     ?>
                <input type="checkbox"  checked name="typee[]" value="<?php echo $country['type']; ?>" >
                <span class="checkmark"></span>
              <?php }  } ?>  
          </label> 
        </div>
      </div>    
    </div>
  </div>   
<?php }  ?> 
</div>
<input type="submit" class="green" name="Enregistrer" value="Enregistrer" style="font-size: 26px; margin-right: 60px; " >
</form>  
<br><br>
</div></div>  
      <?php  
      if(isset($_POST['Enregistrer'])&&isset($_POST['typee'])){
        if($log){
             $GLOBALS['nb_sources_not_checked']=v4Utilisteurs::nbSourcesunCheckedWithoutCSources($email,$source);
            $req=$utilisateur->get_types_of_country_and_source($pays,$source);  
            foreach($req as $types){ //news
             $currentType=$types["type"];
                if( !in_array($currentType, $_POST['typee']) ){//unch 
                   $GLOBALS['nb_sources_not_checked']++;
                 } 
            }
        }else{ //not logged
           if(isset($_COOKIE['french_sources'])){ 
                    $GLOBALS['nb_sources_not_checked']=count($data);
                    $allids=v4Utilisteurs::get_ids_of_source($pays,$source); 
                      foreach($allids as $value){  
                        if(in_array($value['id'], $data)){
                          $GLOBALS['nb_sources_not_checked']--;
                        }
                      }//for 3
                      $req=$utilisateur->get_types_of_country_and_source($pays,$source);  
                        foreach($req as $types){ //news
                            $currentType=$types["type"];
                            if( !in_array($currentType, $_POST['typee']) ){//unch 
                               $GLOBALS['nb_sources_not_checked']++;
                             } 
                        }//for  
            }else{
                  $GLOBALS['nb_sources_not_checked']=0;
            }
        }
            $nb_rss_sources=utilisateursModel::get_nb_rss_source(); 
            $GLOBALS['nb_sources_not_checked']=$nb_rss_sources-$GLOBALS['nb_sources_not_checked']; 
 
            if($GLOBALS['nb_sources_not_checked']>=5){//ok we can continue

                $req=$utilisateur->get_types_of_country_and_source($pays,$source);  
                foreach($req as $types){ //news 
                   $currentType=$types["type"]; 
                      $id=utilisateursModel::get_id_rss_source($pays,$source,$currentType);  
                     if( !in_array( $currentType, $_POST['typee']) ){ //type un checked 
                            if($log==true){ 
                                   $emaill=utilisateursModel::check_source($email,$id);
                                   if($emaill==null){ 
                                   utilisateursModel::add_user_sources($email,$id); 
                                   }
                              } else { //not logged 
                                if(isset($_COOKIE['french_sources'])){ 
                                      if(!in_array($id, $data)){ 
                                           array_push($data,$id); 
                                      }    
                                }else{//there is no cookie
                                  array_push($notchecked, $id); 
                                } 
                            }//not logged  
                      }else{//country checked   
                              if($log==true){ 
                                  $emaill=utilisateursModel::check_source($email,$id);
                                  if($emaill!=null){  
                                    utilisateursModel::delete_user_sources($email,$id);
                                  }
                              } else { //not logged 
                                if(isset($_COOKIE['french_sources'])){ 
                                  if(in_array($id, $data)){ 
                                     unset($data[array_search($id,$data,true)]);  
                                  }   
                                } 
                              }//not logged 
                      }//country checked
                  }//foreach countries
                  if($log==false){
                      if(isset($_COOKIE['french_sources'])){
                      setcookie('french_sources', json_encode($data),time()+31556926 ,'/');
                    }else{
                      setcookie('french_sources', json_encode($notchecked),time()+31556926 ,'/'); 
                    }
                  }
                  ?> 
    <script>  
       location.href="favorite_types.php?country=<?php echo $pays."&source=".$source; ?>";
    </script>    
                  <?php  
              }else{//not ok 
                echo "<script> alert('Vous devez suivre au moins cinq sources'); </script>";
              }  




            }else if(isset($_POST['Enregistrer'])&&!isset($_POST['typee'])){//all not checked
               if($log){
             $GLOBALS['nb_sources_not_checked']=v4Utilisteurs::nbSourcesunCheckedWithoutCSources($email,$source);
            $req=$utilisateur->get_types_of_country_and_source($pays,$source);  
            foreach($req as $types){ //news 
                   $GLOBALS['nb_sources_not_checked']++; 
            }
        }else{ //not logged
           if(isset($_COOKIE['french_sources'])){ 
                    $GLOBALS['nb_sources_not_checked']=count($data);
                    $allids=v4Utilisteurs::get_ids_of_source($pays,$source); 
                      foreach($allids as $value){  
                        if(in_array($value['id'], $data)){
                          $GLOBALS['nb_sources_not_checked']--;
                        }
                      }//for 3
                      $req=$utilisateur->get_types_of_country_and_source($pays,$source);  
                        foreach($req as $types){ //news 
                               $GLOBALS['nb_sources_not_checked']++; 
                        }//for  
            }else{
                  $GLOBALS['nb_sources_not_checked']=0;
            }
        }
            $nb_rss_sources=utilisateursModel::get_nb_rss_source(); 
            $GLOBALS['nb_sources_not_checked']=$nb_rss_sources-$GLOBALS['nb_sources_not_checked']; 
 
            if($GLOBALS['nb_sources_not_checked']>=5){//ok we can continue

                $req=$utilisateur->get_types_of_country_and_source($pays,$source);  
                foreach($req as $types){ //news 
                   $currentType=$types["type"]; 
                      $id=utilisateursModel::get_id_rss_source($pays,$source,$currentType);   
                            if($log==true){ 
                                   $emaill=utilisateursModel::check_source($email,$id);
                                   if($emaill==null){ 
                                   utilisateursModel::add_user_sources($email,$id); 
                                   }
                              } else { //not logged 
                                if(isset($_COOKIE['french_sources'])){ 
                                      if(!in_array($id, $data)){ 
                                           array_push($data,$id); 
                                      }    
                                }else{//there is no cookie
                                  array_push($notchecked, $id); 
                                } 
                            }//not logged   
                  }//foreach countries 
                  if($log==false){
                      if(isset($_COOKIE['french_sources'])){
                      setcookie('french_sources', json_encode($data),time()+31556926 ,'/');
                    }else{
                      setcookie('french_sources', json_encode($notchecked),time()+31556926 ,'/'); 
                    }
                  }
                  ?> 
    <script>  
       location.href="favorite_types.php?country=<?php echo $pays."&source=".$source; ?>";
    </script>    
                  <?php  
              }else{//not ok 
                echo "<script> alert('Vous devez suivre au moins cinq sources'); </script>";
              }  
            }//all not checked   
             ?> 
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