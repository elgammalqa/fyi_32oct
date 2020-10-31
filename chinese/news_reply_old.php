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
        @media only screen and (min-width: 992px) {
            #ptop {
                padding-top: 3%;
            }

        }

        .float_right {
            float: left !important;
            text-align: left;
            letter-spacing: 0px;
        }

        /* v5 */
        .float_rightt {
            font-weight: 800;
            font-family: 'Raleway';
            text-align: left;
            font-size: 20px;
        }

        .float_rightp {
            text-align: left;
            font-family: 'Droid Arabic Kufi', serif;
            letter-spacing: 0px;
        }

        .float_rightd {
            text-align: left;
            letter-spacing: 0px;
            font-size: 18px;
        }

        /* /v5 */
        .float_left {
            float: right !important;
            text-align: right;
        }

        .fs_cat {
            font-size: 20px;
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
            padding-left: 35px;
            height: 30px;
            display: inline-block;
            line-height: 30px;
            background-repeat: no-repeat;
            background-position: 0 0;
            vertical-align: middle;
            cursor: pointer;
        }

        input[type=radio].css-checkbox:checked + label.css-label {
            background-position: 0 -30px;
            font-weight: bold;
        }

        label.css-label {
            font-weight: bold;
            background-image: url('images/check.png');
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
            text-align: left;
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
            float: right;
            border: 2px solid #000
        }

        input[type=submit] {
            width: 10% !important;
            position: absolute;
            right: 20px;
            top: 45px;
            font-weight: bold !important;
            color: #fff !important;
            font-size: 20px !important;
            padding: 0 !important;
            line-height: 7px !important;
            background: #fe0002 !important;
            text-align: center;
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
if (isset($_GET['news']) && !empty($_GET['news']) && isset($_GET['r']) && ($_GET['r'] == 1 || $_GET['r'] == 2)) {
    $news_id = (int)$_GET['news'];

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

                            }

                            else{

                            if ((int)$_GET['r'] == 1) {
                                $stmt = $con->prepare("select * from news_published where id = :news_id ");
                            } else {
                                $stmt = $con->prepare("select * from rss join rss_sources where rss.id = :news_id and rss.favorite = rss_sources.id");
                            }

                            $stmt->bindParam(':news_id', $news_id);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            $d = new utilisateursModel();
                            $userData = $d->userexist($user_email);

                            ?>
                                <form enctype="multipart/form-data" method="post" action="save_reply.php">

                                    <input type="hidden" name="news_id" value="<?= $news_id ?>">
                                    <input type="hidden" name="rank" value="<?= (int)$_GET['r'] ?>">

                                    <div class="col-xs-12 col-md-4" style="padding-right: 0;">
                                        <div class="row formdata aside">
    <span class="right_of_reply_hint">
    <span class="hint_heading">تنويه هام: حق الرد مكفول للجميع <hr></span>
    <br>بشرط مراعاة الآداب العامة <br>وسياسة الموقع . يوفر موقع إف واي<br> آي برس لك حق الرد على أي خبر أو<br> مقال  يتم نشره لديه .. ولكن ما يتم<br> نشره هو على مسؤولية من قام<br> بالنشر دون أي مسؤولية على إف<br> واي آي برس  </span>

                                            <div class="col-xs-12" id="date" style="margin-bottom: 15px;">
                                                <label for="date">回复发布于的新闻 :</label>
                                                <input type="text" name="date" value="<?= $row['pubDate'] ?>" disabled class="form-control">
                                            </div>

                                            <div class="col-xs-12" id="news_title" style="margin-bottom: 15px;">
                                                <label for="news_title">标题</label>
                                                <input type="text" name="news_title" value="<?= $row['title'] ?>" disabled class="form-control">
                                            </div>

                                            <?php
                                            if ((int)$_GET['r'] == 2) {
                                                ?>
                                                <div class="col-xs-12" id="source" style="margin-bottom: 15px;">
                                                    <label for="source">发行人</label>
                                                    <input type="text" name="source" value="<?= $row['source'] ?>" disabled class="form-control">
                                                </div>
                                                <?php
                                            }
                                            ?>


                                            <div class="col-xs-12" id="link" style="margin-bottom: 15px;">
                                                <label for="link"><span class="required"></span>回复此链接</label>
                                                <input type="text" name="link" value="" class="form-control">
                                            </div>

                                            <div class="col-xs-12" id="phone" style="margin-bottom: 15px;">
                                                <label for="phone">您的手机 #</label>
                                                <input type="text" name="phone" value="" class="form-control">
                                            </div>

                                            <div class="col-xs-12" id="email" style="margin-bottom: 15px;">
                                                <label for="emai">电子邮件地址</label>
                                                <input type="text" name="emai" value="<?= $d->getemail() ?>" required class="form-control" disabled>
                                            </div>

                                            <div class="col-xs-12" style="margin-bottom: 15px;">
                                                <label for="message_to_admin">给管理员的消息（未发布）</label>
                                                <textarea name="message_to_admin" id="message_to_admin" class="form-control" style="height: 190px;"></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group col-xs-12 col-md-8" style="margin-bottom: 0;">

                                        <div class="row checkboxes">

                                            <div class="col-xs-12 col-sm-3">
                                                <a href="replies.php?id=<?= $row['type'] ?>&n=1" class="display_replies_link">查看回复</a>
                                            </div>

                                            <div class="col-xs-12 col-sm-4">
                                                <input type="radio" name="reply_to" id="radio2" class="css-checkbox" value="this_news" checked/><label for="radio2"
                                                                                                                                                       class="css-label radGroup1">
                                                    回复此新闻</label>

                                            </div>

                                            <div class="col-xs-12 col-sm-4">

                                                <input type="radio" name="reply_to" id="radio1" class="css-checkbox" value="something_else"/><label for="radio1" class="css-label radGroup1">
                                                    回复其他</label>
                                            </div>

                                        </div>


                                        <div class="row formdata" style="position: relative;">

                                            <div class="col-xs-11 col-md-10" style="margin-bottom: 12px;">
                                                <label for="username"><span class="required"></span>回复标题</label>
                                                <input type="text" name="title" value="" id="title" class="form-control" required>
                                            </div>
                                            <div class="col-xs-11 col-md-10">

                                                <label for="username"><span class="required"></span>你的名字</label>
                                                <input type="text" name="username" value="<?= $d->getname() ?>" id="username" class="form-control" disabled required>
                                            </div>

                                            <input value="发送" name="send_right_of_reply" type="submit" class="btn btn-primary form-control">

                                            <div class="col-xs-6 col-md-6">
                                                <div class="box">
                                                    <input type="file" name="file-3" id="file-3" class="inputfile inputfile-3" data-multiple-caption="{count} files selected"
                                                           accept="image/png, image/jpeg"/>
                                                    <label for="file-3"><span>回复图片（可选）</span></label>
                                                </div>
                                                <div id="image-holder1"></div>
                                            </div>

                                            <div class="col-xs-6 col-md-6">
                                                <div class="box">
                                                    <input type="file" name="file-4" id="file-4" class="inputfile inputfile-4" data-multiple-caption="{count} files selected"
                                                           accept="image/png, image/jpeg"/>
                                                    <label for="file-4"><span>您的图片（可选）</span></label>
                                                </div>
                                                <div id="image-holder2"></div>
                                            </div>

                                            <div class="col-xs-12">
                                                <div class="box boxhint">
                                                    <label><span>您可以在下面的编辑器中添加图像和视频</span></label>
                                                </div>
                                            </div>

                                            <div class="col-xs-12" style="margin-top: 25px;">
                                                <label for="myTextField2">回复</label>
                                                <textarea id="myTextField2" class="form-control" name="myTextField2"
                                                ></textarea>
                                            </div>

                                        </div>

                                    </div>

                                </form>
                                <?php



                            }

                        }//log
                        //}
                        ?>


                    </div>
                </div>
            </div>
        </section>

        <script src="../js/jquery.js"></script>
        <script src="../tinymce/tinymce.min.js"></script>
        <script>tinymce.init({
                selector: '#myTextField2',
                language: 'zh_CN',
                directionality: 'ltr',
                language_url: '../tinymce/langs/zh_CN.js',
                height: 520,
                images_upload_url: 'image_uploader.php',
                images_upload_base_path: 'https://www.fyipress.net/uploaded_images',
                images_upload_credentials: false,
                relative_urls: false,
                remove_script_host: false,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],

                /* toolbar */
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",

                /* style */
                style_formats: [
                    {title: "Headers", items: [
                            {title: "Header 1", format: "h1"},
                            {title: "Header 2", format: "h2"},
                            {title: "Header 3", format: "h3"},
                            {title: "Header 4", format: "h4"},
                            {title: "Header 5", format: "h5"},
                            {title: "Header 6", format: "h6"}
                        ]},
                    {title: "Inline", items: [
                            {title: "Bold", icon: "bold", format: "bold"},
                            {title: "Italic", icon: "italic", format: "italic"},
                            {title: "Underline", icon: "underline", format: "underline"},
                            {title: "Strikethrough", icon: "strikethrough", format: "strikethrough"},
                            {title: "Superscript", icon: "superscript", format: "superscript"},
                            {title: "Subscript", icon: "subscript", format: "subscript"},
                            {title: "Code", icon: "code", format: "code"}
                        ]},
                    {title: "Blocks", items: [
                            {title: "Paragraph", format: "p"},
                            {title: "Blockquote", format: "blockquote"},
                            {title: "Div", format: "div"},
                            {title: "Pre", format: "pre"}
                        ]},
                    {title: "Alignment", items: [
                            {title: "Left", icon: "alignleft", format: "alignleft"},
                            {title: "Center", icon: "aligncenter", format: "aligncenter"},
                            {title: "Right", icon: "alignright", format: "alignright"},
                            {title: "Justify", icon: "alignjustify", format: "alignjustify"}
                        ]}
                ]
            });</script>
        <script>
            $(function () {
                $("input[type=radio][name=reply_to]").change(function () {
                    if (this.value == 'this_news') {
                        $("#link").css('display', 'none');
                        $("#news_title, #date, #source").css('display', 'block');
                    } else if (this.value == 'something_else') {
                        $("#link").css('display', 'block');
                        $("#news_title, #date, #source").css('display', 'none');
                    }
                });
            });
        </script>
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

        $("#file-4").on('change', function() {
            //Get count of selected files
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var image_holder = $("#image-holder2");
            image_holder.empty();
            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof(FileReader) != "undefined") {
                    //loop for each file selected for uploaded.
                    for (var i = 0; i < countFiles; i++)
                    {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image"
                            }).appendTo(image_holder);
                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[i]);

                        $("#image-holder2").append("<div class='transparent'><a href='#'><i class='fa fa-times-circle'></i></a></div>");
                        $("#image-holder2").css("display", "block");

                    }
                } else {
                    alert("This browser does not support FileReader.");
                }
            } else {
                alert("Pls select only images");
            }
        });

        $("#file-3").on('change', function() {
            //Get count of selected files
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var image_holder = $("#image-holder1");
            image_holder.empty();
            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof(FileReader) != "undefined") {
                    //loop for each file selected for uploaded.
                    for (var i = 0; i < countFiles; i++)
                    {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image"
                            }).appendTo(image_holder);
                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[i]);

                        $("#image-holder1").append("<div class='transparent'><a href='#'><i class='fa fa-times-circle'></i></a></div>");
                        $("#image-holder1").css("display", "block");
                    }
                } else {
                    alert("This browser does not support FileReader.");
                }
            } else {
                alert("Pls select only images");
            }
        });

        $(document).on('click', '#image-holder1 div a', function (e) {
            e.preventDefault();
            $("#image-holder1").css('display', 'none');
            $("#image-holder1 img").remove();
            $("#image-holder1 div").css("visibility", "hidden");
            $('#file-3').attr('value', '');
        })

        $(document).on('click', '#image-holder2 div a', function (e) {
            e.preventDefault();
            $("#image-holder2").css('display', 'none');
            $("#image-holder2 img").remove();
            $("#image-holder2 div").css("visibility", "hidden");
            $('#file-4').attr('value', '');
        })
    });
</script>
</body>
</html>