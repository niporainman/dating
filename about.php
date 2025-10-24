<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']);
$page_title = "About us";
$page_header = "about_header.jpg";
include("header.php"); ?>
<title><?php echo $company_name; ?> - <?php echo $page_title; ?></title>
<?php include("page_header.php"); ?>
<br><br>



<!--Benefits Start-->
<section class="benefits">
            <div class="benefits-bg" style="background-image: url(site_img/general/about1.jpg);"></div>
            <div class="benefits-bg-2" style="background-image: url(assets/images/backgrounds/benefits-bg-2.jpg);">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="benefits__left">
                            <div class="section-title text-left">
                                <div class="section-sub-title-box">
                                    <p class="section-sub-title">Why Choose Us</p>
                                    <div class="section-title-shape-1">
                                        <img src="assets/images/shapes/section-title-shape-1.png" alt="">
                                    </div>
                                    <div class="section-title-shape-2">
                                        <img src="assets/images/shapes/section-title-shape-2.png" alt="">
                                    </div>
                                </div>
                                <h2 class="section-title__title">Because Everyone Deserves a Second Chance</h2>
                            </div>
                            <p class="benefits__text">

Love doesn’t have an expiration date.
 <div style='height:3px;'></div>
Whether you’re divorced, widowed, or have simply been out of the dating world for a while, we created this space just for you—real people in their 40s, 50s, and beyond who are ready to connect with someone special.
<div style='height:3px;'></div>
We know starting over can feel overwhelming. That’s why <?= $company_name ?> isn’t just another dating app—it’s a community built on trust, respect, and shared experience. Here, you don’t have to pretend to be younger, busier, or someone you're not. You can just be you—and that’s more than enough.
<div style='height:3px;'></div>
Our platform is designed to make dating simple and genuine. With thoughtful profiles, meaningful conversations, and real people looking for real connection, <?= $company_name ?> helps you rediscover not just love, but the joy of companionship, laughter, and new beginnings.
<div style='height:3px;'></div>
So if you're wondering whether it's too late for love, we’re here to say: it’s not.
In fact, your best chapter might be just beginning.
<div style='height:3px;'></div>
Welcome to <?= $company_name ?>—where love gets better with time.</p>
                            <div class="benefits__point-box">
                                <ul class="list-unstyled benefits__point">
                                    <li>
                                        <div class="icon">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div class="text">
                                            <p>Secure</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div class="text">
                                            <p>Easy to use</p>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-unstyled benefits__point benefits__point-two">
                                    <li>
                                        <div class="icon">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div class="text">
                                            <p>Advanced Matching</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div class="text">
                                            <p>Accredited</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Benefits End-->
        <!--Process Start-->
        <section class="process">
            <div class="container">
                <div class="section-title text-center">
                    <div class="section-sub-title-box">
                        <p class="section-sub-title">the process</p>
                        <div class="section-title-shape-1">
                            <img src="assets/images/shapes/section-title-shape-1.png" alt="">
                        </div>
                        <div class="section-title-shape-2">
                            <img src="assets/images/shapes/section-title-shape-2.png" alt="">
                        </div>
                    </div>
                    <h2 class="section-title__title">Using our dating service <br> in 4 steps</h2>
                </div>
                <div class="process__inner">
                    <div class="process-shape-1">
                        <img src="assets/images/shapes/process-shape-1.png" alt="">
                    </div>
                    <div class="row">
                        <!--Process Single Start-->
                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="process__single">
                                <div class="process__icon-box">
                                    <div class="process__icon">
                                        <span class="icon-select"></span>
                                    </div>
                                    <div class="process__count"></div>
                                </div>
                                <div class="process__content">
                                    <h3 class="process__title">Create Your Profile</h3>
                                    <p class="process__text">Start by telling your story. Share a bit about who you are, your interests, and what you're looking for in a partner. Upload a recent photo and let your personality shine through. You don’t have to be perfect—just real.</p>
                                </div>
                            </div>
                        </div>
                        <!--Process Single End-->
                        <!--Process Single Start-->
                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="process__single process__single-2">
                                <div class="process__icon-box">
                                    <div class="process__icon">
                                        <span class="icon-group"></span>
                                    </div>
                                    <div class="process__count"></div>
                                </div>
                                <div class="process__content">
                                    <h3 class="process__title">Browse & Discover Matches</h3>
                                    <p class="process__text">Once your profile is live, start browsing! Our system helps you discover potential matches who share your values, interests, and relationship goals. Whether you're looking for friendship, companionship, or romance, there's someone here waiting to meet you.</p>
                                </div>
                            </div>
                        </div>
                        <!--Process Single End-->
                        <!--Process Single Start-->
                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="process__single process__single-3">
                                <div class="process__icon-box">
                                    <div class="process__icon">
                                        <span class="icon-chat"></span>
                                    </div>
                                    <div class="process__count"></div>
                                </div>
                                <div class="process__content">
                                    <h3 class="process__title">Start Conversations</h3>
                                    <p class="process__text">Break the ice with a friendly message or respond to someone who caught your eye. Our platform makes it easy to chat safely and comfortably. No pressure—just real conversations that can grow into real connection.</p>
                                </div>
                            </div>
                        </div>
                        <!--Process Single End-->
                        <!--Process Single Start-->
                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <div class="process__single process__single-4">
                                <div class="process__icon-box">
                                    <div class="process__icon">
                                        <span class="icon-heart-beat"></span>
                                    </div>
                                    <div class="process__count"></div>
                                </div>
                                <div class="process__content">
                                    <h3 class="process__title">Meet & Build Something Real</h3>
                                    <p class="process__text">When you're ready, take things offline and meet in person. Whether it’s coffee, a walk, or dinner, every step forward is part of your new beginning. You set the pace—we’re just here to help you take the next step with confidence.</p>
                                </div>
                            </div>
                        </div>
                        <!--Process Single End-->
                    </div>
                </div>
                
            </div>
        </section>
        <!--Process End-->
<?php include("footer.php"); ?>