<?php include("minks.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/favicon.png">
    <link rel="icon" type="image/png" href="assets/images/favicons/favicon.png">
    <meta name="description" content="">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendors/animate/animate.min.css">
    <link rel="stylesheet" href="assets/vendors/animate/custom-animate.css">
    <link rel="stylesheet" href="assets/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/vendors/jarallax/jarallax.css">
    <link rel="stylesheet" href="assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css">
    <link rel="stylesheet" href="assets/vendors/nouislider/nouislider.min.css">
    <link rel="stylesheet" href="assets/vendors/nouislider/nouislider.pips.css">
    <link rel="stylesheet" href="assets/vendors/odometer/odometer.min.css">
    <link rel="stylesheet" href="assets/vendors/swiper/swiper.min.css">
    <link rel="stylesheet" href="assets/vendors/insur-icons/style.css">
    <link rel="stylesheet" href="assets/vendors/insur-two-icon/style.css">
    <link rel="stylesheet" href="assets/vendors/tiny-slider/tiny-slider.min.css">
    <link rel="stylesheet" href="assets/vendors/reey-font/stylesheet.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/vendors/bxslider/jquery.bxslider.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-select/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="assets/vendors/vegas/vegas.min.css">
    <link rel="stylesheet" href="assets/vendors/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" href="assets/vendors/timepicker/timePicker.css">
    <link rel="stylesheet" href="assets/vendors/ion.rangeSlider/css/ion.rangeSlider.min.css">

    <!-- template styles -->
    <link rel="stylesheet" id="langLtr" href="assets/css/insur.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body class="custom-cursor ">

    <!--<div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>-->




    <div class="preloader">
        <div class="preloader__image"></div>
    </div>
    <!-- /.preloader -->


    <div class="page-wrapper">
        <header class="main-header clearfix">
            <div class="main-header__top">
                <div class="container">
                    <div class="main-header__top-inner">
                        <div class="main-header__top-address">
                            <ul class="list-unstyled main-header__top-address-list">
                                <li>
                                    <i class="icon">
                                        <span class="call-icon"></span>
                                    </i>
                                    <div class="text">
                                        <p><?= $company_phone ?></p>
                                    </div>
                                </li>
                                <li>
                                    <i class="icon">
                                        <span class="icon-email"></span>
                                    </i>
                                    <div class="text">
                                        <p><a href=""><?= $company_email ?></a></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="main-header__top-right">
                            <div class="main-header__top-menu-box">
                                <ul class="list-unstyled main-header__top-menu">
                                  
                                    <li><a href="terms.php"> Terms of use</a></li>
                                    <li><a href="privacy.php">Privacy Policy</a></li>
                                </ul>
                            </div>
                            <div class="main-header__top-social-box">
                                <div class="main-header__top-social">
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-facebook"></i></a>
                                    <a href="#"><i class="fab fa-tiktok"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="main-menu clearfix">
                <div class="main-menu__wrapper clearfix">
                    <div class="container">
                        <div class="main-menu__wrapper-inner clearfix">
                            <div class="main-menu__left">
                                <div class="main-menu__logo">
                                    <a href="<?= $link ?>">
                                        <img src="assets/images/logo.png" style="width:250px; height:47px;">
                                    </a>
                                </div>
                                <div class="main-menu__main-menu-box">
                                    <div class="main-menu__main-menu-box-inner">
                                        <a href="#" class="mobile-nav__toggler"><i class="fa fa-bars"></i></a>
<ul class="main-menu__list">
    <li>
        <a href="<?= $link ?>">Home</a>
    </li>
    <li>
        <a href="about">About</a>
    </li>
    <li>
        <a href="faqs">FAQs</a>
    </li>
    <li>
        <a href="profile_home">Account</a>
    </li>
    <li>
        <a href="blog">Dating Tips</a>
    </li>
    <li>
        <a href="contact">Contact</a>
    </li>
</ul>
                                    </div>
                                    <div class="main-menu__main-menu-box-search-get-quote-btn">
                                        <div class="main-menu__main-menu-box-search">
                                            <!--<a href="search.php"
                                                class="main-menu__search search-toggler icon-magnifying-glass"></a>
                                            <a href="cart.php"
                                                class="main-menu__cart insur-two-icon-shopping-cart"></a>-->
                                        </div>
                                        <div class="main-menu__main-menu-box-get-quote-btn-box">
                                            <a href="contact.php"
                                                class="thm-btn main-menu__main-menu-box-get-quote-btn">Support</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div class="stricky-header stricked-menu main-menu">
            <div class="sticky-header__content"></div><!-- /.sticky-header__content -->
        </div><!-- /.stricky-header -->
