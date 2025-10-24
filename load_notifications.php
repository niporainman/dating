<?php
session_start();
include 'minks1.php';

$currentUserId = $_SESSION['user_id'] ?? null;
if (!$currentUserId) exit;

// Get unread count
$unreadStmt = $con->prepare("SELECT COUNT(*) as unread_count FROM notifications WHERE user_id = ? AND is_read = 0");
$unreadStmt->bind_param("s", $currentUserId);
$unreadStmt->execute();
$unreadResult = $unreadStmt->get_result()->fetch_assoc();
$unreadCount = $unreadResult['unread_count'] ?? 0;

// Fetch latest notifications
$stmt = $con->prepare("
    SELECT n.*, u.username, u.profile_pic 
    FROM notifications n 
    JOIN users u ON u.user_id = n.from_user_id 
    WHERE n.user_id = ? 
    ORDER BY n.timestamp DESC 
    LIMIT 10
");
$stmt->bind_param("s", $currentUserId);
$stmt->execute();
$result = $stmt->get_result();

$response = [
    'unread_count' => $unreadCount,
    'html' => ''
];

while ($row = $result->fetch_assoc()) {
    $person_user_id = $row['from_user_id'];
    $unreadClass = $row['is_read'] ? '' : 'unread';
    $response['html'] .= '
    <li class="d-block ' . $unreadClass . '">
        <div class="media">
            <img src="users/' . htmlspecialchars($row['from_user_id']) . '/' . htmlspecialchars($row['profile_pic']) . '" alt="user">
            <div class="media-body">
                <div>
                    <h5 class="mt-0"><a href="profile_view.php?u=' . $person_user_id . '">' . htmlspecialchars($row['username']) . '</a> ' . htmlspecialchars($row['message']) . '</h5>
                </div>
            </div>
        </div>
    </li>';
}

header('Content-Type: application/json');
echo json_encode($response);
