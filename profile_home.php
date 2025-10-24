<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("profile_header.php"); 
include("functions.php");
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<title><?php echo $company_name; ?> - Profile Home</title>



<div class="page-center">
    <!--  event cover start -->
    <div class="event-cover">
        <div class="event-img">
            <img src="images/cover.jpg" class="img-fluid blur-up lazyload bg-img" alt="">
            <div class="event-content">
                <h1>PROFILE HOME</h1>
            </div>
            <div class="cover-img-detail">
                <span><?php $todays_date = date("jS, F Y"); echo $todays_date; ?></span>
                <h3>Hello <?= $first_name ?>!</h3>
            </div>
            
        </div>
    </div>
    <!--  event cover end -->

    <!-- stroy section start -->
    <div class="event-category music-slider-section section-t-space">
        <div class="event-title">
            <div class="content">
                <h3 style='font-weight:700;'>Your Matches</h3>
                <h6>select a match and start conversing!</h6>
            </div>
        </div>
        <div class="col-10 suggestion-box">
            <div class="music-slider ratio_115 no-arrow default-space">
<?php
$stmt_f = $con -> prepare("SELECT sender,receiver FROM connections WHERE status = 'Accepted' AND (sender = ? OR receiver = ?) ORDER BY RAND()");
$stmt_f -> bind_param("ss", $user_id,$user_id);
$stmt_f -> execute(); 
$stmt_f -> store_result(); 
$stmt_f -> bind_result($sender_id, $receiver_id); 
$numrows_f = $stmt_f -> num_rows();
if($numrows_f > 0){
    while ($stmt_f -> fetch()) { 
        if($sender_id == $user_id){
           $friend_id = $receiver_id;
        }
        else{
            $friend_id = $sender_id;
        }
        $friend_score = calculate_compatibility_by_ids($user_id, $friend_id, $con);
        //grab friend details
        $stmt_fr = $con -> prepare("SELECT username, profile_pic FROM users WHERE user_id = ?");
        $stmt_fr -> bind_param("s", $friend_id);
        $stmt_fr -> execute(); 
        $stmt_fr -> store_result(); 
        $stmt_fr -> bind_result($friend_username, $friend_profile_pic); 
        $numrows_fr = $stmt_fr -> num_rows();
        if($numrows_fr > 0){
            while ($stmt_fr -> fetch()) { 
                if($friend_profile_pic == ""){
                    $friend_pic_placeholder = "images/profile_placeholder.jpg";
                }
                else{
                    $friend_pic_placeholder = "users/$friend_id/$friend_profile_pic";
                }
            }
        }
?>
    <div>
        <a href="profile_view.php?user_id=<?= $friend_id ?>">
            <div class="story-box">
                <div class="adaptive-overlay"></div>
                <div class="story-bg">
                    <img src="<?= $friend_pic_placeholder ?>" class="img-fluid blur-up lazyload bg-img" data-adaptive-background="1" alt="<?= $friend_username ?>">
                </div>
                <div class="story-content">
                    <h6><?= $friend_username ?></h6>
                    <span class="player"><i class="icon-light iw-10 ih-10" data-feather="user"></i><?= $friend_score ?>% Match</span>
                </div>
            </div>
        </a>
    </div>
<?php } } ?>
            </div>
        </div>
    </div>

    <!-- main section i.e left, middle, right -->
    <div class='container-fluid section-t-space px-0 layout-default'>
        <div class='page-content'>

<div class='content-left'>
    <!-- match suggestions -->
    <div class="suggestion-box">
        <div class="card-title">
            <h3>match suggestions</h3>
        </div>
        <div class="suggestion-content ratio_115">
            <div class="slide-2 no-arrow default-space">
<?php
// Step 1: Get current user data
$stmt = $con->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$currentUser = $stmt->get_result()->fetch_assoc();
if (!$currentUser) exit("User not found");

// Step 2: Get list of accepted friends
$currentUserId = $user_id;
$friends = [];
$friendStmt = $con->prepare("SELECT sender, receiver FROM connections WHERE status = 'Accepted' AND (sender = ? OR receiver = ?)");
$friendStmt->bind_param("ss", $currentUserId, $currentUserId);
$friendStmt->execute();
$friendResult = $friendStmt->get_result();

while ($row = $friendResult->fetch_assoc()) {
    $friendId = $row['sender'] === $currentUserId ? $row['receiver'] : $row['sender'];
    $friends[] = $friendId;
}

// Step 3: Get all users except current user
$usersQuery = $con->prepare("SELECT * FROM users WHERE user_id != ?");
$usersQuery->bind_param("s", $currentUserId);
$usersQuery->execute();
$usersResult = $usersQuery->get_result();

