<?php include("minks.php"); ?>
<?php
if (isset($_SESSION['email'])){
	$email = $_SESSION['email'];
	$first_name = $_SESSION['first_name'];
	$user_id = $_SESSION['user_id'];
	}
else{
	echo "<meta http-equiv=\"refresh\" content=\"0; url=signin\">";
	exit();
    }
	?>
<?php 
$sql = "SELECT username, first_name, last_name, email, bio, dob, location, country, profile_pic, profile_background, gender, looking_for, religion, acc_approved, email_confirmed, date_signed_up FROM users WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt -> store_result(); 
$stmt -> bind_result($username, $first_name, $last_name, $email, $bio, $dob, $location, $country, $profile_pic, $profile_background, $gender, $looking_for, $religion, $acc_approved, $email_confirmed, $date_signed_up); 
$numrows = $stmt -> num_rows();
if ($numrows > 0) {
    while ($stmt -> fetch()) {
        $birthday = date_create($dob);
        $birthday_formatted = date_format($birthday,"jS F, Y");

        $joined = date_create($date_signed_up);
        $joined_formatted = date_format($joined,"jS F, Y");
    }
}

if($profile_pic == ""){
    $profile_pic_container = "images/profile_placeholder.jpg";
}
else{
    $profile_pic_container = "users/$user_id/$profile_pic";
}

