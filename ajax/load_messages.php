<?php
session_start();
include '../minks1.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['chat_with'])) {
    http_response_code(400);
    echo "Invalid request";
    exit;
}


if (isset($_SESSION['user_id'])) {
    //$now = date('Y-m-d H:i:s');
    $now = time();
    $update = $con->prepare("UPDATE users SET last_active = ? WHERE user_id = ?");
    $update->bind_param("ss", $now, $_SESSION['user_id']);
    $update->execute();
}


$currentUserId = $_SESSION['user_id'];
$chatWithId = $_GET['chat_with'];

// Mark messages as read
$markReadStmt = $con->prepare("
    UPDATE messages 
    SET is_read = 1 
    WHERE sender_id = ? AND receiver_id = ? AND is_read = 0
");
$markReadStmt->bind_param("ss", $chatWithId, $currentUserId);
$markReadStmt->execute();

// Get messages between current user and the person
$stmt = $con->prepare("SELECT * FROM messages 
    WHERE (sender_id = ? AND receiver_id = ?) 
       OR (sender_id = ? AND receiver_id = ?) 
    ORDER BY timestamp ASC");

$stmt->bind_param("ssss", $currentUserId, $chatWithId, $chatWithId, $currentUserId);
$stmt->execute();
$result = $stmt->get_result();

// Output message HTML
while ($row = $result->fetch_assoc()) {
    $class = ($row['sender_id'] === $currentUserId) ? 'message message-personal new' : 'message new';
    echo '<div class="' . $class . '">';
    echo nl2br(htmlspecialchars($row['message']));
    echo '<div class="timestamp">' . date('h:i A', strtotime($row['timestamp'])) . '</div>';
    echo '</div>';
}
