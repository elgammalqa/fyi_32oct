<?php
session_start();
ob_start();

require_once('models/utilisateurs.model.php');
require_once('models/v4.utilisateurs.model.php');
if (utilisateursModel::islogged())
    $log = true;
else $log = false;
if (!isset($_GET['country']) || $_GET['country'] == "") {
    echo "<script> location.href='index.php'; </script>";
    exit;
}

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
    <link rel="icon" href="images/fyipress.ico">
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
        .source_top_row div {
            float: right;
            margin-top: 40px;
        }

        .source_top_row a {
            float: right;
            font-family: 'Droid Arabic Kufi', serif;
            width: 100%;
        }

        .source_top_row a.selected {
            background-color: #c8081c;
            border-color: #c8081c;
        }
    </style>
</head>
<?php require_once("header.php");
if (!isMobile()) echo '<br><br><br><br><br><br> ';
else echo '<br><br> '; ?>
<body>
<div class="content">

    <div class="container stats">

        <div class="row source_top_row">
            <?php
            $query = $_SERVER['PHP_SELF'];
            $path = pathinfo($query);
            $page = $path['basename'];
            ?>
            <div class="col-xs-6 col-sm-4 col-md-2">
                <a href="favorite_countries.php" class="btn btn-md btn-primary <?= (!stristr($page, 'user_')) ? 'selected' : ''; ?>">جميع الدول</a>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-2">
                <a href="user_favorite_countries.php" class="btn btn-md btn-primary <?= (stristr($page, 'user_')) ? 'selected' : ''; ?>">مصادري</a>
            </div>
        </div>

        <h1 style="text-align: right;"> اختر المصدر </h1>
        <!--<br>
        <input type="checkbox" id="checkAll">Check All-->
        <hr>
    </div>
    <div class="container container-fluid">
        <form method="post">
            <div class="row">
                <?php
                $utilisateur = new utilisateursModel();
                $req = $utilisateur->get_sources_of_country($_GET['country']);

                $pays = $_GET['country'];
                $notchecked = array();
                foreach ($req as $country) {
                    $source = $country["source"];


                if ($log == true){ //logged
                    if (isset($_COOKIE['fyiuser_email'])) {
                        $email = $_COOKIE['fyiuser_email'];
                    } else if (isset($_SESSION['user_auth']['user_email'])) {
                        $email = $_SESSION['user_auth']['user_email'];
                    }
                    $user_row = $utilisateur->get_user_by_email($email);

                    $nb=v4Utilisteurs::check_user_source_notif($user_row['user_id'],$pays,$source);

                    if($nb==0){
                        $selected = false; }
                    else{
                        $selected = true;
                    }
                }
                

                //if($selected){
                ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="card card-stats">
                            <div class="card-header card-header-default card-header-icon  ">
                                <div class="card-icon">
                                    <a href="#">
                                        <img src="../v2/sources/<?php echo $source; ?>.png" width="80px" alt="" srcset="">
                                    </a>
                                </div>
                                <h5 class="h5">
                                    <a href="#">
                                        <?php echo $source; ?></a>
                                </h5>
                            </div>
                            <div class="card-footer">
                                <div class="stats">

                                    <label class="containers"> متابعة
                                        <?php
                                        if ($log == true) { //logged
                                            if (isset($_COOKIE['fyiuser_email'])) {
                                                $email = $_COOKIE['fyiuser_email'];
                                            } else if (isset($_SESSION['user_auth']['user_email'])) {
                                                $email = $_SESSION['user_auth']['user_email'];
                                            }
                                            //$nb = v4Utilisteurs::check_sourcesOfCountry($email, $pays, $source);

                                            //if ($nb == 0) {
                                                ?>
                                                <input type="checkbox" <?=($nb == 1) ? 'checked' : '';?> name="countries[]" value="<?php echo $source; ?>" class="checkItem">
                                                <span class="checkmark"></span>
                                            <?php
                                            //}

                                        }

                                        ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    //}


                    ?>

                <?php } ?>
            </div>
            <input type="submit" class="green" name="Enregistrer" value=" حفظ " style="font-size: 26px; margin-right: 60px;">
        </form>
    </div>
</div>
<?php

if (isset($_POST['Enregistrer']) && isset($_POST['countries'])) {
    if ($log) {
        $country = htmlspecialchars(strip_tags($_GET['country']));
        $selected_sources = $_POST['countries'];

        $user_id = $user_row['user_id'];
        v4Utilisteurs::delete_user_notif_all_country_sources($country, $user_id);
        foreach ($selected_sources as $src){
            v4Utilisteurs::add_user_notif_source($country, $src, $user_id);
        }
        ?>
        <script>
            location.href = "user_favorite_sources.php?country=<?php echo $pays; ?>";
        </script>
        <?php
    }
    else{
        die('ffff');
    }

}

elseif (isset($_POST['Enregistrer']) && !isset($_POST['countries'])) {
    $country = $pays;
    //$all_country_sources = v4Utilisteurs::get_country_unique_sources($country);
    $user_id = $user_row['user_id'];
        v4Utilisteurs::delete_user_notif_all_country_sources($country, $user_id);
    /*foreach($all_country_sources as $src){
        v4Utilisteurs::delete_user_notif_all_country_sources($country, $src['source'], $user_id);
    }*/
        ?>
    <script>  location.href="user_favorite_sources.php?country=<?=$country?>";  </script>
    <?php
}
?>
<br><br><br><br>
<!-- Start footer -->
<?php require_once('footer.php') ?>
<!-- End Footer -->

<!-- JS -->

<script src="../js/jquery.js"></script>
<script src="../js/jquery.migrate.js"></script>
<script src="../scripts/bootstrap/bootstrap.min.js"></script>
<script>var $target_end = $(".best-of-the-week");</script>
<script src="../scripts/jquery-number/jquery.number.min.js"></script>
<script src="../scripts/owlcarousel/dist/owl.carousel.min.js"></script>
<script src="../scripts/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="../scripts/easescroll/jquery.easeScroll.js"></script>
<script src="../scripts/sweetalert/dist/sweetalert.min.js"></script>
<script src="../scripts/toast/jquery.toast.min.js"></script>
<script src="../js/e-magz.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        /*$("#checkAll").click(function(){
            $(':checkbox.checkItem').prop('checked', this.checked);
        });*/

        $('.backk').click(function () {
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

