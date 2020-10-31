<?php
require_once('online.php');

$domain = 'https://www.fyipress.net/';
$user_info = get_user_country();
$user_country = trim($user_info['country']);

$resource_countries = get_list_of_countries();
$user_country_in_array = false;
if (in_array($user_country, $resource_countries)) {
    $user_country_in_array = true;
    require_once 'models/v4.utilisateurs.model.php';
    $country_to_display = $user_country;
} else {
    $country_to_display = '世界';
}


if (isset($_COOKIE['fyiuser_email'])) {
    $user_email = $_COOKIE['fyiuser_email'];
} else if (isset($_SESSION['user_auth']['user_email'])) {
    $user_email = $_SESSION['user_auth']['user_email'];
} ?>
<head>
<script async defer data-website-id="d023d0d4-b1c1-40f5-8aed-7f8573943896" src="https://spinehosting.com/umami.js"></script>
    <meta name="p:domain_verify" content="20fe15c41ecc108c8279c64b0f7216f0"/>
    <title style="text-align: left;"> FYI Press </title>
    <style type="text/css">
        @media only screen and (max-width: 991px) {
            #navid {
                overflow: hidden;
            }

            #colorblack li a {
                color: black;
            }

            .content {
                padding: 16px;
            }

            .sticky {
                position: fixed;
                top: 0;
                width: 100%;
            }

            .sticky + .content {
                padding-top: 60px;
            }

            #logocolor {
                background-color: #55abcd;
            }
        }

        @media only screen and (min-width: 991px) {
        <?php if ($log==false) {  ?>
            #colorblack li a {
                color: white;
                font-size: 15px;
                letter-spacing: 2px;
                font-weight: 700;
                line-height: 32px;
                padding-top: 16px;
                padding-right: 35px;
            }

        <?php }else {  ?>
            #colorblack li a {
                color: white;
                font-size: 15px;
                letter-spacing: 2px;
                font-weight: 700;
                line-height: 32px;
                padding-top: 16px;
                padding-right: 25px;
            }

        <?php } ?>

            #colorblack2 li a {
                color: black;
            }

            .pl {
                padding-left: 80px !important;
                padding-top: 7px !important;
            }

            .plm li a {
                padding-right: 40px !important;
            }
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
        }
        @media only screen and (min-width: 991px) {
            .dropdown-content {
                position: absolute;
                background-color: #f9f9f9;
                width: 340px;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                padding: 12px 16px;
                z-index: 1;
                border-bottom: 1px solid #ccc;
                left: -150px;
            }
        }

        .plm li .dropdown-content a{
            float: left;
            width: 49%;
            height: 40px;
            line-height: 40px;
            display: block;
            padding: 0 0 0 30px !important;
            text-transform: capitalize;
            padding-right: 0 !important;
            border-bottom: 1px solid #f1f1f1;
            font-size: 12px;
            margin-left: 1%;
        }

        .plm li .dropdown-content a img{
            float: left;
            width: 25px;
            height: 18px;
            margin-left: -30px;
            margin-right: 10px;
            margin-top: 10px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112526925-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-112526925-2');
    </script>
		<!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-174224614-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());

        gtag('config', 'UA-174224614-1');
        </script>
</head>

