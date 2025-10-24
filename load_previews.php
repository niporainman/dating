<?php
session_start();
include 'minks1.php'; // Your DB connection
include 'functions.php'; // If you have time_elapsed_string() here

if (!isset($_SESSION['user_id'])) {
    exit('Not logged in');
}

$currentUserId = $_SESSION['user_id'];
$chatWithId = $_GET['chat_with'] ?? null;



// If you don’t already have time_elapsed_string in functions.php, include this:
if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $string = [
            'y' => 'year', 'm' => 'month', 'd' => 'day',
            'h' => 'hour', 'i' => 'minute', 's' => 'second',
        ];

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

// STEP 1: Get all chat partners and latest message timestamps
$partnerQuery = "
    SELECT 
        CASE 
            WHEN sender_id = ? THEN receiver_id 
            ELSE sender_id 
        END AS user_id,
        MAX(timestamp) AS last_message_time
    FROM messages
    WHERE sender_id = ? OR receiver_id = ?
    GROUP BY user_id
";

$stmt = $con->prepare($partnerQuery);
$stmt->bind_param("sss", $currentUserId, $currentUserId, $currentUserId);
$stmt->execute();
$partnerResult = $stmt->get_result();

$recentChats = [];
while ($row = $partnerResult->fetch_assoc()) {
    $recentChats[$row['user_id']] = $row['last_message_time'];
}

// STEP 2: For each partner, render their preview
foreach ($recentChats as $partnerId => $lastTime) {
    if (!$partnerId || $partnerId == $currentUserId) continue;

    // Get partner info
    $userStmt = $con->prepare("SELECT username, profile_pic, last_active FROM users WHERE user_id = ?");
    $userStmt->bind_param("s", $partnerId);
    $userStmt->execute();
    $userInfo = $userStmt->get_result()->fetch_assoc();

    if (!$userInfo) continue;

    // Get unread count
    $unreadStmt = $con->prepare("SELECT COUNT(*) AS unread FROM messages WHERE sender_id = ? AND receiver_id = ? AND is_read = 0");
    $unreadStmt->bind_param("ss", $partnerId, $currentUserId);
    $unreadStmt->execute();
    $unread = $unreadStmt->get_result()->fetch_assoc()['unread'] ?? 0;

    // Get last message
    $msgStmt = $con->prepare("
        SELECT message, timestamp FROM messages 
        WHERE ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))
        AND timestamp = ?
        LIMIT 1
    ");
    $msgStmt->bind_param("sssss", $currentUserId, $partnerId, $partnerId, $currentUserId, $lastTime);
    $msgStmt->execute();
    $msgInfo = $msgStmt->get_result()->fetch_assoc();

    $previewMsg = $msgInfo ? (strlen($msgInfo['message']) > 40 ? substr($msgInfo['message'], 0, 40) . "..." : $msgInfo['message']) : '';
    $previewTime = $msgInfo ? date('h:i A', strtotime($msgInfo['timestamp'])) : '';

    $isOnline = isOnline($userInfo['last_active']);
    $activeClass = ($chatWithId === $partnerId) ? 'active' : '';

    ?>
    <li class="nav-item">
        <a class="nav-link <?= $activeClass ?>" href="messages.php?chat_with=<?= htmlspecialchars($partnerId) ?>">
            <div class="media list-media">
                <div class="story-img">
                    <div class="user-img">
                        <img src="users/<?= htmlspecialchars($partnerId) ?>/<?= htmlspecialchars($userInfo['profile_pic']) ?>" class="img-fluid blur-up lazyload bg-img" alt="user" style='border-radius:50%;'>
                        <span class="status-indicator <?= $isOnline ? 'online' : 'offline' ?>"></span>
                    </div>
                </div>
                <div class="media-body">
                    <h5>
                        <?= htmlspecialchars($userInfo['username']) ?> 
                        <span><?= $previewTime ?></span>
                    </h5>
                    <h6><?= $isOnline ? 'online' : 'last seen: ' . time_elapsed_string($userInfo['last_active']) ?></h6>
                </div>
               
            </div>
            <div class="chat">
            <h6><?= htmlspecialchars($previewMsg) ?></h6>
             <?php if ($unread > 0): ?>
                    <span class="count"><?= $unread ?></span>
                <?php endif; ?>
            </div>
        </a>
        
    </li>
    <?php
}
?>

