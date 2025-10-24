<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("header.php"); ?>
<title><?php echo $company_name; ?> - Home</title>

        <!--Main Slider Start--> <div style='height:35px;'></div>
        <section class="main-slider-two clearfix">
            <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true,
                "effect": "fade",
                "pagination": {
                "el": "#main-slider-pagination",
                "type": "bullets",
                "clickable": true
                },
                "navigation": {
                "nextEl": "#main-slider__swiper-button-next",
                "prevEl": "#main-slider__swiper-button-prev"
                },
                "autoplay": {
                "delay": 5000
                }}'>
                <div class="swiper-wrapper">
<?php
	$stmt_slider = $con -> prepare('SELECT * FROM picture_slider'); 
	$stmt_slider -> execute(); 
	$stmt_slider -> store_result(); 
	$stmt_slider -> bind_result($slideid,$slideheading,$slideparagraph,$slidepicture); 
	$numrows_slider = $stmt_slider -> num_rows();
	if($numrows_slider > 0){
		while ($stmt_slider -> fetch()) { 
?>
                    <div class="swiper-slide">
                        <div class="image-layer-two"
                            style="background-image: url(site_img/home_background/<?php echo $slidepicture; ?>);"></div>
                        <!-- /.image-layer -->

                        <div class="container">
                            <div class="main-slider-two__inner">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-7">
                                        <div class="main-slider-two__content">
                                            <h2 class="main-slider-two__title"><?= $slideheading; ?></h2>
                                            <p class="main-slider-two__text"><?= $slideparagraph; ?></p>
                                            <div class="main-slider-two__btn-box">
                                                <a href="signup" class="thm-btn main-slider-two__btn">Sign Up</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-5">
                                        <div class="main-slider-two__right">
                                            <!--<div class="main-slider-two__video-link">
                                                <a href=""
                                                    class="video-popup">
                                                    <div class="main-slider-two__video-icon">
                                                        <span class="fa fa-play"></span>
                                                        <i class="ripple"></i>
                                                    </div>
                                                </a>
                                                <h4 class="main-slider-two__video-text">Watch <br> How it Works</h4>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php } } ?>
                </div>

                <!-- If we need navigation buttons -->
                <div class="main-slider__nav">
                    <div class="swiper-button-prev" id="main-slider__swiper-button-next">
                        <i class="icon-right-arrow"></i>
                    </div>
                    <div class="swiper-button-next" id="main-slider__swiper-button-prev">
                        <i class="icon-right-arrow1"></i>
                    </div>
                </div>

            </div>
        </section>
        <!--Main Slider End-->

       

        

       

        <!--Work Together Start-->
        <section class="work-together">
            <div class="container">
                <div class="row">
                    <!--<div class="col-xl-6 col-lg-6">
                        <div class="work-together__left">
                             <div class="section-title text-left">
                                <div class="section-sub-title-box">
                                    <p class="section-sub-title">Search</p>
                                    <div class="section-title-shape-1">
                                        <img src="assets/images/shapes/section-title-shape-1.png" alt="">
                                    </div>
                                    <div class="section-title-shape-2">
                                        <img src="assets/images/shapes/section-title-shape-2.png" alt="">
                                    </div>
                                </div>
                                <h2 class="section-title__title">Search for your next spark</h2>
                            </div>
                            <div class="get-insuracne-two__content">
                                <form class="get-insuracne-two__form">
                                    <div class="get-insuracne-two__content-box">
                                        <div class="get-insuracne-two__input-box">
                                            <input type="number" placeholder="Age (From)"
                                                name="age_min" min="18">
                                        </div>
                                        <div class="get-insuracne-two__input-box">
                                            <input type="number" placeholder="Age (To)"
                                                name="age_max">
                                        </div>
                                        <div class="get-insuracne-two__input-box">
                                           <select class='selectpicker' name="gender" id="gender">
                                            <option value="">Searching For...</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                           </select>
                                        </div>
                                       
                                    </div>
                                   
                                    <div class="get-insuracne-two__content-bottom">
                                        <button type="submit"
                                            class="thm-btn get-insuracne-two__btn">Search</button>
                                       
                                    </div>

                                </form>
                            </div>
                          
                        </div>
                    </div>-->
                     <div class="col-xl-6 col-lg-6">
                        <div class="about-one__left">
                            <div class="about-one__img-box wow slideInLeft" data-wow-delay="100ms"
                                data-wow-duration="2500ms">
                                <div class="about-one__img">
                                    <img src="site_img/general/home2.jpg" style="width:541px; height:490px; object-fit:cover;">
                                </div>
                                <div class="about-one__img-two">
                                    <img src="site_img/general/home3.jpg" style="width:364px; height:350px; object-fit:cover;">
                                </div>
                                <div class="about-one__experience">
                                    <h2 class="about-one__experience-year">1000+</h2>
                                    <p class="about-one__experience-text">Potential <br> Matches!</p>
                                </div>
                                <div class="about-one__shape-1">
                                    <img src="assets/images/shapes/about-one-shape-1.jpg" alt="">
                                </div>
                            </div>
                        </div> <br><br><br>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="work-together__right">
                             <div class="section-title text-left">
                                <div class="section-sub-title-box">
                                    <p class="section-sub-title">About us</p>
                                    <div class="section-title-shape-1">
                                        <img src="assets/images/shapes/section-title-shape-1.png" alt="">
                                    </div>
                                    <div class="section-title-shape-2">
                                        <img src="assets/images/shapes/section-title-shape-2.png" alt="">
                                    </div>
                                </div>
                                <h2 class="section-title__title">Because Love Deserves a Second Chance</h2>
                            </div>
                            <div class="work-together__content-box">
                                <div class="work-together__img">
                                    <img src="site_img/general/home1.jpg" alt="">
                                </div>
                                <div class="work-together__text-box">
                                    <p class="work-together__text">Rekindle the excitement of romance—with the wisdom and experience to make it last.</p>
                                </div>
                            </div>
                            <div class="work-together__progress">
                                <div class="work-together__progress-single">
                                    <h4 class="work-together__progress-title">Safe</h4>
                                    <div class="bar">
                                        <div class="bar-inner count-bar" data-percent="100%">
                                            <div class="count-text">100%</div>
                                        </div>
                                    </div>
                                    <br>
                                     <h4 class="work-together__progress-title">Intutive Matching</h4>
                                    <div class="bar">
                                        <div class="bar-inner count-bar" data-percent="100%">
                                            <div class="count-text">100%</div>
                                        </div>
                                    </div>
                                    <br>
                                     <h4 class="work-together__progress-title">Easy to use</h4>
                                    <div class="bar">
                                        <div class="bar-inner count-bar" data-percent="100%">
                                            <div class="count-text">100%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Work Together End-->
