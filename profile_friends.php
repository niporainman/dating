<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("profile_header.php"); ?>
<title><?php echo $company_name; ?> - Profile Friends</title>

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
                    <li>
                        <a href="profile_about">
                            <i class="iw-14 ih-14" data-feather="info"></i>
                            <h6>about</h6>
                        </a>
                    </li>
                    <li class="active">
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
                   
                    <div class="content-center col-xl-12">
                        
                        
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
                                <div class="friend-list friend-list2 row">
                                    
                                   
                                    
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>

        </div>

<?php include("profile_chat_snippet.php"); ?>
<?php include("profile_footer.php"); ?>

   