<header class="primary">
    <div class="navbar-expand-lg fixed-top navbar-dark bg-primary">
        <nav class="menu" style="width: 100% ;height: 100%;   background-color: #55abcd; display: block !important;">
            <div class="container">
                <div style="background-color: #55abcd;" id="menu-list">
                    <ul id="colorblack" class="nav-list">
                        <?php if (isMobile()) { ?>
                            <li style="background-color: red; " class="backk"><a
                                        style="  font-size: 30px; color:#fff; border-bottom: none !important; ">バック <i style="text-align: left; font-size: 30px;"
                                                                                                                       class="ion-ios-arrow-forward"></i></a></li>
                        <?php } else { ?>
                            <li><a id="logocolor" href="index.php"><img src="images/fyipress.png"
                                                                        style="width: 50px; height: 30px; "></a></li>
                            <li><a id="logocolor" href="fyi.php"><img src="../images/fyipress2.png"
                                                                      style="width: 50px; height: 30px; "></a></li>
                        <?php } ?>
                        <li><a target="_blank" href="http://www.chatsrun.com">ChatsRun</a></li>
                        <li><a target="_blank" href="http://www.ispotlights.com">SpotLights</a></li>
                        <li><a href="favorite_countries.php">好きな情報源</a></li>
                        <?php if ($log == false) { ?>
                            <li><a href="login.php">ログイン</a></li>
                            <li><a href="register.php">登録</a></li>
                        <?php } else { ?>
                            <li class="dropdown magz-dropdown">
                                <a style="padding-right: 0px !important;">
                                    ようこそ : <?php
                                    echo utilisateursModel::getUserName($user_email); ?>
                                    <i class="ion-ios-arrow-right"></i>
                                </a>
                                <ul id="colorblack2" class="dropdown-menu">
                                    <li>
                                        <a href="resetpass.php">
                                            <i class="icon ion-key"> </i>パスワードを変更する
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="logout.php">
                                            <i class="icon ion-log-out"></i> パスワードを変更する</a></li>
                                </ul>
                            </li>
                        <?php }
                        if (!isMobile()) { ?>
                            <li class="dropdown magz-dropdown">
                                <a style="  padding-left:50px;">言語 <i class="ion-ios-arrow-right"></i></a>
                                <ul id="colorblack2" class="dropdown-menu">
                                    <li><a class="pl" href="../arabic/index.php">العربية</a></li>
                                    <li><a class="pl" href="../urdu/index.php">ارڈو </a></li>
                                    <li><a class="pl" href="../home.php">English</a></li>
                                    <li><a class="pl" href="../turkish/index.php">Türkçe</a></li>
                                    <li><a class="pl" href="../german/index.php">Deutsche</a></li>
                                    <li><a class="pl" href="../spanish/index.php">Español</a></li>
                                    <li><a class="pl" href="../french/index.php">Français</a></li>
                                    <li><a class="pl" href="../russian/index.php">русский</a></li>
                                    <li><a class="pl" href="index.php">日本語</a></li>
                                    <li><a class="pl" href="../chinese/index.php">中國</a></li>
                                    <li><a class="pl" href="../indian/index.php">भारतीय</a></li>
                                    <li><a class="pl" href="../hebrew/index.php">עברית</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <li class="font"><a target="_blank" href="search.php" style="padding-right: 0px;">
                                <i style="font-size: 17pt;" class="ion-search"> </i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- Start nav -->
    <?php if (!isMobile()){ ?>
    <nav id="navid" class="menu" style=" width: 100% ;height: 100%; ">
        <?php }else{ ?>
        <nav id="navid" class="menu" style=" width: 100% ;height: 100%; background-color: #55abcd;  ">
            <?php } ?>
            <div class="container">
                

                <div class="mobile-toggle">
                    <a href="#" data-toggle="menu" data-target="#menu-lists"><i class="ion-navicon-round" style="color: red;"></i></a>
                </div>

                <div class="mobile-toggle">
                    <a href="#" data-toggle="menu" data-target="#menu-list"><i class="ion-android-apps" style="color: red;"></i></a>
                </div>

                <div class="mobile-toggle">
                    <a href="#" data-toggle="menu" data-target="#menu-lang"><i class="ion-ios-world" style="color: red;"></i></a>
                </div>
                <div style="float: left;" class="mobile-toggle">
                    <a href="index.php"><img style="width: 50px; height: 30px; " src="images/fyipress.png"></a>
                </div>
                <div style="float: left;" class="mobile-toggle">
                    <a href="fyi.php"><img style="width: 50px; height: 30px; " src="../images/fyipress2.png"></a>
                </div>

                <div id="menu-lists">
                    <ul class="nav-list plm">
                        <?php if (isMobile()) { ?>
                            <li style="background-color: red; " class="backk">
                                <a style="  font-size: 30px; color:#fff; border-bottom: none !important; "> バック <i style="text-align: left; font-size: 30px;"
                                                                                                                   class="ion-ios-arrow-forward"></i></a></li>
                        <?php } ?>
                        <li><a href="index.php">ホーム</a></li>
                        <li><a href="breaking_news.php?n=1">速報</a></li>
                        <?php
                        if ($user_country_in_array) {
                            ?>
                            <li><a href="country_news.php?c=<?= $user_country ?>&n=1"><?= ucwords($country_to_display) ?></a></li>
                            <?php
                        }
                        else {
                            ?>
                            <li><a href="#">世界</a></li>
                            <?php
                        }
                        ?>
                        <li><a href="category.php?id=News&n=1">ニュース</a></li>
                        <li><a href="category.php?id=Sports&n=1">スポーツ</a></li>
                        <li><a href="category.php?id=Economy&n=1">経済</a></li>
                        <li><a href="category.php?id=Health&n=1">健康</a></li>
                        <li><a href="category.php?id=Arts&n=1">芸術</a></li>
                        <li><a href="category.php?id=Technology&n=1">技術</a></li>
                        <li><a href="category.php?id=Culture&n=1">一般文化</a></li>
                        <li><a href="library.php?n=1">としょうかん</a></li>
                        <li class="dropdown"><a  href="#">国</a>
                            <div class="dropdown-content">
                                <?php
                                foreach ($resource_countries as $item) {
                                    ?><a href="country_news.php?c=<?= $item ?>&n=1"><img
                                            src="<?= $domain ?>v2/countries/<?= ucwords($item) ?>.png"> <?= $item
                                    ?></a><?php
                                }
                                ?>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php if (isMobile()) { ?>
                    <div id="menu-lang">
                        <ul class="nav-list plm">
                            <li style="background-color: red; " class="backk">
                                <a style="  font-size: 30px; color:#fff; border-bottom: none !important; ">バック <i style="text-align: left; font-size: 30px;"
                                                                                                                  class="ion-ios-arrow-forward"></i></a></li>
                            <li><a href="../arabic/index.php">العربية</a></li>
                            <li><a href="../urdu/index.php">ارڈو </a></li>
                            <li><a href="../home.php">English</a></li>
                            <li><a href="../turkish/index.php">Türkçe</a></li>
                            <li><a href="../german/index.php">Deutsche</a></li>
                            <li><a href="../spanish/index.php">Español</a></li>
                            <li><a href="../french/index.php">Français</a></li>
                            <li><a href="../russian/index.php">русский</a></li>
                            <li><a href="index.php">日本語</a></li>
                            <li><a href="../chinese/index.php">中國</a></li>
                            <li><a href="../indian/index.php">भारतीय</a></li>
                            <li><a href="../hebrew/index.php">עברית</a></li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </nav>
        <!-- End nav -->
</header>
    <div id="token" style="display: none"></div>
    <div id="msg" style="display: none"></div>
    <div id="notis" style="display: none"></div>
    <div id="err" style="display: none"></div>
    <script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-messaging.js"></script>
    <!-- For an optimal experience using Cloud Messaging, also add the Firebase SDK for Analytics. -->
    <script src="https://www.gstatic.com/firebasejs/7.2.1/firebase-analytics.js"></script>
    <script>
        MsgElem = document.getElementById("msg");
        TokenElem = document.getElementById("token");
        NotisElem = document.getElementById("notis");
        ErrElem = document.getElementById("err");
        // Initialize Firebase
        // TODO: Replace with your project's customized code snippet
        var config = {
            apiKey: "AIzaSyBVXxwB5O5mtMQnoEdCKbv3zmBzXWZ7yKA",
            authDomain: "fir-3-7f672.firebaseapp.com",
            databaseURL: "https://fir-3-7f672.firebaseio.com",
            projectId: "fir-3-7f672",
            storageBucket: "fir-3-7f672.appspot.com",
            messagingSenderId: "88183385939",
            appId: "1:88183385939:web:fe5175b5cd48431799fba6"
        };
        firebase.initializeApp(config);

        const messaging = firebase.messaging();
        messaging
            .requestPermission()
            .then(function () {
                MsgElem.innerHTML = "Notification permission granted."
                console.log("Notification permission granted.");

                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function(token) {
                TokenElem.innerHTML = token;
                document.cookie = 'tk='+token;
            })
            .catch(function (err) {
                ErrElem.innerHTML =  ErrElem.innerHTML + "; " + err
                console.log("Unable to get permission to notify.", err);
            });

        messaging.onMessage(function(payload) {
            console.log("Message received. ", payload);
            NotisElem.innerHTML = NotisElem.innerHTML + JSON.stringify(payload);
            //kenng - foreground notifications
            const {title, ...options} = payload.notification;
            navigator.serviceWorker.ready.then(registration => {
                registration.showNotification(title, options);
            });
        });
    </script>

<?php
if(utilisateursModel::islogged()){
    if(isset($_COOKIE['tk'])){
        $token = $_COOKIE['tk'];
        require_once('models/utilisateurs.model.php');
        require_once('models/v4.utilisateurs.model.php');
        $utilisateur=new utilisateursModel();
        $user_row = $utilisateur->get_user_by_email($_COOKIE['fyiuser_email']);
        v4Utilisteurs::update_user($token, $user_row['user_id']);
    }
}
?>