<?php
session_start();
include 'minks1.php';

$currentUserId = $_SESSION['user_id'] ?? '';

if (!$currentUserId) {
    exit;
}

// Count pending requests for badge
$badgeQuery = $con->prepare("SELECT COUNT(*) AS pending_count FROM connections WHERE receiver = ? AND status = 'Pending'");
$badgeQuery->bind_param("s", $currentUserId);
$badgeQuery->execute();
$badgeResult = $badgeQuery->get_result()->fetch_assoc();
$badgeCount = $badgeResult['pending_count'] ?? 0;

// Get pending requests
$stmt = $con->prepare("
    SELECT c.sender, u.username, u.profile_pic
    FROM connections c
    JOIN users u ON c.sender = u.user_id
    WHERE c.receiver = ? AND c.status = 'Pending'
");
$stmt->bind_param("s", $currentUserId);
$stmt->execute();
$result = $stmt->get_result();

$requestsHTML = '';
while ($row = $result->fetch_assoc()) {
    $senderId = $row['sender'];
    $username = htmlspecialchars($row['username']);
    $profilePic = htmlspecialchars($row['profile_pic']);
    
    

    // Get mutual friends
    $mutualStmt = $con->prepare("
        SELECT COUNT(*) AS mutual_count
        FROM connections c1
        JOIN connections c2 ON (
            (c1.sender = c2.sender OR c1.sender = c2.receiver OR c1.receiver = c2.sender OR c1.receiver = c2.receiver)
        )
        WHERE c1.status = 'Accepted'
        AND c2.status = 'Accepted'
        AND c1.receiver = ? 
        AND ? IN (c2.sender, c2.receiver)
        AND ? NOT IN (c1.sender, c1.receiver)
    ");
    $mutualStmt->bind_param("sss", $currentUserId, $senderId, $senderId);
    $mutualStmt->execute();
    $mutualCount = $mutualStmt->get_result()->fetch_assoc()['mutual_count'] ?? 0;

    if($profilePic == ""){
       $profile_pic_request = "images/profile_placeholder.jpg";
    }
    else{
        $profile_pic_request = "users/$senderId/$profilePic";
    }

    $requestsHTML .= "
        <li>
            <div class='media'>
                <img src='$profile_pic_request' alt='user'>
                <div class='media-body'>
                    <div>
                        <h5 class='mt-0'><a href='profile_view?u=$senderId'>{$username}</a></h5>
                        <h6>{$mutualCount} mutual friend" . ($mutualCount == 1 ? '' : 's') . "</h6>
                    </div>
                </div>
            </div>
            <div class='action-btns'>
                <button class='btn btn-solid confirm-request' data-user='{$senderId}'>Confirm</button>
                <button class='btn btn-outline ms-1 delete-request' data-user='{$senderId}'>Delete</button>
            </div>
        </li>
    ";
}

echo json_encode([
    'badge' => $badgeCount,
    'html' => $requestsHTML ?: '<li><p class="text-center">No pending requests</p></li>'
]);
?>
