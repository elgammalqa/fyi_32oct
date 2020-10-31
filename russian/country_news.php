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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                padding-top: 23%;
            }
        }
    </style>
</head>

<body class="skin-orange">
<?php require_once("header.php");
if (isset($_GET['c']) && !empty($_GET['c']) && isset($_GET['n']) && !empty($_GET['n'])){ // id and num page existe
$source='News';
$country = strip_tags(htmlspecialchars(trim($_GET['c'])));

$all_countries = get_list_of_countries();

if(!in_array($country, $all_countries)){
    ?>
    <script>
        window.location.replace('404.php');
    </script>
    <?php
    exit;
}
$numpage = $_GET['n'];
$newspub = new news_publishedModel();
$nbrfeeds = $newspub->nbrNewsBySourceAndCountry($country, $source);

$nbrpages = ceil($nbrfeeds / 10);
if ($numpage >= 1 && $numpage <= $nbrpages) {
$start2 = $numpage * 10 - 10;//0
if ($nbrfeeds - $start2 >= 10)
    $nbhnews = 7;
else $nbhnews = ceil(($nbrfeeds - $start2) / 2);

?>
<section class="category first" style="padding-top: 145px;">
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-push-2 text-left">
                <div class="row">
                    <div class="col-md-12">
                        <ol class="breadcrumb">
                            <li><a href="home.php">Главная</a></li>
                            <li class="active"><?=$country?> Новости</li>
                        </ol>
                        <h1 class="page-title"><?=ucwords($country)?> Новости</h1>
                    </div>
                </div>
                <div class="line"></div>
                <div class="row">
                    <?php $start = $numpage * 10 - 10;//0
                    if ($nbrfeeds - $start >= 10) {//25
                        $req = $newspub->getspecialfeedsBySourceAndCountry($country, $source, $start, 10);
                        //print_r($req); exit;
                        foreach ($req as $news) {
                            if ($news['rank'] == 1) {
                                $thumbnail = $news['thumbnail'];
                                $mediav = 'fyipanel/views/image_news/' . $news['media'];
                                $linkv = "detail.php?id=" . $news['id'];
                                $source2 = "FYIPress ";
                            } else {
                                $thumbnail = $news['thumbnail'];
                                $mediav = $news['media'];
                                $source2 = $news['Source'];

                                //zzz
                                if (news_publishedModel::source_not_open($source2)) {
                                    $linkv = stripslashes($news['link']);
                                    $right_of_reply = false;
                                }
                                else {
                                    $right_of_reply = true;
                                    $has_http = strpos($news['link'], 'http://') !== false;
                                    if ($has_http) {
                                        $linkv = utilisateursModel::getLink("http_link") . "/iframe.php?link=" . stripslashes($news['link']) . "&id=" . $news['id'];
                                    } else {
                                        $linkv = utilisateursModel::getLink("https_link") . "/iframe.php?link=" . stripslashes($news['link']) . "&id=" . $news['id'];
                                    }
                                }
                                //
                            }

                            ?>
                            <article class="col-md-12 article-list">
                                <div class="inner">
                                    <figure style="float: left;">
                                        <?php
                                        $type = news_publishedModel::typeOfMedia($news['media']);
                                        if ($type == "video" || $type == "audio") { ?>
                                            <a>
                                                <video height="100%" width="100%" controls
                                                    <?php if ($thumbnail != "") {
                                                        echo 'poster="' . $thumbnail . '"';
                                                    } ?> >
                                                    <source src="<?php echo $mediav; ?>" alt="video">
                                                </video>
                                            </a>
                                        <?php }
                                        else if ($type == "image") { ?>
                                            <a target="_blank" href="<?php echo $linkv; ?>">
                                                <img height="100%"
                                                     src="<?php echo $mediav; ?>" alt="Image">
                                            </a>
                                        <?php } ?>
                                    </figure>
                                    <div class="details  ">
                                        <h1 class=" ">
                                            <a target="_blank" href="<?php echo $linkv; ?>">
                                                <?php echo $news['title']; ?></a>
                                        </h1>
                                        <p class=" ">
                                            <?php
                                            $real_sentence = stripslashes($news["description"]);
                                            $nb_words = str_word_count($real_sentence);
                                            $sentence = implode(' ', array_slice(explode(' ', $real_sentence), 0, 40));
                                            $nb_words2 = str_word_count($sentence);
                                            echo $sentence;
                                            if ($nb_words > $nb_words2) {
                                                echo '<br> ...';
                                            }
                                            ?>
                                        </p>

                                        <div class="detail" style="float: left;">
                                            <div class="category" style="padding-right: 20px;">
                                                <a class=" ">
                                                    <?php echo $source2; ?>
                                                </a>
                                            </div>
                                            <div class="time ">
                                                                <span class=" ">
                                                                <?php real_news_time($news['pubDate']); ?>
                                                                </span>
                                            </div>

                                                <div class="time right_of_reply">
                                                                    <span class=" ">
                                                                        <a href="news_reply.php?news=<?=$news['id']?>&r=<?=$news['rank']?>">Право на ответ<img src="images/microphone.png" alt=""></a>
                                                                    </span>
                                                </div>


                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php } //for
                    }
                    else {
                        $req = $newspub->getspecialfeedsBySourceAndCountry($country, $source, $start, $nbrfeeds - $start);
                        foreach ($req as $news) {
                            if ($news['rank'] == 1) {
                                $thumbnail = $news['thumbnail'];
                                $mediav = 'fyipanel/views/image_news/' . $news['media'];
                                $linkv = "detail.php?id=" . $news['id'];
                                $source2 = "FYI PRESS";
                            } else {
                                $thumbnail = $news['thumbnail'];
                                $mediav = $news['media'];
                                $source2 = $news['Source'];

                                //zzz
                                if (news_publishedModel::source_not_open($source2)) {
                                    $linkv = stripslashes($news['link']);
                                } else {
                                    $has_http = strpos($news['link'], 'http://') !== false;
                                    if ($has_http) {
                                        $linkv = utilisateursModel::getLink("http_link") . "/iframe.php?link=" . stripslashes($news['link']) . "&id=" . $news['id'];
                                    } else {
                                        $linkv = utilisateursModel::getLink("https_link") . "/iframe.php?link=" . stripslashes($news['link']) . "&id=" . $news['id'];
                                    }
                                }
                                //
                            }
                            ?>

                            <article class="col-md-12 article-list">
                                <div class="inner">
                                    <figure style="float: left;">
                                        <?php
                                        $type = news_publishedModel::typeOfMedia($news['media']);
                                        if ($type == "video" || $type == "audio") { ?>
                                            <a>
                                                <video height="100%" width="100%" controls
                                                    <?php if ($thumbnail != "") {
                                                        echo 'poster="' . $thumbnail . '"';
                                                    } ?> >
                                                    <source src="<?php echo $mediav; ?>" alt="video">
                                                </video>
                                            </a>
                                        <?php } else if ($type == "image") { ?>
                                            <a target="_blank" href="<?php echo $linkv; ?>">
                                                <img height="100%"
                                                     src="<?php echo $mediav; ?>" alt="Image">
                                            </a>
                                        <?php } ?>
                                    </figure>
                                    <div class="details  ">
                                        <h1 class=" ">
                                            <a target="_blank" href="<?php echo $linkv; ?>">
                                                <?php echo $news['title']; ?></a>
                                        </h1>
                                        <p class=" ">
                                            <?php
                                            $real_sentence = stripslashes($news["description"]);
                                            $nb_words = str_word_count($real_sentence);
                                            $sentence = implode(' ', array_slice(explode(' ', $real_sentence), 0, 40));
                                            $nb_words2 = str_word_count($sentence);
                                            echo $sentence;
                                            if ($nb_words > $nb_words2) {
                                                echo '<br> ...';
                                            }
                                            ?>
                                        </p>

                                        <div class="detail" style="float: left;">
                                            <div class="category" style="padding-right: 20px;">
                                                <a class=" ">
                                                    <?php echo $source2; ?>
                                                </a>
                                            </div>
                                            <div class="time ">
				    							<span class=" "> 
				    							<?php real_news_time($news['pubDate']); ?>
				    							</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php } // for
                    } // last page  3 open
                    ?>
                    <div class="col-md-12 text-center  " style="padding-bottom: 30px;">
                        <ul class="pagination">
                            <?php if ($numpage % 10 == 0) {
                                $startpage = ((floor($numpage / 10) - 1) * 10) + 1;
                            } else {
                                $startpage = (floor($numpage / 10) * 10) + 1;
                            }

                            if ($numpage <= 10) { ?>
                                <li class="prev float_right">
                                    <a style="display: none;" href="country_news.php?n=<?=$startpage - 1; ?>">
                                        <i class="ion-ios-arrow-left"></i>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="prev float_right ">
                                    <a href="country_news.php?c=<?=$country?>&n=<?=$startpage - 1?>">
                                        <i class="ion-ios-arrow-left"></i>
                                    </a>
                                </li>
                            <?php }


                            $a = floor(($numpage - 1) / 10) * 10;
                            if ($nbrpages - $a <= 10) {
                                $a = ceil($numpage / 10) * 10;
                                $endpage = $a - ($a - $nbrpages);

                            } else {
                                $endpage = ceil($numpage / 10) * 10;
                            }

                            for ($i = $startpage; $i <= $endpage; $i++) {
                                if ($numpage == $i) { ?>
                                    <li class="active float_right ">
                                        <a href="country_news.php?n=<?=$i; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php } else { ?>
                                    <li class="float_right">
                                        <a href="country_news.php?c=<?=$country?>&n=<?=$i?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php }
                            }

                            //next button
                            if (ceil($nbrpages / 10) > ceil($numpage / 10)) { ?>
                                <li class="next float_right">
                                    <a href="country_news.php?c=<?=$country?>&n=<?=$endpage + 1?>">
                                        <i class="ion-ios-arrow-left"></i>
                                    </a>
                                </li>
                            <?php } else { ?>
                                <li class="next float_right">
                                    <a style="display: none;" href="country_news.php?c=<?=$country?>&n=<?=$endpage + 1?>">
                                        <i class="ion-ios-arrow-left"></i>
                                    </a>
                                </li>

                            <?php } ?>
                            <?php if ($nbrpages > 10 && $numpage == $nbrpages) { ?>
                                <li class="active float_right">
                                    <a href="country_news.php?c=<?=$country?>&n=<?=$nbrpages?>">
                                        <?php echo $nbrpages; ?>
                                    </a>
                                </li>
                            <?php } else if ($nbrpages > 10) { ?>
                                <li class="float_right">
                                    <a href="country_news.php?c=<?=$country?>&n=<?=$nbrpages?>">
                                        <?php echo $nbrpages; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>


            <?php }
else {
    ?>
                <script>
                    window.location.replace('404.php');
                </script>
            <?php } // numpage
             // category
            }
            else { // get isset
                ?>
                <script>
                    window.location.replace('404.php');
                </script>
            <?php } ?>
        </div>
    </div>
    </div>
</section>

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