if($profile_background == ""){
    $profile_background_container = "images/background_placeholder.png";
}
else{
    $profile_background_container = "users/$user_id/$profile_background";
}

    function calculate_age($dob) {
        if (empty($dob)) return null;
        $birthDate = new DateTime($dob);
        $today = new DateTime('today');
        return $birthDate->diff($today)->y;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicons/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Theme css -->
    <link id="change-link" rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  


    <!-- header start -->
    <header>
        <div class="mobile-fix-menu"></div>
        <div class="container-fluid custom-padding">
            <div class="header-section">
                <div class="header-left">
                    <div class="brand-logo">
                        <a href="profile_home">
                            <img src="assets/images/logo.png" alt="logo" class="img-fluid blur-up lazyload">
                        </a>
                    </div>
                    
                    <ul class="btn-group">
                        <!-- home -->
                        <li class="header-btn home-btn">
                            <a class="main-link" href="profile_home">
                                <i class="icon-light stroke-width-3 iw-16 ih-16" data-feather="home"></i>
                            </a>
                        </li>
                        <!-- add friend -->
                        <li class="header-btn custom-dropdown dropdown-lg add-friend">
                            <a class="main-link" href="javascript:void(0)" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-light stroke-width-3 iw-16 ih-16" data-feather="user-plus"></i>
                                <span class="badge bg-danger" id="friendRequestBadge" style="position: absolute; top: -6px; right: -2px; font-size: 10px; display: none; background:forestgreen !important; border-radius:50%;">0</span>
                            </a>

                            <div class="dropdown-menu">
                                <div class="dropdown-header" style='background:lightgrey;'>
                                    <span>friend requests</span>
                                    <div class="mobile-close" style='position:relative; left:-70px;'>
                                        <h5>close</h5>
                                    </div>
                                </div>
                                <div class="dropdown-content">
                                    <ul class="friend-list"></ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                    <?php 
                    $sql_nc = "SELECT COUNT(*) AS total FROM connections WHERE status = 'Accepted' AND (sender = ? OR receiver = ?)";
                    $stmt_nc = $con->prepare($sql_nc);
                    $stmt_nc->bind_param("ss", $user_id, $user_id);
                    $stmt_nc->execute();
                    $result = $stmt_nc->get_result()->fetch_assoc();
                    $friend_count = $result['total'];
                    if($friend_count == 1){$s = "";}
                    else{$s="s";}
                    ?>
                <div class="header-right">
                    <div class="post-stats">
                        <ul>
                            <li>
                                <h3><?= $friend_count ?></h3>
                                <span>friend<?= $s ?></span>
                            </li>
                        </ul>
                    </div>
                    <ul class="option-list">
                        <!-- message -->
                        <li class="header-btn custom-dropdown dropdown-lg btn-group message-btn">
                            <a class="main-link" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-light stroke-width-3 iw-16 ih-16" data-feather="message-circle"></i>
                                <span class="count success" id="messageCount">0</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header">
                                    <div class="left-title">
                                        <span>Messages</span>
                                    </div>
                                    <div class="mobile-close">
                                        <h5>Close</h5>
                                    </div>
                                </div>
                                <div class="search-bar input-style icon-left">
                                    <i class="iw-16 ih-16 icon" data-feather="search"></i>
                                    <input type="text" class="form-control" id="messageSearchInput" placeholder="search messages...">
                                </div>
                                <div class="dropdown-content">
                                    <ul class="friend-list" id="messagePreviewList"></ul>
                                </div>
                            </div>
                        </li>

                        <!-- dark/light -->
                        <li class="header-btn custom-dropdown">
                            <a id="dark" class="main-link" href="javascript:void(0)">
                                <i class="icon-light stroke-width-3 iw-16 ih-16" data-feather="moon"></i>
                            </a>
                            <a id="light" class="main-link d-none" href="javascript:void(0)">
                                <i class="icon-light stroke-width-3 iw-16 ih-16" data-feather="sun"></i>
                            </a>
                        </li>
                        <!-- mobile app button -->
                        <li class="header-btn custom-dropdown d-md-none d-block app-btn">
                            <a class="main-link" href="javascript:void(0)">
                                <i class="icon-light stroke-width-3 iw-16 ih-16" data-feather="grid"></i>
                            </a>
                            <div class="overlay-bg app-overlay"></div>
                            <div class="app-box">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="app-icon">
                                            <a href="profile_home">
                                                <div class="icon">
                                                    <i data-feather="home" class="bar-icon"></i>
                                                </div>
                                                <h5>Profile Home</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="app-icon">
                                            <a href="profile_about">
                                                <div class="icon">
                                                    <i data-feather="file" class="bar-icon"></i>
                                                </div>
                                                <h5>About</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="app-icon">
                                            <a href="profile_friends">
                                                <div class="icon">
                                                    <i data-feather="users" class="bar-icon"></i>
                                                </div>
                                                <h5>Friends</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="app-icon">
                                            <a href="profile_images">
                                                <div class="icon">
                                                    <i data-feather="image" class="bar-icon"></i>
                                                </div>
                                                <h5>Photos</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="app-icon">
                                            <a href="profile_videos">
                                                <div class="icon">
                                                    <i data-feather="video" class="bar-icon"></i>
                                                </div>
                                                <h5>Videos</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="app-icon">
                                            <a href="profile_search">
                                                <div class="icon">
                                                    <i data-feather="search" class="bar-icon"></i>
                                                </div>
                                                <h5>Search</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="app-icon">
                                            <a href="logout">
                                                <div class="icon">
                                                     <i data-feather="power" class="bar-icon"></i>
                                                </div>
                                                <h5>Log out</h5>
                                            </a>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </li>
                        <!-- notification -->
                        <li class="header-btn custom-dropdown dropdown-lg btn-group notification-btn">
                            <a class="main-link" href="javascript:void(0)" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-light stroke-width-3 iw-16 ih-16" data-feather="bell"></i><span class="count warning" id="notifBadge">0</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header">
                                    <span>Notifications</span>
                                    <div class="mobile-close">
                                        <h5>close</h5>
                                    </div>
                                </div>
                                <div class="dropdown-content">
                                    <ul class="friend-list" id='notificationList'>
                                        <li>Loading...</li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- profile -->
                        <li class="header-btn custom-dropdown profile-btn btn-group">
                            <a class="main-link" href="javascrip:void(0)" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!--<i class="icon-light stroke-width-3 d-sm-none d-block iw-16 ih-16" data-feather="user"></i>-->
                                <div class="media d-none d-sm-flex">
                                    <div class="user-img">
                                        <img src="<?= $profile_pic_container ?>" class="img-fluid blur-up lazyload bg-img" alt="user">
                                        <span class="available-stats online"></span>
                                    </div>
                                    <div class="media-body d-none d-md-block">
                                        <h4><?php echo "$first_name $last_name" ?></h4>
                                        <span>active</span>
                                    </div>
                                </div>
                            </a>
                            <!--<div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header">
                                    <span>profile</span>
                                    <div class="mobile-close">
                                        <h5>close</h5>
                                    </div>
                                </div>
                                <div class="dropdown-content">
                                    <ul class="friend-list">
                                        <li>
                                            <a href="profile.html">
                                                <div class="media">
                                                    <i data-feather="user"></i>
                                                    <div class="media-body">
                                                        <div>
                                                            <h5 class="mt-0">Profile</h5>
                                                            <h6>Profile preview & settings</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="settings.html">
                                                <div class="media">
                                                    <i data-feather="settings"></i>
                                                    <div class="media-body">
                                                        <div>
                                                            <h5 class="mt-0">setting & privacy</h5>
                                                            <h6>all settings & privacy</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="help-support.html">
                                                <div class="media">
                                                    <i data-feather="help-circle"></i>
                                                    <div class="media-body">
                                                        <div>
                                                            <h5 class="mt-0">help & support</h5>
                                                            <h6>browse help here</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="logout">
                                                <div class="media">
                                                    <i data-feather="log-out"></i>
                                                    <div class="media-body">
                                                        <div>
                                                            <h5 class="mt-0">log out</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>-->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->
    

    <!-- page body start -->
    <div class="page-body container-fluid custom-padding profile-page">

     <!-- sidebar panel start -->
        <div class="sidebar-panel">
            <div class="main-icon">
                <a href="<?= $link ?>">
                    <i data-feather="grid" class="bar-icon"></i>
                    <div class="tooltip-cls">
                        <span>Main Site</span>
                    </div>
                </a>
            </div>
            <ul class="sidebar-icon">
                <li>
                    <a href="profile_home">
                        <i data-feather="home" class="bar-icon"></i>
                        <div class="tooltip-cls">
                            <span>Home</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="profile_about">
                        <i data-feather="file-text" class="bar-icon"></i>
                        <div class="tooltip-cls">
                            <span>About</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="profile_friends">
                        <i data-feather="users" class="bar-icon"></i>
                        <div class="tooltip-cls">
                            <span>Friends</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="profile_images">
                        <i data-feather="image" class="bar-icon"></i>
                        <div class="tooltip-cls">
                            <span>Photos</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="profile_videos">
                        <i data-feather="video" class="bar-icon"></i>
                        <div class="tooltip-cls">
                            <span>Videos</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="profile_search">
                        <i data-feather="search" class="bar-icon"></i>
                        <div class="tooltip-cls">
                            <span>Search</span>
                        </div>
                    </a>
                </li>
               
                
            </ul>
            <div class="main-icon">
                <a href="logout">
                    <i data-feather="power" class="bar-icon"></i>
                </a>
            </div>
        </div>
        <!-- sidebar panel end -->