<?php
session_start();
include 'minks1.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    http_response_code(403);
    exit;
}

$stmt = $con->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
$stmt->bind_param("s", $userId);
$stmt->execute();
echo "Marked as read";
