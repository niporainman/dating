<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("profile_header.php");
include("functions.php");
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<?php 
if (isset($_GET['user_id'])){
	$user_id_f = mysqli_real_escape_string($con,$_GET['user_id']);
    $sql = "SELECT username, first_name, last_name, email, bio, dob, location, country, profile_pic, profile_background, gender, looking_for, religion, acc_approved, email_confirmed, date_signed_up FROM users WHERE user_id = ?";
    $stmt_f = $con->prepare($sql);
    $stmt_f->bind_param("s", $user_id_f);
    $stmt_f->execute();
    $stmt_f -> store_result(); 
    $stmt_f -> bind_result($username_f, $first_name_f, $last_name_f, $email_f, $bio_f, $dob_f, $location_f, $country_f, $profile_pic_f, $profile_background_f, $gender_f, $looking_for_f, $religion_f, $acc_approved_f, $email_confirmed_f, $date_signed_up_f); 
    $numrows_f = $stmt_f -> num_rows();
    if ($numrows_f > 0) {
        while ($stmt_f -> fetch()) {
            $birthday_f = date_create($dob_f);
            $birthday_formatted_f = date_format($birthday_f,"jS F, Y");

            $joined_f = date_create($date_signed_up_f);
            $joined_formatted_f = date_format($joined_f,"jS F, Y");
        }
    }

    if($profile_pic_f == ""){
        $profile_pic_container_f = "images/profile_placeholder.jpg";
    }
    else{
        $profile_pic_container_f = "users/$user_id_f/$profile_pic_f";
    }

    if($profile_background_f == ""){
        $profile_background_container_f = "images/background_placeholder.png";
    }
    else{
        $profile_background_container_f = "users/$user_id_f/$profile_background_f";
    }

    //number of friends 
    $sql_nc1 = "SELECT COUNT(*) AS total FROM connections WHERE status = 'Accepted' AND (sender = ? OR receiver = ?)";
    $stmt_nc1 = $con->prepare($sql_nc1);
    $stmt_nc1->bind_param("ss", $user_id_f, $user_id_f);
    $stmt_nc1->execute();
    $result1 = $stmt_nc1->get_result()->fetch_assoc();
    $friend_count_f = $result1['total'];
    if($friend_count_f == 1){$s = "";}
    else{$s="s";}

    $age_f = calculate_age($dob_f);

}else{echo "<meta http-equiv=\"refresh\" content=\"0; url=profile_home\">";exit();}
?>
<title><?php echo $company_name; ?> - <?= $username_f ?></title>

        <div class="page-center">

            <!-- profile cover start -->
            <div class="profile-cover">
                <img src="<?= $profile_background_container_f ?>" class="img-fluid blur-up lazyload bg-img" alt="cover">
                <div class="profile-box d-lg-block d-none">
                    <div class="profile-content">
                        <div class="image-section">
                            <div class="profile-img">
                                <div>
                                    <img src="<?= $profile_pic_container_f ?>" class="img-fluid blur-up lazyload bg-img" alt="profile">
                                </div>
                                <span class="stats">
                                    <img src="images/verified.png" class="img-fluid blur-up lazyload" alt="verified">
                                </span>
                            </div>
                        </div>
                        <div class="profile-detail">
                            <h2><?= $first_name_f ?> <?= $last_name_f ?> <span>❤</span></h2>
                            <h5><?= $username_f ?></h5>
                            <div class="counter-stats" style='width:250px;'>
                                <ul id="counter">
                                    <li>
                                        <h3 class="counter-value" data-count="<?= $friend_count_f ?>">0</h3>
                                        <h5>friends</h5>
                                    </li>
                                   
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="setting-dropdown btn-group custom-dropdown arrow-none dropdown-sm">
                   
                   
                </div>
            </div>
            <div class="d-lg-none d-block">
                <div class="profile-box">
                    <div class="profile-content">
                        <div class="image-section">
                            <div class="profile-img">
                                <div>
                                    <img src="<?= $profile_pic_container_f ?>" class="img-fluid blur-up lazyload bg-img" alt="profile">
                                </div>
                                <span class="stats">
                                    <img src="images/verified.png" class="img-fluid blur-up lazyload" alt="verified">
                                </span>
                            </div>
                        </div>
                        <div class="profile-detail">
                            <h2><?= $first_name_f ?> <?= $last_name_f ?> <span>❤</span></h2>
                            <h5><?= $username_f ?></h5>
                            <div class="counter-stats" style='width:250px;text-align:center;margin:auto;'>
                                
                                    <br>
                                        <h3 style='font-weight:900;' class="counter-value"  data-count="<?= $friend_count_f ?>">0</h3>
                                        <h5>friends</h5>
                                    
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- profile cover end -->

            <!-- profile menu start -->
            <div class="profile-menu section-t-space">
                <ul>
                    <li>
                        <a href="profile_view?user_id=<?= $user_id_f; ?>">
                            <i class="iw-14 ih-14" data-feather="home"></i>
                            <h6>Home</h6>
                        </a>
                    </li>
                    <li>
                        <a href="profile_images_view?user_id=<?= $user_id_f; ?>">
                            <i class="iw-14 ih-14" data-feather="image"></i>
                            <h6>photos</h6>
                        </a>
                    </li>
                     <li class='active'>
                        <a href="profile_videos_view?user_id=<?= $user_id_f; ?>">
                            <i class="iw-14 ih-14" data-feather="video"></i>
                            <h6>video</h6>
                        </a>
                    </li>
                   
                </ul>
              
            </div>
            <!-- profile menu end -->