$matches = [];

while ($row = $usersResult->fetch_assoc()) {
    if (in_array($row['user_id'], $friends)) {
        continue; // skip friends
    }

    $score = calculate_compatibility($currentUser, $row, $con);
    $matches[] = [
        'user_id' => $row['user_id'],
        'username' => $row['username'],
        'profile_pic' => $row['profile_pic'] ?: 'default.jpg',
        'match_score' => $score
    ];
}

// Sort by match_score descending
usort($matches, fn($a, $b) => $b['match_score'] <=> $a['match_score']);

// Limit to top 5 matches
$topMatches = array_slice($matches, 0, 15);

// Step 4: Display results
foreach ($topMatches as $match):
    $uid = htmlspecialchars($match['user_id']);
    $uname = htmlspecialchars($match['username']);
    $pic = htmlspecialchars($match['profile_pic']);
    $score = $match['match_score'];
?>
    <div>
        <a href="profile_view.php?user_id=<?= $uid ?>">
        <div class="story-box">
            <div class="adaptive-overlay pink-overlay"></div>
            <div class="story-bg">
                <img src="users/<?= $uid ?>/<?= $pic ?>" class="img-fluid bg-img" data-adaptive-background="1" alt="<?= $uname ?>">
            </div>
            <div class="story-content">
                <h6><?= $uname ?></h6>
                <span class="player"><i class="icon-light iw-10 ih-10" data-feather="user"></i><?= $score ?>% Match</span>
            </div>
        </div>
        </a>
    </div>
<?php endforeach; ?>               
                
            </div>
        </div>
    </div>
     <!-- profile box -->
    <div class="profile-box section-t-space">
        <div class="profile-setting">
           
            <div class="setting-btn setting setting-dropdown">
                <div class="btn-group custom-dropdown arrow-none dropdown-sm">
                    <a href="#" class="d-flex" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon icon-theme stroke-width-3 iw-11 ih-11" data-feather="sun"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right custom-dropdown">
                        <ul>
                            <li>
                                <a href="profile_edit"><i class="icon-font-light iw-16 ih-16" data-feather="edit"></i>edit profile</a>
                            </li>
                            <li>
                                <a href="profile_about"><i class="icon-font-light iw-16 ih-16" data-feather="user"></i>view profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-content">
            <a href="profile.html" class="image-section">
                <div class="profile-img">
                    <div>
                        <img src="<?= $profile_pic_container ?>" class="img-fluid blur-up lazyload bg-img" alt="profile">
                    </div>
                    <span class="stats">
                        <img src="images/verified.png" class="img-fluid blur-up lazyload" alt="verified">
                    </span>
                </div>
            </a>
            <div class="profile-detail">
                <a href="profile_about">
                    <h2><?php echo "$first_name $last_name"; ?> <span>❤</span></h2>
                </a>
                <h5><?= $username ?></h5>
                <div class="description">
                    <p>
                    </p>
                </div>
                <div class="counter-stats">
                    <ul id="counter">
                        
                        <li>
                            <h3 class="counter-value" data-count="<?= $friend_count; ?>">0</h3>
                            <h5>Friends</h5>
                        </li>
                      
                    </ul>
                </div>
                <a href="profile_about" class="btn btn-solid">view profile</a>
            </div>
        </div>
    </div>
</div>

<div class='content-center'>
    <!-- gallery section -->
    <div class="gallery-section">
        <div class="gallery-top">
            <div class="card-title">
                <h3>gallery</h3>
                <?php 
                $stmt_ph = $con->prepare("SELECT COUNT(*) AS total FROM files WHERE file_type = 'image' AND user_id = ?");
                $stmt_ph->bind_param("s", $user_id);
                $stmt_ph->execute();
                $resultph = $stmt_ph->get_result()->fetch_assoc();
                $no_photos = $resultph['total'];
                ?>
                <h5><?= $no_photos ?> photos</h5>
                <div class="settings">
                    
                    <div class="setting-btn ms-2 setting-dropdown">
                        <div class="btn-group custom-dropdown arrow-none dropdown-sm">
                            <a href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-dark stroke-width-3 icon iw-11 ih-11" data-feather="sun"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right custom-dropdown">
                                <ul>
                                    <li>
                                        <a href="profile_images"><i class="icon-font-light iw-16 ih-16" data-feather="edit"></i>View All Photos</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
// Fetch up to 6 image files
$stmt_fi = $con->prepare("SELECT file FROM files WHERE user_id = ? AND file_type = 'image' ORDER BY RAND() LIMIT 6");
$stmt_fi->bind_param("s", $user_id);
$stmt_fi->execute();
$result = $stmt_fi->get_result();

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[] = $row['file'];
}
?>

