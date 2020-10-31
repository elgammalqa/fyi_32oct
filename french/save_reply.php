<?php
session_start();
ob_start();

require_once('models/utilisateurs.model.php');
require_once('timee.php');
include 'fyipanel/models/news_published.model.php';
if (utilisateursModel::islogged())
    $log = true;
else $log = false;
?>
<!DOCTYPE html>
<html>
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
    <!-- Custom style -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="stylesheet" href="../css/skins/all.css">
    <link rel="stylesheet" href="../css/demo.css">
    <style type="text/css">


       h2, h3{text-align: center !important;}

    </style>
</head>

<body class="skin-orange">
<?php require_once("header.php");
if (isset($_POST['news_id']) && !empty($_POST['news_id']) && isset($_POST['rank']) && ($_POST['rank'] == 1 || $_POST['rank'] == 2)) {
    $news_id = (int)$_POST['news_id'];
    $rank = (int)$_POST['rank'];

    $p_model = new news_publishedModel();
    $row = $p_model->get_news_item($news_id);


    if (is_array($row)) {
        ?>
        <section class="category">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">

                        <?php

                        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                        if ($log == false) {

                            $_SESSION['reply_url'] = $actual_link;
                            ?>
                            <script>
                                window.location.replace('login.php');
                            </script>
                        <?php }

                        else {

                            include("fyipanel/views/connect.php");

                        if ($log && $_SERVER['REQUEST_METHOD'] == 'POST') {
                                function filter_text($x)
                                {
                                    $a = trim($x);
                                    $a = htmlspecialchars(strip_tags($a), ENT_QUOTES);
                                    $a = str_ireplace('include', 'inc_lude', $a);
                                    $a = str_ireplace('require', 'req_uire', $a);
                                    $a = str_ireplace('cmd=', '_', $a);
                                    $a = str_ireplace('--', '_', $a);
                                    $a = str_ireplace('union', '_', $a);
                                    $a = str_ireplace('.php', '_php', $a);
                                    $a = str_ireplace('.js', '_js', $a);
                                    $a = str_ireplace('truncate', 'tru__ate', $a);
                                    $a = str_ireplace('empty', 'em__y', $a);
                                    $a = str_ireplace('alter', 'alt_', $a);
                                    $a = str_ireplace('drop', 'dr__', $a);
                                    return $a;
                                }

                                $reply_to = filter_text($_POST['reply_to']);
                                $title = filter_text($_POST['title']);
                                $phone = filter_text($_POST['phone']);
                                $link = filter_text($_POST['link']);
                                $message_to_admin = filter_text($_POST['message_to_admin']);
                                $reply = htmlspecialchars($_POST['myTextField2'], ENT_QUOTES);
                                $main_image_upload = false;
                                $user_image_upload = false;
                                $reply_image_name = '';
                                $user_image_name = '';
                                switch ($rank) {
                                    case '1':
                                        $tbl = 'news';
                                        break;
                                    case '2':
                                        $tbl = 'rss';
                                        break;
                                }
                                //$domain = 'http://127.0.0.1/fyi/';
                                $domain = 'https://www.fyipress.net/';

                                //echo $reply_to.' - '.$title.' - '.$phone.' - '.$link.' - '.$message_to_admin.' - '.$news_id.' - '.$reply.' - '.$rank; exit;

                                if (!empty($_FILES['file-3']['name'])) {

                                    $allowed_image_extension = array(
                                        "png",
                                        "jpg",
                                        "jpeg"
                                    );

                                    $file_extension = pathinfo($_FILES["file-3"]["name"], PATHINFO_EXTENSION);

                                    if (!in_array($file_extension, $allowed_image_extension)) {
                                        echo 'Extensions autorisées jpg,jpeg and png';
                                        exit;
                                    } else {
                                        $maxsize = utilisateursModel::info("maxsizecomments");
                                        if (ceil($_FILES['file-3']['size'] / 1048576) > $maxsize) {
                                            echo 'S\'il vous plaît télécharger des images en petite taille';
                                            exit;
                                        } else {
                                            $target_dir = "fyipanel/views/image_news/";
                                            $reply_image_name = time() . mt_rand(1111, 9999) . '.' . $file_extension;
                                            $reply_image_full_link = $domain . 'images/rss_comments/' . $reply_image_name;
                                            $target_file = $target_dir . $reply_image_name;
                                            if (move_uploaded_file($_FILES["file-3"]["tmp_name"], $target_file)) {
                                                $main_image_upload = true;
                                            } else {
                                                echo 'Erreur lors du téléchargement! Veuillez réessa';
                                            }

                                        }

                                    }

                                }

                                if (!empty($_FILES['file-4']['name'])) {
                                    $allowed_image_extension = array(
                                        "png",
                                        "jpg",
                                        "jpeg"
                                    );

                                    $file_extension = pathinfo($_FILES["file-4"]["name"], PATHINFO_EXTENSION);

                                    if (!in_array($file_extension, $allowed_image_extension)) {
                                        echo 'Extensions autorisées jpg,jpeg and png ';
                                        exit;
                                    } else {
                                        $maxsize = utilisateursModel::info("maxsizecomments");
                                        if (ceil($_FILES['file-4']['size'] / 1048576) > $maxsize) {
                                            echo 'S\'il vous plaît télécharger des images en petite taille';
                                            exit;
                                        } else {
                                            $target_dir = "fyipanel/views/image_news/";
                                            $user_image_name = time() . mt_rand(11111, 99999) . '.' . $file_extension;
                                            $user_image_full_link = $domain . 'images/rss_comments/' . $user_image_name;
                                            $target_file = $target_dir . $user_image_name;
                                            if (move_uploaded_file($_FILES["file-4"]["tmp_name"], $target_file)) {
                                                $user_image_upload = true;
                                            } else {
                                                echo 'Erreur lors du téléchargement! Veuillez réessa';
                                            }

                                        }

                                    }


                                }

                                if ($reply_to == 'something_else') {

                                    if ($link == '') {
                                        $exec_q = false;
                                    } else {
                                        $exec_q = true;
                                    }
                                } else {
                                    $exec_q = true;
                                }

                                if ($exec_q){
                                    $created_at = date("Y-m-d H:i:s");

                                    $stmt = $con->prepare("insert into rss_right_of_reply (news_id, user_email, reply_title, user_image, uploaded_image, created_at, user_phone, message_to_mentor, reply, reply_to_link, tbl) values
                    (:news_id, :email, :reply_title, :user_image, :uploaded_image, :created_at, :user_phone, :message_to_mentor, :reply, :reply_to_link, :tbl)");
                                    $stmt->bindParam(':news_id', $news_id);
                                    $stmt->bindParam(':email', $user_email);
                                    $stmt->bindParam(':reply_title', $title);
                                    $stmt->bindParam(':user_image', $user_image_name);
                                    $stmt->bindParam(':uploaded_image', $reply_image_name);
                                    $stmt->bindParam(':created_at', $created_at);
                                    $stmt->bindParam(':user_phone', $phone);
                                    $stmt->bindParam(':message_to_mentor', $message_to_admin);
                                    $stmt->bindParam(':reply', $reply);
                                    $stmt->bindParam(':reply_to_link', $link);
                                    $stmt->bindParam(':tbl', $tbl);
                                    if ($stmt->execute()){
                                    ?>
                                        <div class="row" style="margin-top: 80px;">
                                            <div class="col-xs-12 text-center">
                                                <h2>Succès</h2>
                                                <h3>La réponse sera publiée après avoir été passée en revue</h3>
                                                <h3>Meilleures salutations</h3>
                                                <h3>Equipe FYIPress</h3>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    else {
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <h2>Erreur</h2>
                                                <h3>Veuillez réessayer</h3>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }

                            }


                        }//log
                        //}
                        ?>


                    </div>
                </div>
            </div>
        </section>


    <?php
    }
    else{
    ?>
        <script>
            window.location.replace('404.php');
        </script>
        <?php
        exit;
    }
}

?>

<!-- Start footer -->
<?php require_once('footer.php') ?>
<!-- End Footer -->
<!-- JS -->
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
    $(document).ready(function () {
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