<?php $yes = "Yes";
	$stmt_test = $con -> prepare('SELECT * FROM testimonials WHERE display = ?'); 
    $stmt_test -> bind_param('s', $yes);
	$stmt_test -> execute(); 
	$stmt_test -> store_result(); 
	$stmt_test -> bind_result($test_id,$test_name,$test_occupation,$test_comment,$test_picture,$test_display); 
	$numrows_test = $stmt_test -> num_rows();
	if($numrows_test > 0){
?>

        <!--Testimonial Page Start-->
        <section class="testimonial-page">
            <div class="container">
                                <div class="section-title text-center">
                    <div class="section-sub-title-box">
                        <p class="section-sub-title">Testimonials</p>
                        <div class="section-title-shape-1">
                            <img src="assets/images/shapes/section-title-shape-1.png" alt="">
                        </div>
                        <div class="section-title-shape-2">
                            <img src="assets/images/shapes/section-title-shape-2.png" alt="">
                        </div>
                    </div>
                    <h2 class="section-title__title">Real Love Stories</h2>
                </div>
                <div class="row">
<?php while ($stmt_test -> fetch()) { ?>
                    <div class="col-xl-6 col-lg-6">
                        <div class="testimonial-one__single">
                            <div class="testimonial-one__single-inner">
                                <div class="testimonial-one__shape-1">
                                    <img src="assets/images/shapes/testimonial-one-shape-1.png" alt="">
                                </div>
                                <div class="testimonial-one__client-info">
                                    <div class="testimonial-one__client-img-box">
                                        <img src="site_img/testimonials/<?= $test_picture ?>" alt="">
                                        <div class="testimonial-one__quote">
                                            <img src="assets/images/testimonial/testimonial-1-quote.png" alt="">
                                        </div>
                                    </div>
                                    <div class="testimonial-one__client-content">
                                        <div class="testimonial-one__client-review">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="testimonial-one__client-details">
                                            <h3 class="testimonial-one__client-name"><?= $test_name ?></h3>
                                            <p class="testimonial-one__client-sub-title"><?= $test_occupation ?></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="testimonial-one__text"><?= $test_comment ?></p>
                            </div>
                        </div>
                    </div>
<?php } ?>                
                </div>
            </div>
        </section>
        <!--Testimonial Page End-->
<?php } ?>  

