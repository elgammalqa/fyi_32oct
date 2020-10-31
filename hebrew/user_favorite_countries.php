<?php
session_start();
ob_start();
require_once('models/utilisateurs.model.php');
require_once('models/v4.utilisateurs.model.php');
if(utilisateursModel::islogged())
    $log=true;
else $log=false;

if(!$log){
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    $_SESSION['reply_url'] = $actual_link;
    ?>
    <script> window.location = "login.php"; </script><?php
    exit;
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
        .source_top_row div{float: right; margin-top: 40px;}
        .source_top_row a{
            float: right;  width: 100%;
        }
        .source_top_row a.selected{background-color: #c8081c;
            border-color: #c8081c; }

        .fav_source_image {
            float: right;
            margin-right: 5px;
            max-width: 60px;
        }

        h5{margin-top: 0 !important;
            padding: 10px 0 !important;}

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
        h6{ font-size: 14px; text-align: right}

        .source_row{margin-top: 10px; margin-bottom: 15px;}

        .source_row img{max-width: 40px; max-height: 40px;}

        .card [class*="card-header-"]{margin: 0px 15px 5px;}

        .card-header.card-header-default.card-header-icon h5 a{}

        input[type=submit] {
            width: 100px !important; height: 35px; border: 0;  line-height: 0;
             font-size: 14px; margin-bottom: 20px;
            color: #fff ;
            padding: 20px ;
            background: #fe0002 ;
        }
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
            <a href="favorite_countries.php" class="btn btn-md btn-primary <?=(!stristr($page,'user_')) ? 'selected' : '';?>">כל המדינות</a>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-2">
            <a href="user_favorite_countries.php" class="btn btn-md btn-primary <?=(stristr($page,'user_')) ? 'selected' : '';?>">המקורות שלי</a>
        </div>
    </div>

    <div class="container stats" style="display: none"><br><h1 style="text-align: right;"  >   רשימת מדינות</h1><hr></div>
    <div class="container-fluid">

        <form method="post" action="">
            <div class="row">
                <?php
                $utilisateur=new utilisateursModel();
                $req=$utilisateur->get_countries();

                if($log){ //logged
                    if(isset($_COOKIE['fyiuser_email'])){
                        $email=$_COOKIE['fyiuser_email'];
                    }
                    else if(isset($_SESSION['user_auth']['user_email'])){
                        $email=$_SESSION['user_auth']['user_email'];

                    }
                    $user_row = $utilisateur->get_user_by_email($email);
                }

                $notchecked=array();
                foreach($req as $country){
                    $c=$country['country'];

                        ?>
                        <div class="col-xs-12 col-md-7 col-md-push-3">
                            <div class="card card-stats">
                                <div class="card-header card-header-default card-header-icon">
                                    <div class="card-icon">
                                        <a href="#" onclick="return false">
                                            <img src="../v2/countries/<?php echo $c; ?>.png" width="80px" alt="" srcset="">
                                        </a>
                                    </div>
                                    <h5 class="h5" >
                                        <a  href="#" onclick="return false">
                                            <?php echo strtolower($c); ?>
                                        </a>
                                    </h5>
                                </div>
                                <div class="card-footer">
                                    <?php
                                    $c_sources = $utilisateur->get_sources_of_country($c);
                                    foreach ($c_sources as $country) {
                                        $source_row = $utilisateur->get_source_row($country["source"]);
                                        //$source_tw = $utilisateur->get_source_twitter($country["source"]);
                                        //if(is_array($source_tw)){
                                            //if(count($source_tw) > 0 && isset($source_tw['twitter'])){
                                                $source = $country["source"];
                                                $rand = mt_rand(11111, 99999);
                                                //echo $c.' - '.$source.'<br>';
                                                $nb=v4Utilisteurs::check_user_source_notif($user_row['user_id'],$c,$source);
                                                if($nb==0){
                                                    $selected = false;
                                                }
                                                else{
                                                    $selected = true;
                                                }
                                                ?>
                                                <div class="row source_row">

                                                    <div class="col-xs-3 col-md-push-1">
                                                        <input type="checkbox" <?=($nb == 1) ? 'checked' : '';?> name="countries[]" id="radio<?= $rand ?>" class="css-checkbox"
                                                               value="<?=$c.','.$source?>"/><label
                                                                for="radio<?= $rand ?>" class="css-label radGroup<?= $rand ?>"> </label>
                                                    </div>
                                                    <div class="col-xs-5">
                                                        <h6>
                                                            <?php echo $source; ?>
                                                        </h6>
                                                    </div>
                                                    <div class="col-xs-3 col-md-2 col-md-push-1">
                                                        <img src="../v2/sources/<?php echo $source; ?>.png" alt="" class="img-responsive">
                                                    </div>

                                                </div>

                                                <?php
                                            //}

                                        //}


                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    //}

                    ?>

                <?php }  //for  ?>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <input type="submit"  name="Enregistrer" value=" שמור ">
                </div>
            </div>
        </form>
    </div>
</div>
<?php
require '../fcm/WebFCMToTopic.php';

if (isset($_POST['Enregistrer']) && isset($_POST['countries'])) {
if ($log) {
    $token = $_COOKIE['tk'];
    $all_user_sources = v4Utilisteurs::get_all_user_notif_sources($user_row['user_id']);
    /*echo '<pre>';
    print_r($all_sources);
    echo '</pre>';*/
    foreach ($all_user_sources as $source) {
        $topic = 'he-' . str_replace(' ', '__', $source['country']) . '-' . str_replace(' ', '__', $source['source']);
        $fcm = new WebFCMToTopic();
        $fcm->unsubscribe($token, $topic);
    }


    $selected_sources = $_POST['countries'];
    //print_r($selected_sources); exit;
    $countries = array();
    foreach ($selected_sources as $src) {
        $new_src = explode(',', $src);
        $country = $new_src[0];
        if (!in_array($country, $countries)) {
            $countries[] = $country;
        }
        unset($new_src);
    }
    //print_r($countries); exit;

    $user_id = $user_row['user_id'];
    //foreach ($countries as $item){
    //v4Utilisteurs::delete_user_notif_all_country_sources($item, $user_id);
    v4Utilisteurs::delete_user_all_notif($user_id);
    //}

    foreach ($selected_sources as $src) {
        $new_src = explode(',', $src);
        $country = $new_src[0];
        $source = $new_src[1];
        v4Utilisteurs::add_user_notif_source($country, $source, $user_id);
        $topic = 'he-' . str_replace(' ', '__', $country) . '-' . str_replace(' ', '__', $source);
        $fcm = new WebFCMToTopic();
        $fcm->subscribe($token, $topic);
    }
    ?>
    <script>
        location.href = "user_favorite_countries.php";
    </script>
<?php
}
else {
    die('');
}

}

elseif (isset($_POST['Enregistrer']) && !isset($_POST['countries'])) {
$token = $_COOKIE['tk'];
$all_user_sources = v4Utilisteurs::get_all_user_notif_sources($user_row['user_id']);
foreach ($all_user_sources as $source) {
    $topic = 'he-' . str_replace(' ', '__', $source['country']) . '-' . str_replace(' ', '__', $source['source']);
    $fcm = new WebFCMToTopic();
    $fcm->unsubscribe($token, $topic);
}
$user_id = $user_row['user_id'];
v4Utilisteurs::delete_user_all_notif($user_id);
?>
    <script>  location.href = "user_favorite_countries.php";  </script>
    <?php
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

