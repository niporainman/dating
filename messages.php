<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("minks.php");
include("functions.php");
?>
<style>
    @media (max-width: 700px) {
        li{display: none !important;}
    }
</style>
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
}else{
    echo "<meta http-equiv=\"refresh\" content=\"0; url=signin\">";
    exit();
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
?>



<!DOCTYPE html><html lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicons/favicon.png" type="image/x-icon">

    <link rel="icon" href="assets/images/favicons/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">

    <!-- Theme css -->
    <link id="change-link" rel="stylesheet" type="text/css" href="css/style.css">
    <title><?= $company_name ?> - Messenger</title>
</head>

<body>
    <!-- header start -->
    <header>
        
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


    <!-- messanger section start -->
    <section class="messanger-section">
        <div class="chat-users">
            <div class="user-header">
                <!--<a href="index.html" class="back-btn d-block d-sm-none">
                    <i class="ih-18 iw-18" data-feather="arrow-left"></i>
                </a>-->
                <div class="search-bar">
                    <i data-feather="search" class="icon-theme icon iw-16"></i>
                    <input type="text" class="form-control" placeholder="find friends...">
                </div>
                <a class="new-chat" href="#"><i class="icon-light iw-14 ih-14" data-feather="edit"></i></a>
            </div>
<?php 
$currentUserId = $_SESSION['user_id'];
$chatWithId = $_GET['chat_with'];
?>
<ul class="nav nav-tabs" id="previewPane" role="tablist">

</ul>
        </div>


<div class="chat-content">
<div class="tab-content" id="myTabContent">
<div class="tab-pane fade show active" id="" role="tabpanel" aria-labelledby="">
<?php 
// Get selected user info
$stmt1 = $con->prepare("SELECT username, profile_pic, location, bio, last_active FROM users WHERE user_id = ?");
$stmt1->bind_param("s", $chatWithId);
$stmt1->execute();
$user = $stmt1->get_result()->fetch_assoc();

// Fetch messages between current user and selected user
$stmt = $con->prepare("SELECT * FROM messages 
    WHERE (sender_id = ? AND receiver_id = ?) 
       OR (sender_id = ? AND receiver_id = ?) 
    ORDER BY timestamp ASC");
?>
    <div class="tab-box">
        <div class="user-chat">
            <div class="user-title">
                <div class="back-btn d-block d-sm-none">
                    <a href='messages_preview'><i data-feather="arrow-left"></i></a>
                </div>
                <div class="media list-media">
                    <div class="story-img">
                        <div class="user-img">
                            <img src="users/<?= $chatWithId ?>/<?= $user['profile_pic'] ?>" class="img-fluid blur-up lazyload bg-img" alt="user">
                            <img src="" alt="">
                        </div>
                    </div>
                    <div class="media-body">
                        <h5><?= htmlspecialchars($user['username']) ?></h5>
                        <h6 id="chatStatus" class="text-muted">loading...</h6>
                    </div>
                </div>
                
            </div>
            <div class="chat-history">
                <div class="avenue-messenger">
                    <div class="chat">
                        <div class="messages-content">
                           <?php 
                            $stmt->bind_param("ssss", $currentUserId, $chatWithId, $chatWithId, $currentUserId);
                            $stmt->execute();
                            $messages = $stmt->get_result();
                            while ($row = $messages->fetch_assoc()) {
                                $class = ($row['sender_id'] === $currentUserId) ? 'message-personal' : '';
                                echo '<div class="message ' . $class . ' new">';
                                echo nl2br(htmlspecialchars($row['message']));
                                echo '<div class="timestamp">' . date('h:i A', strtotime($row['timestamp'])) . '</div>';
                                echo '</div>';
                            }
                           ?>
                        </div>
<div id="newMessageBadge" style="
    display: none;
    position: absolute;
    bottom: 60px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #007bff;
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    z-index: 10;
">
    New messages
</div>


                        <div class="message-box">
                            <textarea id="messageInput" class="message-input emojiPicke" placeholder="Type message... "></textarea>
                            <a href="#" id="sendBtn" class="message-submit"><i data-feather="send"></i></a>
                            <input type="hidden" id="receiverId" value="<?= $chatWithId ?>">
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- USER INFO -->
        <div class="user-info">
            <div class="back-btn d-lg-none d-block">
                <i data-feather="x" class="icon-theme"></i>
            </div>
            <div class="user-image">
                <img src="users/<?= $chatWithId ?>/<?= $user['profile_pic'] ?>" class="img-fluid blur-up lazyload bg-img" alt="">
            </div>
            <div class="user-name">
                <h5><?= htmlspecialchars($user['username']) ?></h5>
                <h6><?= htmlspecialchars($user['location']) ?></h6>
                <p><?= nl2br(htmlspecialchars($user['bio'])) ?></p>
            </div>

           
        </div>
    </div>
</div>
<?php 





?>             
               

</div>
</div>
    </section>
    <!-- messanger section end -->


    


    <!-- latest jquery-->
    <script src="js/jquery-3.6.0.min.js"></script>

    <!-- popper js-->
    <script src="js/popper.min.js"></script>

    <!-- feather icon js-->
    <script src="js/feather.min.js"></script>

    <!-- emoji picker js-->
    <script src="js/emojionearea.min.js"></script>

    <!-- messanger js -->
    <script src="js/jquery-migrate-1.4.1.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/messanger.js"></script>

    <!-- Bootstrap js-->
    <script src="js/bootstrap.js"></script>

    <!-- lazyload js-->
    <script src="js/lazysizes.min.js"></script>

    <!-- theme setting js-->
    <script src="js/theme-setting.js"></script>

    <!-- Theme js-->
    <script src="js/script.js"></script>

    <script src="js/chat.scroll.js"></script>
    <script src="js/chat.load.js"></script>
    <script src="js/chat.send.js"></script>
    <script src="js/chat.status.js"></script>
    <script src="js/chat.preview.js"></script>

     <script src='js/sweetalert.js'></script>

    <script src='js/ajax_scripts.js'></script>

    <script src='js/connection_scripts.js'></script>

    <script src='js/search_scripts.js'></script>

    <script src='js/friend_requests.js'></script>

    <script src='js/requests_count.js'></script>

    <script src='js/chat.dropdown.js'></script>

    <script src="js/chat_notifications.js"></script>

    <script src='js/load_online_friends.js'></script>

    <script src='js/friends.js'></script>

    <script src='js/friends_full.js'></script>


    <script>
        feather.replace();
        $(".emojiPicker").emojioneArea({
            inline: true,
            placement: 'absright',
            pickerPosition: "top",
        });
    </script>

<script>
setInterval(() => {
    fetch('update_activity.php');
}, 60000); // Every minute
</script>




</body></html>