<?php 
if( are_friends($user_id, $user_id_f, $con) ){
    $display_content = "block";
    $display_warning = "none";
}
else{
    $display_content = "none";
    $display_warning = "block";
}
?>
<div class='container' style='display:<?= $display_warning ?>;'>
    <div class='row'>
        <div class='col-md-12 m-2'>
            <h3>To view this profile you need to be friends</h3>
        </div>
    </div>
</div>

<div class='container-fluid'>
    <div class='row'>
        <div class='col-12'>
            <div style='height:7px;'></div>
            <iframe src="friend_buttons.php?other_user=<?= $user_id_f ?>" frameborder="0" style='width:100%; height:35px; padding:0 !important; margin:0 !important;'></iframe>
        </div>
    </div>
</div>


 <div class="container-fluid section-t-space px-0" style='display:<?= $display_content ?>;'>
    <div class="page-content">
        <div class="content-center w-100">
            <!-- gallery section -->
            <div class="gallery-page-section section-b-space">
                
                <div class="tab-section">
                    
                    <div class="tab-content" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="photo" role="tabpanel" aria-labelledby="home-tab">
                            <!-- portfolio section start -->
                            <div class="portfolio-section">
                                <div class="row ratio_square">
<?php 
$video_word = "video";
$stmt_f = $con->prepare("SELECT file FROM files WHERE user_id = ? AND file_type = ?");
$stmt_f->bind_param("ss", $user_id_f, $video_word);
$stmt_f->execute();
$stmt_f -> store_result(); 
$stmt_f -> bind_result($file); 
$numrows_f = $stmt_f -> num_rows();
if ($numrows_f > 0) {
    while ($stmt_f -> fetch()) {
?>
<div class="col-xl-3 col-lg-4 col-6">
    <div class="portfolio-image">
        <a href="users/<?= $user_id_f ?>/<?= $file ?>" class="glightbox" data-gallery="gallery">
                <video
                    style="width: 100%; object-fit: cover;"
                    height="250"
                    muted
                    preload="metadata"
                    poster="images/thumbnail.jpg">
                    <source src="users/<?= $user_id_f ?>/<?= $file ?>" type="video/mp4">
                    Your browser does not support video.
                </video>
        </a>
    </div>
</div> 
<?php } } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>


<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
  const lightbox = GLightbox({
    selector: '.glightbox'
  });
</script>
<?php include("profile_chat_snippet.php"); ?>
<?php include("profile_footer.php"); ?>