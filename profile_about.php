<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("profile_header.php"); ?>
<title><?php echo $company_name; ?> - Profile About</title>

        <div class="page-center">

            <!-- profile cover start -->
            <div class="profile-cover">
                <img src="<?= $profile_background_container ?>" class="img-fluid blur-up lazyload bg-img" alt="cover">
                <div class="profile-box d-lg-block d-none">
                    <div class="profile-content">
                        <div class="image-section">
                            <div class="profile-img">
                                <div>
                                    <img src="<?= $profile_pic_container ?>" class="img-fluid blur-up lazyload bg-img" alt="profile">
                                </div>
                                <span class="stats">
                                    <img src="images/verified.png" class="img-fluid blur-up lazyload" alt="verified">
                                </span>
                            </div>
                        </div>
                        <div class="profile-detail">
                            <h2><?= $first_name ?> <?= $last_name ?> <span>❤</span></h2>
                            <h5><?= $username ?></h5>
                            <div class="counter-stats" style='width:250px;'>
                                <ul id="counter">
                                    <li>
                                        <h3 class="counter-value" data-count="<?= $friend_count ?>">0</h3>
                                        <h5>friends</h5>
                                    </li>
                                   
                                </ul>
                            </div>
                            <a href="profile_edit" class="btn btn-solid">edit profile</a>
                        </div>
                    </div>
                </div>
                <div class="setting-dropdown btn-group custom-dropdown arrow-none dropdown-sm">
                    <a class="btn-white btn-cover" href="profile_edit">
                        edit cover
                    </a>
                   
                </div>
            </div>
            <div class="d-lg-none d-block">
                <div class="profile-box">
                    <div class="profile-content">
                        <div class="image-section">
                            <div class="profile-img">
                                <div>
                                    <img src="<?= $profile_pic_container ?>" class="img-fluid blur-up lazyload bg-img" alt="profile">
                                </div>
                                <span class="stats">
                                    <img src="images/verified.png" class="img-fluid blur-up lazyload" alt="verified">
                                </span>
                            </div>
                        </div>
                        <div class="profile-detail">
                            <h2><?= $first_name ?> <?= $last_name ?> <span>❤</span></h2>
                            <h5><?= $username ?></h5>
                            <div class="counter-stats" style='width:250px;text-align:center;margin:auto;'>
                                
                                    <br>
                                        <h3 style='font-weight:900;' class="counter-value"  data-count="<?= $friend_count ?>">0</h3>
                                        <h5>friends</h5>
                                    
                                
                            </div>
                            <a href="profile_edit" class="btn btn-solid">edit profile</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- profile cover end -->

            <!-- profile menu start -->
            <div class="profile-menu section-t-space">
                <ul>
                    <li>
                        <a href="profile_home">
                            <i class="iw-14 ih-14" data-feather="home"></i>
                            <h6>Home</h6>
                        </a>
                    </li>
                    <li class="active">
                        <a href="profile_about">
                            <i class="iw-14 ih-14" data-feather="info"></i>
                            <h6>about</h6>
                        </a>
                    </li>
                    <li>
                        <a href="profile_friends">
                            <i class="iw-14 ih-14" data-feather="users"></i>
                            <h6>friends</h6>
                        </a>
                    </li>
                    <li>
                        <a href="profile_images">
                            <i class="iw-14 ih-14" data-feather="image"></i>
                            <h6>photos</h6>
                        </a>
                    </li>
                     <li>
                        <a href="profile_videos">
                            <i class="iw-14 ih-14" data-feather="video"></i>
                            <h6>video</h6>
                        </a>
                    </li>
                   
                </ul>
              
            </div>
            <!-- profile menu end -->

            <div class="container-fluid section-t-space px-0">
                <div class="row">
                    <div class="content-left col-4 res-full-width order-1">
                        <!-- profile box -->
                        <div class="profile-about sticky-top">
                            <div class="card-title">
                                <h3>about</h3>
                                <h5>Your Bio</h5>
                                <div class="settings">
                                    <div class="setting-btn">
                                        <a href="profile_edit">
                                            <i class="icon icon-dark stroke-width-3 iw-11 ih-11" data-feather="edit-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="about-content">
                                <ul>
                                    <li>
                                        <div class="icon">
                                            <i class="iw-18 ih-18" data-feather="user"></i>
                                        </div>
                                        <div class="details">
                                            
                                            <h6 style='font-weight:700;font-size:13px;'><?= $bio ?></h6>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="icon">
                                            <svg class="iw-18 ih-18">
                                                <use xlink:href="images/icons.svg#cake"></use>
                                            </svg>
                                        </div>
                                        <div class="details">
                                            <h5>Birthday</h5>
                                            <h6><?= $birthday_formatted ?></h6>
                                        </div>
                                    </li>
                                    <!--<li>
                                        <div class="icon">
                                            <i class="iw-18 ih-18" data-feather="phone"></i>
                                        </div>
                                        <div class="details">
                                            <h5>Phone</h5>
                                            <h6>041 985 245 210</h6>
                                        </div>
                                    </li>-->
                                    <li>
                                        <div class="icon">
                                            <i class="iw-18 ih-18" data-feather="user"></i>
                                        </div>
                                        <div class="details">
                                            <h5>gender</h5>
                                            <h6><?= $gender ?></h6>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <div class="icon">
                                            <i class="iw-18 ih-18" data-feather="map-pin"></i>
                                        </div>
                                        <div class="details">
                                            <h5>lives in <?= $location ?></h5>
                                            <h6><?= $country ?></h6>
                                        </div>
                                    </li>
                                   
                                    <li>
                                        <div class="icon">
                                            <i class="iw-18 ih-18" data-feather="link"></i>
                                        </div>
                                        <div class="details">
                                            <h5>joined</h5>
                                            <h6><?= $joined_formatted ?></h6>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <div class="content-center col-xl-8">
                        <!-- hobbies profile -->
                        <div class="about-profile section-b-space">
                            <div class="card-title">
                                <h3>hobbies & interests</h3>
                                <div class="settings">
                                    <div class="setting-btn">
                                        <a href="profile_edit" >
                                            <i class="icon icon-dark stroke-width-3 iw-11 ih-11" data-feather="edit-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