<?php
	$stmt = $con -> prepare("SELECT * FROM blog"); 
	$stmt -> execute(); 
	$stmt -> store_result(); 
	$stmt -> bind_result($id,$blog_id,$blog_heading,$blog_category,$blog_preamble,$blog_body,$blog_picture,$blog_featured,$blog_date,$keywords,$comments_allowed); 
	$numrows = $stmt -> num_rows();
	if($numrows > 0){
		
?>
        <!--News Two Start-->
        <section class="news-two">
            <div class="container">
                <div class="section-title text-center">
                    <div class="section-sub-title-box">
                        <p class="section-sub-title">Spark Twice Blog</p>
                        <div class="section-title-shape-1">
                            <img src="assets/images/shapes/section-title-shape-1.png" alt="">
                        </div>
                        <div class="section-title-shape-2">
                            <img src="assets/images/shapes/section-title-shape-2.png" alt="">
                        </div>
                    </div>
                    <h2 class="section-title__title">Dating Tips and Tricks</h2>
                </div>
                <div class="row">
<?php
while ($stmt -> fetch()) { 
      //category name
      $stmt_cat = $con -> prepare('SELECT * FROM blog_categories WHERE id = ?');
			$stmt_cat -> bind_param('i',$blog_category);
			$stmt_cat -> execute(); 
			$stmt_cat -> store_result(); 
			$stmt_cat -> bind_result($cat_idd,$blog_category_name); 
			while ($stmt_cat -> fetch()){}
      //comments
      $stmt_pr = $con->prepare("SELECT COUNT(*) FROM comments WHERE blog_id = ?");
      $stmt_pr->bind_param('s', $blog_id);
      $stmt_pr->execute();
      $stmt_pr->bind_result($no_comments);
      $stmt_pr->fetch();
      $stmt_pr->close();

      if($no_comments == 1){
        $s = "";
      }else{
        $s = "s";
      }

      //date formatting 
      $blog_date = new DateTime($blog_date);
      $blog_date_formatted = $blog_date->format('F j, Y'); 
    ?>
                    <!--News Two Single Start-->
                    <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                        <div class="news-two__single">
                            <div class="news-two__img">
                                <img src="site_img/blog/<?php echo $blog_picture; ?>" alt="">
                                <div class="news-two__arrow-box">
                                    <a href="article_details?article_id=<?php echo $blog_id; ?>" class="news-two__arrow">
                                        <span class="icon-right-arrow1"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="news-two__content">
                                <h3 class="news-two__title"><a href="article_details?article_id=<?php echo $blog_id; ?>"><?= $blog_heading; ?></a></h3>
                                <div class="news-two__client">
                                    <div class="news-two__client-img">
                                        <h5 style='font-size:10px;'><?= $blog_date_formatted ?></h5>
                                        <?= $blog_preamble ?> <br>
                                        <a class='btn btn-primary' href="article_details?article_id=<?php echo $blog_id; ?>">Read More</a>
                                    </div>
                                    <div class="news-two__client-content">
                                        
                                    </div>
                                </div>
                                <div class="news-two__tag">
                                    <p><i class="far fa-folder"></i><?= $blog_category_name ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--News Two Single End-->
<?php } ?>
                    
                </div>
            </div>
        </section>
        <!--News Two End-->
<?php } ?>
<?php include("footer.php"); ?>