<div class="portfolio-section ratio_square">
    <div class="container-fluid p-0">
        <div class="row g-2">
            <?php if (isset($images[0])): ?>
                <div class="col-4">
                    <div class="overlay">
                        <div class="portfolio-image">
                            <a href="users/<?= $user_id ?>/<?= $images[0] ?>" class="glightbox" data-gallery="gallery">
                                <img src="users/<?= $user_id ?>/<?= $images[0] ?>" class="img-fluid blur-up lazyload bg-img" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($images[1])): ?>
                <div class="col-4">
                    <div class="overlay">
                        <div class="portfolio-image">
                            <a href="users/<?= $user_id ?>/<?= $images[1] ?>" class="glightbox" data-gallery="gallery">
                                <img src="users/<?= $user_id ?>/<?= $images[1] ?>" class="img-fluid blur-up lazyload bg-img" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($images[2])): ?>
                <div class="col-4">
                    <div class="overlay">
                        <div class="portfolio-image">
                            <a href="users/<?= $user_id ?>/<?= $images[2] ?>" class="glightbox" data-gallery="gallery">
                                <img src="users/<?= $user_id ?>/<?= $images[2] ?>" class="img-fluid blur-up lazyload bg-img" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-4 row m-0">
                <?php if (isset($images[3])): ?>
                    <div class="col-12 pt-cls p-0">
                        <div class="overlay">
                            <div class="portfolio-image">
                                <a href="users/<?= $user_id ?>/<?= $images[3] ?>" class="glightbox" data-gallery="gallery">
                                    <img src="users/<?= $user_id ?>/<?= $images[3] ?>" class="img-fluid blur-up lazyload bg-img" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($images[4])): ?>
                    <div class="col-12 pt-cls p-0">
                        <div class="overlay">
                            <div class="portfolio-image">
                                <a href="users/<?= $user_id ?>/<?= $images[4] ?>" class="glightbox" data-gallery="gallery">
                                    <img src="users/<?= $user_id ?>/<?= $images[4] ?>" class="img-fluid blur-up lazyload bg-img" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (isset($images[5])): ?>
                <div class="col-8">
                    <div class="overlay">
                        <div class="portfolio-image">
                            <a href="users/<?= $user_id ?>/<?= $images[5] ?>" class="glightbox" data-gallery="gallery">
                                <img src="users/<?= $user_id ?>/<?= $images[5] ?>" class="img-fluid blur-up lazyload bg-img" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

    </div>
    <!-- event -->
<?php
	$stmt = $con -> prepare("SELECT * FROM blog WHERE featured = 'Yes' LIMIT 1"); 
	$stmt -> execute(); 
	$stmt -> store_result(); 
	$stmt -> bind_result($id,$blog_id,$blog_heading,$blog_category,$blog_preamble,$blog_body,$blog_picture,$blog_featured,$blog_date,$keywords,$comments_allowed); 
	$numrows = $stmt -> num_rows();
	if($numrows > 0){
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
    <div class="event-box section-t-space ratio2_3">
        <div class="image-section">
            <img src="site_img/blog/<?php echo $blog_picture; ?>" class="img-fluid blur-up lazyload bg-img" alt="event">
            <div class="card-title">
                <h3>Dating Tips</h3>
            </div>
        </div>
        <div class="event-content">
            <h3><?= $blog_heading; ?></h3>
            <h6><?= $blog_date_formatted ?></h6>
            <p><?= $blog_preamble ?></p>
            <div class="bottom-part">
                <a href="article_details?article_id=<?php echo $blog_id; ?>" class="event-btn">Read More</a>
            </div>
        </div>
    </div>
    <?php } } ?>
</div>

<div class='content-right'>
    <!-- profile interests -->
    <div class="profile-about">
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
         <!-- profile interests -->
    <div class="about-profile section-t-space">
        <div class="card-title">
            <h3>about</h3>
            <h5>Your Interests</h5>
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
</div>

        </div>
    </div>
    <!-- main section ended -->

</div>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
  const lightbox = GLightbox({
    selector: '.glightbox'
  });
</script>

<!-- conversation panel start -->
<div class="conversation-panel xl-light">
    <div class="panel-header">
        <h2>friends</h2>
        <h5>start new conversation</h5>
       
    </div>
    <div class="friend-section">
        <div id="accordion" class="friend-list collapse show">
            <ul id="onlineFriends"></ul>
        </div>
    </div>
    
</div>
<!-- conversation panel end -->
<?php include("profile_footer.php"); ?>

   