<?php
$array_hobbies = []; 
$array_movies = []; 
$array_tv = [];    
$array_artists = [];   
$array_books = [];
$array_others = [];  
$sql = "SELECT value,category FROM user_interests WHERE user_id = ?";
$stmt_ui = $con->prepare($sql);
$stmt_ui->bind_param("s", $user_id);
$stmt_ui->execute();
$stmt_ui -> store_result(); 
$stmt_ui -> bind_result($interest, $interest_category); 
$numrows_ui = $stmt_ui -> num_rows();
if ($numrows_ui > 0) {
    while ($stmt_ui -> fetch()) {
        if($interest_category == "Hobby"){
            $array_hobbies[] = $interest;
        }
        if($interest_category == "Movie"){
            $array_movies[] = $interest;
        }
        if($interest_category == "TV Show"){
            $array_tv[] = $interest;
        }
        if($interest_category == "Favourite Artist"){
            $array_artists[] = $interest;
        }
        if($interest_category == "Book"){
            $array_books[] = $interest;
        }
        if($interest_category == "Other"){
            $array_others[] = $interest;
        }
    }
}
?>
                            <ul class="about-list">
                                <li>
                                    <h5 class="title">hobbies :</h5>
                                    <h6 class='content'>
                                    <?php echo implode(', ', $array_hobbies); ?>
                                    </h6>
                                </li>
                                <li>
                                    <h5 class="title">Favourite Movies :</h5>
                                    <h6 class='content'>
                                    <?php echo implode(', ', $array_movies); ?>
                                    </h6>
                                </li>
                                <li>
                                    <h5 class="title">favourite tv shows :</h5>
                                    <h6 class='content'>
                                    <?php echo implode(', ', $array_tv); ?>
                                    </h6>
                                </li>
                                <li>
                                    <h5 class="title">favourite music artists :</h5>
                                    <h6 class='content'>
                                    <?php echo implode(', ', $array_artists); ?>
                                    </h6>
                                </li>
                                <li>
                                    <h5 class="title">Favourite Books:</h5>
                                    <h6 class='content'>
                                    <?php echo implode(', ', $array_books); ?>
                                    </h6>
                                   
                                </li>
                                <li>
                                    <h5 class="title">other interests :</h5>
                                    <h6 class='content'>
                                    <?php echo implode(', ', $array_others); ?>
                                    </h6>
                                </li>

                            </ul>
                        </div>
                        
                        <!-- friend list -->
                        <div class="friend-list-box section-t-space section-b-space">
                            <div class="card-title">
                                <h3>friends</h3>
                                <div class="right-setting">
                                    <div class="search-input input-style icon-right">
                                        <i data-feather="search" class="icon-dark icon iw-16"></i>
                                        <input type="text" class="form-control" placeholder="find friends...">
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="friend-list friend-list1 row">

                                    
                                    
                                </div>
                            </div>
                            <div class="see-all">
                                <a href="profile_friends" class="btn btn-solid">see all</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

<?php include("profile_chat_snippet.php"); ?>
<?php include("profile_footer.php"); ?>

   