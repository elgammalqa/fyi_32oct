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
    <!-- Custom style -->
    <link rel="stylesheet" href="../css/style_ar.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="stylesheet" href="../css/skins/all.css">
    <link rel="stylesheet" href="../css/demo.css">
    <style type="text/css">
        @media only screen and (min-width: 992px) {
            #ptop {
                padding-top: 3%;
            }

        }

        .float_right {
            float: right !important;
            text-align: right;
            font-family: 'Droid Arabic Kufi', serif;
            letter-spacing: 0px;
        }

        /* v5 */
        .float_rightt {
            font-weight: 800;
            font-family: 'Raleway';
            text-align: right;
            font-size: 20px;
        }

        .float_rightp {
            text-align: right;
            font-family: 'Droid Arabic Kufi', serif;
            letter-spacing: 0px;
        }

        .float_rightd {
            text-align: right;
            font-family: 'Droid Arabic Kufi', serif;
            letter-spacing: 0px;
            font-size: 18px;
        }

        /* /v5 */
        .float_left {
            float: left !important;
            text-align: left;
        }

        .fs_cat {
            font-size: 20px;
            font-family: 'Droid Arabic Kufi', serif;
            letter-spacing: 0px;
        }

        @media only screen and (min-width: 500px) {
            .mar_right {
                margin-right: 315px !important;
                margin-left: 0px !important
            }
        }

        input[type=radio].css-checkbox {
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

        input[type=radio].css-checkbox + label.css-label {
            padding-right: 35px;
            height: 30px;
            display: inline-block;
            line-height: 30px;
            background-repeat: no-repeat;
            background-position: 130px 0;
            vertical-align: middle;
            cursor: pointer;
        }

        input[type=radio].css-checkbox:checked + label.css-label {
            background-position: 130px -30px;
            font-weight: bold;
        }

        label.css-label {
            font-weight: bold;
            background-image: url('../images/check.png');
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        #file-4, #file-3 {
            display: none
        }

        p, label, div, input {
            text-align: right;
            direction: rtl;
            font-family: 'Droid Arabic Kufi', serif
        }

        form p, form label, form div, form input {
            font-size: 13px;
        }

        #link {
            display: none
        }

        .box {
            background: #00aff0;
            margin-top: 15px;
            border: 2px solid #000
        }

        form {
            background: #000;
            float: right;
            width: 100%;
            height: 100%;
        }

        .row.checkboxes, .row.formdata {
            background: #fff;
            padding-top: 20px;
            padding-bottom: 10px;
            margin: 15px 0;
        }

        .form-group label {
            font-weight: bold;
        }

        .row.formdata label {
            width: 22%;
        }

        .row.formdata input.form-control {
            width: 78%;
            float: left;
            border: 2px solid #000
        }

        input[type=submit] {
            width: 10% !important;
            position: absolute;
            left: 20px;
            top: 45px;
            font-weight: bold !important;
            color: #fff !important;
            font-size: 20px !important;
            padding: 20px !important;
            line-height: 7px !important;
            background: #fe0002 !important;
        }

        span.required {
            font-size: 18px !important;
        }

        .box label {
            width: 100% !important;
            text-align: center;
            line-height: 25px;
            /* padding-bottom: 0; */
            margin-top: 5px;
        }

        .right_of_reply_hint {
            margin-bottom: 15px;
            display: block;
            color: red;
            line-height: 22px;
            padding: 10px;
            font-size: 16px;
            text-align: center;
            line-height: 26px;
            font-weight: bold;
        }

        .hint_heading {
            font-weight: bold;
            text-align: center;
            font-size: 20px;
            width: 100%;
            float: right;
        }

        .hint_heading hr {
            width: 90%;
            float: right;
            margin: 10px 5%;
            height: 2px;
            background: red;
        }

        .row.formdata.aside {
            padding-top: 0;
        }

        .row.formdata.aside label {
            width: 100%;
        }

        .row.formdata.aside .form-control {
            width: 100%;
            border: 2px solid #000
        }

        a.display_replies_link {
            width: 100%;
            height: 40px;
            line-height: 40px;
            font-weight: bold;
            background: #00aff0;
            display: block;
            float: left;
            color: #000;
            text-align: center;
            margin-top: -3px;
            border: 2px solid #000
        }

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
        <section class="category" style="padding-top: 145px;">
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
                                echo 'הרחבות מותרות png,jpg,jpeg';
                                exit;
                            } else {
                                $maxsize = utilisateursModel::info("maxsizecomments");
                                if (ceil($_FILES['file-3']['size'] / 1048576) > $maxsize) {
                                    echo 'בחר תמונה קטנה יותר';
                                    exit;
                                } else {
                                    $target_dir = "fyipanel/views/image_news/";
                                    $reply_image_name = time() . mt_rand(1111, 9999) . '.' . $file_extension;
                                    $reply_image_full_link = $domain . 'arabic/images/rss_comments/' . $reply_image_name;
                                    $target_file = $target_dir . $reply_image_name;
                                    if (move_uploaded_file($_FILES["file-3"]["tmp_name"], $target_file)) {
                                        $main_image_upload = true;
                                    } else {
                                        echo 'אירעה שגיאה בהעלאת הקובץ, אנא נסה שוב';
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
                                echo 'הרחבות מותרות png,jpg,jpeg';
                                exit;
                            } else {
                                $maxsize = utilisateursModel::info("maxsizecomments");
                                if (ceil($_FILES['file-4']['size'] / 1048576) > $maxsize) {
                                    echo 'בחר תמונה קטנה יותר';
                                    exit;
                                } else {
                                    $target_dir = "fyipanel/views/image_news/";
                                    $user_image_name = time() . mt_rand(11111, 99999) . '.' . $file_extension;
                                    $user_image_full_link = $domain . 'arabic/images/rss_comments/' . $user_image_name;
                                    $target_file = $target_dir . $user_image_name;
                                    if (move_uploaded_file($_FILES["file-4"]["tmp_name"], $target_file)) {
                                        $user_image_upload = true;
                                    } else {
                                        echo 'אירעה שגיאה בהעלאת הקובץ, אנא נסה שוב';
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
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <h2>בוצע</h2>
                                                <h3>הוא יפורסם ברגע שייבדק</h3>
                                                <h3>בברכה</h3>
                                                <h3>צוות FYIPress</h3>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    else {
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-12 text-center">
                                                <h2>משהו השתבש</h2>
                                                <h3>אנא נסה שוב</h3>
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